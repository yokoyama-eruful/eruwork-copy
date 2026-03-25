<?php

declare(strict_types=1);

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Modules\Timecard\Models\Rule;
use Modules\Timecard\Models\TimecardUser;
use Modules\Timecard\Models\WagePremium;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rule = Rule::first();

        // $ruleがnullならデフォルトでpersonalにする
        if (! $rule) {
            $rule = new Rule;
            $rule->rule = 'personal';
            $rule->workday_start_time = '00:00:00';
            $rule->statutory_holiday_weekday = 0;
            $rule->holiday_weekdays = [];
            $rule->holiday_dates = [];
            $rule->annual_holiday_dates = [];
        }

        $wagePremium = WagePremium::first();

        $pin = '';

        if ($rule->rule === 'public') {
            $firstUser = TimecardUser::first();
            if ($firstUser) {
                $pin = Crypt::decryptString($firstUser->pin_encrypted);
            }
        }

        return view('setting::index', [
            'rule' => $rule,
            'wagePremium' => $wagePremium,
            'pin' => $pin,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request)
    // {
    //     DB::transaction(function () use ($request) {
    //         Rule::updateOrCreate(
    //             [],
    //             ['rule' => $request->rule],
    //         );

    //         WagePremium::updateOrCreate(
    //             [],
    //             [
    //                 'pay_unit' => $request->pay_unit,
    //                 'overtime_rate' => $request->overtimeRate ?? 0,
    //                 'night_rate' => $request->nightRate ?? 0,
    //             ],
    //         );

    //         $pin = mb_str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);

    //         TimecardUser::updateOrCreate(
    //             [],
    //             ['pin_encrypted' => Crypt::encryptString($pin)],
    //         );
    //     });

    //     return redirect()
    //         ->route('setting.index')
    //         ->with('success', '設定を更新しました');
    // }

    public function updatePunchSetting(Request $request)
    {
        DB::transaction(function () use ($request) {
            Rule::updateOrCreate(
                [],
                [
                    'rule' => $request->rule,
                ],
            );
        });

        $pin = mb_str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);

        TimecardUser::updateOrCreate(
            [],
            ['pin_encrypted' => Crypt::encryptString($pin)],
        );

        return redirect()
            ->route('setting.index')
            ->with('success', '打刻設定を更新しました');
    }

    public function updateWorkdaySetting(Request $request)
    {
        $request->validate([
            'workday_start_time' => ['required', 'date_format:H:i'],
            'holiday_weekdays' => ['nullable', 'array'],
            'holiday_weekdays.*' => ['integer', 'between:0,6'],
            'holiday_dates' => ['nullable', 'string'],
            'annual_holiday_dates' => ['nullable', 'string'],
        ], [], [
            'workday_start_time' => '1日の起算時刻',
            'holiday_weekdays' => '休日曜日',
            'holiday_dates' => '単発休日',
            'annual_holiday_dates' => '毎年休日',
        ]);

        $holidayWeekdays = array_values(array_unique(array_map('intval', $request->input('holiday_weekdays', []))));
        $holidayDates = collect(preg_split('/[\r\n,]+/', (string) $request->input('holiday_dates', '')))
            ->map(fn ($date) => trim((string) $date))
            ->filter()
            ->values()
            ->all();
        $annualHolidayDates = collect(preg_split('/[\r\n,]+/', (string) $request->input('annual_holiday_dates', '')))
            ->map(fn ($date) => trim((string) $date))
            ->filter()
            ->values()
            ->all();

        foreach ($holidayDates as $date) {
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) !== 1) {
                return back()
                    ->withErrors(['holiday_dates' => '単発休日は YYYY-MM-DD 形式で入力してください。'])
                    ->withInput();
            }
        }

        foreach ($annualHolidayDates as $date) {
            if (preg_match('/^\d{2}-\d{2}$/', $date) !== 1) {
                return back()
                    ->withErrors(['annual_holiday_dates' => '毎年休日は MM-DD 形式で入力してください。'])
                    ->withInput();
            }
        }

        $primaryHolidayWeekday = $holidayWeekdays[0] ?? 0;

        DB::transaction(function () use ($request, $holidayWeekdays, $holidayDates, $annualHolidayDates, $primaryHolidayWeekday) {
            Rule::updateOrCreate(
                [],
                [
                    'workday_start_time' => $request->workday_start_time . ':00',
                    'statutory_holiday_weekday' => $primaryHolidayWeekday,
                    'holiday_weekdays' => $holidayWeekdays,
                    'holiday_dates' => $holidayDates,
                    'annual_holiday_dates' => $annualHolidayDates,
                ],
            );
        });

        return redirect()
            ->route('setting.index')
            ->with('success', '勤務日設定を更新しました');
    }

    public function updatePayUnitSetting(Request $request)
    {
        $request->validate(
            [
                'overtimeRate' => ['nullable', 'integer', 'min:0'],
                'overtimeOver60Rate' => ['nullable', 'integer', 'min:0'],
                'nightRate' => ['nullable', 'integer', 'min:0'],
                'holidayRate' => ['nullable', 'integer', 'min:0'],
            ],
            [
                'overtimeRate.integer' => ':attributeは整数で入力してください',
                'overtimeOver60Rate.integer' => ':attributeは整数で入力してください',
                'nightRate.integer' => ':attributeは整数で入力してください',
                'holidayRate.integer' => ':attributeは整数で入力してください',
            ],
            [
                'overtimeRate' => '残業割増率',
                'overtimeOver60Rate' => '60h超残業割増率',
                'nightRate' => '深夜割増率',
                'holidayRate' => '法定休日割増率',
            ]
        );

        DB::transaction(function () use ($request) {
            WagePremium::updateOrCreate(
                [],
                [
                    'pay_unit' => $request->pay_unit,
                    'overtime_rate' => $request->overtimeRate ?? 0,
                    'overtime_over_60_rate' => $request->overtimeOver60Rate ?? 50,
                    'night_rate' => $request->nightRate ?? 0,
                    'holiday_rate' => $request->holidayRate ?? 35,
                ],
            );
        });

        return redirect()
            ->route('setting.index')
            ->with('success', '給与算出設定を更新しました');
    }
}
