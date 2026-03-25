<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Account\Models\Profile;
use Modules\HourlyRate\Models\HourlyRate;
use Modules\Timecard\Models\BreakTime;
use Modules\Timecard\Models\Rule;
use Modules\Timecard\Models\WagePremium;
use Modules\Timecard\Models\WorkTime;
use Modules\Timecard\Services\WageCalculationService;
use Modules\Timecard\Support\WorkdayBoundary;
use Tests\TestCase;

class WageCalculationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        WorkdayBoundary::setCachedStartTime(null);
        WorkdayBoundary::setCachedStatutoryHolidayWeekday(null);
        WorkdayBoundary::setCachedHolidayWeekdays(null);
        WorkdayBoundary::setCachedHolidayDates(null);
        WorkdayBoundary::setCachedAnnualHolidayDates(null);
    }

    public function test_it_classifies_weekday_regular_and_late_night_overtime_minutes(): void
    {
        $user = $this->createPayrollUser();

        $workTime = WorkTime::create([
            'user_id' => $user->id,
            'in_time' => '2026-03-02 13:00:00',
            'out_time' => '2026-03-02 23:00:00',
        ]);

        BreakTime::create([
            'user_id' => $user->id,
            'timecard__work_time_id' => $workTime->id,
            'in_time' => '2026-03-02 17:00:00',
            'out_time' => '2026-03-02 18:00:00',
        ]);

        $summary = app(WageCalculationService::class)->summarize(
            $user,
            CarbonImmutable::parse('2026-03-01'),
            CarbonImmutable::parse('2026-03-31')
        );

        $this->assertSame([
            'regular' => 480,
            'overtime' => 0,
            'overtimeOver60' => 0,
            'night' => 0,
            'overtimeNight' => 60,
            'overtimeOver60Night' => 0,
            'holiday' => 0,
            'holidayNight' => 0,
        ], $summary['minutes']);
        $this->assertSame('11400', $summary['totalPay']);
    }

    public function test_it_treats_weekly_excess_over_40_hours_as_overtime(): void
    {
        $user = $this->createPayrollUser();

        foreach ([
            '2026-03-02',
            '2026-03-03',
            '2026-03-04',
            '2026-03-05',
            '2026-03-06',
        ] as $date) {
            WorkTime::create([
                'user_id' => $user->id,
                'in_time' => $date . ' 09:00:00',
                'out_time' => $date . ' 17:00:00',
            ]);
        }

        WorkTime::create([
            'user_id' => $user->id,
            'in_time' => '2026-03-07 10:00:00',
            'out_time' => '2026-03-07 14:00:00',
        ]);

        $summary = app(WageCalculationService::class)->summarize(
            $user,
            CarbonImmutable::parse('2026-03-01'),
            CarbonImmutable::parse('2026-03-31')
        );

        $this->assertSame([
            'regular' => 2400,
            'overtime' => 240,
            'overtimeOver60' => 0,
            'night' => 0,
            'overtimeNight' => 0,
            'overtimeOver60Night' => 0,
            'holiday' => 0,
            'holidayNight' => 0,
        ], $summary['minutes']);
        $this->assertSame('54000', $summary['totalPay']);
    }

    public function test_it_upgrades_weekday_overtime_beyond_60_monthly_hours(): void
    {
        $user = $this->createPayrollUser();

        foreach ([
            '2026-03-02',
            '2026-03-03',
            '2026-03-04',
            '2026-03-05',
            '2026-03-06',
            '2026-03-09',
            '2026-03-10',
            '2026-03-11',
            '2026-03-12',
            '2026-03-13',
            '2026-03-16',
            '2026-03-17',
            '2026-03-18',
            '2026-03-19',
            '2026-03-20',
            '2026-03-23',
        ] as $date) {
            WorkTime::create([
                'user_id' => $user->id,
                'in_time' => $date . ' 08:00:00',
                'out_time' => $date . ' 20:00:00',
            ]);
        }

        $summary = app(WageCalculationService::class)->summarize(
            $user,
            CarbonImmutable::parse('2026-03-01'),
            CarbonImmutable::parse('2026-03-31')
        );

        $this->assertSame([
            'regular' => 5520,
            'overtime' => 3600,
            'overtimeOver60' => 2400,
            'night' => 0,
            'overtimeNight' => 0,
            'overtimeOver60Night' => 0,
            'holiday' => 0,
            'holidayNight' => 0,
        ], $summary['minutes']);
        $this->assertSame('272400', $summary['totalPay']);
    }

    public function test_it_classifies_sunday_late_night_work_as_holiday_late_night_time(): void
    {
        $user = $this->createPayrollUser();

        WorkTime::create([
            'user_id' => $user->id,
            'in_time' => '2026-03-01 22:00:00',
            'out_time' => '2026-03-01 23:00:00',
        ]);

        $summary = app(WageCalculationService::class)->summarize(
            $user,
            CarbonImmutable::parse('2026-03-01'),
            CarbonImmutable::parse('2026-03-31')
        );

        $this->assertSame([
            'regular' => 0,
            'overtime' => 0,
            'overtimeOver60' => 0,
            'night' => 0,
            'overtimeNight' => 0,
            'overtimeOver60Night' => 0,
            'holiday' => 0,
            'holidayNight' => 60,
        ], $summary['minutes']);
        $this->assertSame('1920', $summary['totalPay']);
    }

    public function test_it_does_not_use_holiday_buckets_for_part_time_workers(): void
    {
        $user = $this->createPayrollUser('アルバイト');

        WorkTime::create([
            'user_id' => $user->id,
            'in_time' => '2026-03-01 22:00:00',
            'out_time' => '2026-03-01 23:00:00',
        ]);

        $summary = app(WageCalculationService::class)->summarize(
            $user,
            CarbonImmutable::parse('2026-03-01'),
            CarbonImmutable::parse('2026-03-31')
        );

        $this->assertSame([
            'regular' => 0,
            'overtime' => 0,
            'overtimeOver60' => 0,
            'night' => 60,
            'overtimeNight' => 0,
            'overtimeOver60Night' => 0,
            'holiday' => 0,
            'holidayNight' => 0,
        ], $summary['minutes']);
        $this->assertSame('1500', $summary['totalPay']);
    }

    public function test_it_uses_configured_workday_boundary_for_daily_overtime(): void
    {
        Rule::create([
            'rule' => 'personal',
            'workday_start_time' => '05:00:00',
        ]);

        $user = $this->createPayrollUser();

        $workTime = WorkTime::create([
            'user_id' => $user->id,
            'in_time' => '2026-03-02 15:00:00',
            'out_time' => '2026-03-03 04:00:00',
        ]);

        BreakTime::create([
            'user_id' => $user->id,
            'timecard__work_time_id' => $workTime->id,
            'in_time' => '2026-03-02 20:00:00',
            'out_time' => '2026-03-02 21:00:00',
        ]);

        $summary = app(WageCalculationService::class)->summarize(
            $user,
            CarbonImmutable::parse('2026-03-02'),
            CarbonImmutable::parse('2026-03-02')
        );

        $this->assertSame([
            'regular' => 360,
            'overtime' => 0,
            'overtimeOver60' => 0,
            'night' => 120,
            'overtimeNight' => 240,
            'overtimeOver60Night' => 0,
            'holiday' => 0,
            'holidayNight' => 0,
        ], $summary['minutes']);
        $this->assertSame('15300', $summary['totalPay']);
    }

    public function test_it_uses_configured_holiday_rate(): void
    {
        $user = $this->createPayrollUser();

        WagePremium::query()->update([
            'holiday_rate' => 40,
        ]);

        WorkTime::create([
            'user_id' => $user->id,
            'in_time' => '2026-03-01 22:00:00',
            'out_time' => '2026-03-01 23:00:00',
        ]);

        $summary = app(WageCalculationService::class)->summarize(
            $user,
            CarbonImmutable::parse('2026-03-01'),
            CarbonImmutable::parse('2026-03-31')
        );

        $this->assertSame('1980', $summary['totalPay']);
    }

    public function test_it_uses_configured_overtime_rate_for_minutes_beyond_60_hours(): void
    {
        $user = $this->createPayrollUser();

        WagePremium::query()->update([
            'overtime_over_60_rate' => 75,
        ]);

        foreach ([
            '2026-03-02',
            '2026-03-03',
            '2026-03-04',
            '2026-03-05',
            '2026-03-06',
            '2026-03-09',
            '2026-03-10',
            '2026-03-11',
            '2026-03-12',
            '2026-03-13',
            '2026-03-16',
            '2026-03-17',
            '2026-03-18',
            '2026-03-19',
            '2026-03-20',
            '2026-03-23',
        ] as $date) {
            WorkTime::create([
                'user_id' => $user->id,
                'in_time' => $date . ' 08:00:00',
                'out_time' => $date . ' 20:00:00',
            ]);
        }

        $summary = app(WageCalculationService::class)->summarize(
            $user,
            CarbonImmutable::parse('2026-03-01'),
            CarbonImmutable::parse('2026-03-31')
        );

        $this->assertSame('284400', $summary['totalPay']);
    }

    public function test_it_uses_configured_holiday_weekday(): void
    {
        Rule::create([
            'rule' => 'personal',
            'workday_start_time' => '00:00:00',
            'statutory_holiday_weekday' => CarbonImmutable::MONDAY,
            'holiday_weekdays' => [CarbonImmutable::MONDAY],
            'holiday_dates' => [],
            'annual_holiday_dates' => [],
        ]);

        $user = $this->createPayrollUser();

        WorkTime::create([
            'user_id' => $user->id,
            'in_time' => '2026-03-02 22:00:00',
            'out_time' => '2026-03-02 23:00:00',
        ]);

        $summary = app(WageCalculationService::class)->summarize(
            $user,
            CarbonImmutable::parse('2026-03-01'),
            CarbonImmutable::parse('2026-03-31')
        );

        $this->assertSame([
            'regular' => 0,
            'overtime' => 0,
            'overtimeOver60' => 0,
            'night' => 0,
            'overtimeNight' => 0,
            'overtimeOver60Night' => 0,
            'holiday' => 0,
            'holidayNight' => 60,
        ], $summary['minutes']);
    }

    public function test_it_uses_multiple_holiday_weekdays_and_specific_holiday_dates(): void
    {
        Rule::create([
            'rule' => 'personal',
            'workday_start_time' => '00:00:00',
            'statutory_holiday_weekday' => CarbonImmutable::SATURDAY,
            'holiday_weekdays' => [CarbonImmutable::SATURDAY, CarbonImmutable::SUNDAY],
            'holiday_dates' => ['2026-03-18'],
            'annual_holiday_dates' => [],
        ]);

        $user = $this->createPayrollUser();

        WorkTime::create([
            'user_id' => $user->id,
            'in_time' => '2026-03-14 22:00:00',
            'out_time' => '2026-03-14 23:00:00',
        ]);

        WorkTime::create([
            'user_id' => $user->id,
            'in_time' => '2026-03-18 22:00:00',
            'out_time' => '2026-03-18 23:00:00',
        ]);

        $summary = app(WageCalculationService::class)->summarize(
            $user,
            CarbonImmutable::parse('2026-03-01'),
            CarbonImmutable::parse('2026-03-31')
        );

        $this->assertSame(120, $summary['minutes']['holidayNight']);
    }

    public function test_it_supports_no_holidays_configured(): void
    {
        Rule::create([
            'rule' => 'personal',
            'workday_start_time' => '00:00:00',
            'statutory_holiday_weekday' => 0,
            'holiday_weekdays' => [],
            'holiday_dates' => [],
            'annual_holiday_dates' => [],
        ]);

        $user = $this->createPayrollUser();

        WorkTime::create([
            'user_id' => $user->id,
            'in_time' => '2026-03-01 22:00:00',
            'out_time' => '2026-03-01 23:00:00',
        ]);

        $summary = app(WageCalculationService::class)->summarize(
            $user,
            CarbonImmutable::parse('2026-03-01'),
            CarbonImmutable::parse('2026-03-31')
        );

        $this->assertSame(0, $summary['minutes']['holidayNight']);
        $this->assertSame(60, $summary['minutes']['night']);
    }

    public function test_it_uses_annual_holiday_dates(): void
    {
        Rule::create([
            'rule' => 'personal',
            'workday_start_time' => '00:00:00',
            'statutory_holiday_weekday' => 0,
            'holiday_weekdays' => [],
            'holiday_dates' => [],
            'annual_holiday_dates' => ['04-01'],
        ]);

        $user = $this->createPayrollUser();

        WorkTime::create([
            'user_id' => $user->id,
            'in_time' => '2026-04-01 22:00:00',
            'out_time' => '2026-04-01 23:00:00',
        ]);

        $summary = app(WageCalculationService::class)->summarize(
            $user,
            CarbonImmutable::parse('2026-04-01'),
            CarbonImmutable::parse('2026-04-30')
        );

        $this->assertSame(60, $summary['minutes']['holidayNight']);
    }

    private function createPayrollUser(?string $contractType = '正社員'): User
    {
        $user = User::factory()->create();

        Profile::create([
            'user_id' => $user->id,
            'name' => 'テストユーザー',
            'contract_type' => $contractType,
        ]);

        HourlyRate::create([
            'user_id' => $user->id,
            'rate' => 1200,
            'effective_date' => '2026-01-01',
        ]);

        WagePremium::create([
            'pay_unit' => 1,
            'overtime_rate' => 25,
            'overtime_over_60_rate' => 50,
            'night_rate' => 25,
            'holiday_rate' => 35,
        ]);

        return $user->fresh(['hourlyRate']);
    }
}
