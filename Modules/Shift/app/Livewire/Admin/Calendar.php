<?php

declare(strict_types=1);

namespace Modules\Shift\Livewire\Admin;

use App\Models\User;
use App\Notifications\WebPushNotification;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriodImmutable;
use Illuminate\Support\Facades\Request;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Modules\Shift\Models\DraftSchedule;
use Modules\Shift\Models\Manager;
use Modules\Shift\Models\Schedule;

class Calendar extends Component
{
    public Manager $manager;

    public CarbonImmutable $selectedDate;

    public ShiftScheduleForm $form;

    public $shifts;

    public $status = '提出済';

    public $draftStartTime;

    public $draftEndTime;

    public ?Schedule $selectedSchedule = null;

    public ?DraftSchedule $selectedDraft = null;

    #[Computed] #[On('refreshShiftTable')]
    public function calendar()
    {
        $start = $this->manager->start_date->startOfWeek(CarbonImmutable::MONDAY);
        $end = $this->manager->end_date->endOfWeek(CarbonImmutable::SUNDAY);

        // 1. 期間内のデータを一括取得（Eager LoadingでN+1を防止）
        $allShifts = Schedule::with(['draftSchedule', 'user'])
            ->whereBetween('date', [$this->manager->start_date, $this->manager->end_date])
            ->orderBy('start_time', 'asc')
            ->get()
            ->groupBy(fn ($item) => $item->date->format('Y-m-d'));

        $allDrafts = DraftSchedule::with(['shiftSchedule', 'user'])
            ->whereBetween('date', [$this->manager->start_date, $this->manager->end_date])
            ->where('status', '未承認')
            ->where('manager_id', $this->manager->id)
            ->whereHas('user.managers', function ($query) {
                $query->where('shift__manager_user.status', '提出済');
            })
            ->orderBy('start_time', 'asc')
            ->get()
            ->groupBy(fn ($item) => $item->date->format('Y-m-d'));

        // 2. 期間内の全日付を一旦「配列」として取得する
        $calendarViewTerm = CarbonPeriodImmutable::create($start, $end);
        $dates = $calendarViewTerm->toArray(); // ここで CarbonImmutable の配列になる

        $managerTerm = CarbonPeriodImmutable::create($this->manager->start_date, $this->manager->end_date);

        // 3. 配列に対して map を回す
        return collect($dates)->map(function (CarbonImmutable $date) use ($allShifts, $allDrafts, $managerTerm) {
            $dateStr = $date->format('Y-m-d');

            return [
                'date' => $date,
                'type' => $this->getDateType($managerTerm, $date),
                'shifts' => $allShifts->get($dateStr, collect()),
                'drafts' => $allDrafts->get($dateStr, collect()),
            ];
        })->all();
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

    private function getShifts($date)
    {
        return Schedule::with(['draftSchedule', 'user'])
            ->where('date', $date)
            ->orderBy('start_time', 'asc')
            ->get();
    }

    private function getDraftShifts($date)
    {
        return DraftSchedule::with(['shiftSchedule', 'user'])
            ->where('date', $date)
            ->where('status', '未承認')
            ->where('manager_id', $this->manager->id)
            ->whereHas('user.managers', function ($query) {
                $query->where('shift__manager_user.status', '提出済');
            })
            ->orderBy('start_time', 'asc')
            ->get();
    }

    public function save($date)
    {
        $date = CarbonImmutable::parse($date);

        $this->form->date = $date;
        $this->form->save();

        $this->dispatch('close-modal', 'create-modal');
        $this->reloadSchedule($date);
    }

    public function update(): void
    {
        $this->form->update();
        $this->dispatch('close-modal', 'edit-modal');
        $this->reloadSchedule($this->form->date);
    }

    public function reloadSchedule($date)
    {
        $date = CarbonImmutable::parse($date);

        $this->getShifts($date);
        $this->getDraftShifts($date);

        $this->dispatch('refreshShiftTable');
    }

    public function setDate($date)
    {
        $this->selectedDate = CarbonImmutable::parse($date);
        // $this->dispatch('open-modal', 'create-modal');
    }

    public function setSchedule($scheduleId)
    {
        $this->selectedSchedule = Schedule::find($scheduleId);
        if ($this->selectedSchedule) {
            $this->form->setSchedule($this->selectedSchedule);
            // $this->dispatch('open-modal', 'edit-modal');
        }
    }

    public function selectDraftShift($draftId)
    {
        $this->selectedDraft = DraftSchedule::with('user')->find($draftId);
        if ($this->selectedDraft) {
            $this->draftStartTime = $this->selectedDraft->start_time->format('H:i');
            $this->draftEndTime = $this->selectedDraft->end_time->format('H:i');
            // $this->dispatch('open-modal', 'confirm-shift-modal');
        }
    }

    public function upShift(int $draftId)
    {
        $draft = DraftSchedule::find($draftId);

        $params = [
            'user_id' => $draft->user_id,
            'shift__manager_id' => $draft->manager_id,
            'shift_draft_schedule_id' => $draft->id,
            'date' => $draft->date,
            'start_time' => $this->draftStartTime,
            'end_time' => $this->draftEndTime,
        ];

        Schedule::updateOrCreate(['shift_draft_schedule_id' => $draft->id], $params);

        $draft->update([
            'status' => '承認',
        ]);

        $this->dispatch('close-modal', 'confirm-shift-modal');

        $this->reloadSchedule($draft->date);
    }

    public function downShift($date)
    {
        $this->form->delete();
        $this->dispatch('close-modal', 'edit-modal');
        $this->selectedSchedule = null;
        $this->reloadSchedule($date);
    }

    public function getStatus($user, $managerId)
    {
        $manager = $user->managers()->where('shift_manager_id', $managerId)->first();

        return $manager?->pivot->status;
    }

    public function changeList($status)
    {
        $this->status = $status;
    }

    public function returnSubmission($userId, $managerId)
    {
        $user = User::find($userId);

        DraftSchedule::where('user_id', $userId)
            ->where('manager_id', $managerId)
            ->update([
                'status' => '未承認',
            ]);

        Schedule::where('shift__manager_id', $managerId)
            ->where('user_id', $userId)
            ->whereNotNull('shift_draft_schedule_id')
            ->delete();

        $user->managers()->updateExistingPivot($managerId, ['status' => '未提出']);

        $url = Request::getSchemeAndHttpHost() . '/shift/submission/' . $managerId;

        $user->notify(
            new WebPushNotification(
                title: 'エルフルサービス',
                message : 'シフトの提出が取り消されました。',
                image: '',
                url: $url,
            ));

        $admins = User::role('admin')->get();

        $adminMessage = $user->name . 'さんにシフト提出取り消し通知を送信しました。';

        foreach ($admins as $adminUser) {
            $adminUser->notify(
                new WebPushNotification(
                    title: 'エルフルサービス',
                    message: $adminMessage,
                    image: '',
                    url: $url,
                ));
        }
    }

    public function remindSubmission($userId, $managerId)
    {
        $user = User::find($userId);

        $formatMessage = 'シフトの提出依頼が届いています。';

        $url = Request::getSchemeAndHttpHost() . '/shift/submission/' . $managerId;

        $user->notify(
            new WebPushNotification(
                title: 'エルフルサービス',
                message : $formatMessage,
                image: '',
                url: $url,
            ));

        $admins = User::role('admin')->get();

        $adminMessage = $user->name . 'さんにシフト提出依頼通知を送信しました。';

        foreach ($admins as $adminUser) {
            $adminUser->notify(
                new WebPushNotification(
                    title: 'エルフルサービス',
                    message: $adminMessage,
                    image: '',
                    url: $url,
                ));
        }
    }

    public function render()
    {
        return view('shift::admin.livewire.calendar', [
            'users' => User::orderBy('id')->get(),
        ]);
    }
}
