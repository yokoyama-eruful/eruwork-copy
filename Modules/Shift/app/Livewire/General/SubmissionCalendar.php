<?php

declare(strict_types=1);

namespace Modules\Shift\Livewire\General;

use App\Models\User;
use App\Notifications\WebPushNotification;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriodImmutable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Modules\Shift\Models\DraftSchedule;
use Modules\Shift\Models\Manager;

class SubmissionCalendar extends Component
{
    public Manager $manager;

    public CarbonImmutable $selectedDate;

    #[Computed] #[On('SubmissionCalendarAllRefresh')]
    public function calendar()
    {
        $calendarViewTerm = CarbonPeriodImmutable::create(
            $this->manager->start_date->startOfWeek(CarbonImmutable::MONDAY),
            $this->manager->end_date->endOfWeek(CarbonImmutable::SUNDAY)
        );

        $mangerTerm = CarbonPeriodImmutable::create(
            $this->manager->start_date,
            $this->manager->end_date
        );

        $calendarContents =
            $calendarViewTerm
                ->map(function ($date) use ($mangerTerm) {
                    return [
                        'date' => $date,
                        'type' => $this->getDateType($mangerTerm, $date),
                        'draftShifts' => $this->getDraftShifts($date),
                    ];
                });

        return iterator_to_array($calendarContents);
    }

    private function getDateType($managerTerm, CarbonImmutable $date): string
    {
        // if ($holidays->where('date', $date)->isNotEmpty()) {
        //     return '公休日';
        // }

        if (! $managerTerm->contains($date)) {
            return '期間外';
        }

        return match ($date->dayOfWeek) {
            CarbonImmutable::SATURDAY => '土曜日',
            CarbonImmutable::SUNDAY => '日曜日',
            default => '平日',
        };
    }

    private function getDraftShifts($date)
    {
        return DraftSchedule::where('user_id', Auth::id())
            ->where('date', $date)
            ->where('manager_id', $this->manager->id)
            ->get();
    }

    public function submissionStatus($manager)
    {
        return $manager->users()
            ->wherePivot('user_id', Auth::id())
            ->first()?->pivot->status;
    }

    public function submission($managerId)
    {
        $manager = Manager::find($managerId);

        $manager->users()->updateExistingPivot(Auth::id(), [
            'status' => '提出済',
        ]);

        $admins = User::role('admin')->get();

        $formatMessage = Auth::user()->name . 'がシフトを提出しました。';

        $url = Request::getSchemeAndHttpHost() . '/shiftManager/' . $managerId;

        foreach ($admins as $user) {
            $user->notify(
                new WebPushNotification(
                    title: 'エルフルサービス',
                    message : $formatMessage,
                    image: '',
                    url: $url,
                ));
        }

        return to_route('shift.submission.show', ['manager' => $manager]);
    }

    public function render()
    {
        return view('shift::general.livewire.submission-calendar');
    }
}
