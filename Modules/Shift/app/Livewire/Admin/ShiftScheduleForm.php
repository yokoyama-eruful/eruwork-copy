<?php

declare(strict_types=1);

namespace Modules\Shift\Livewire\Admin;

use App\Models\User;
use Carbon\CarbonImmutable;
use Livewire\Form;
use Modules\Shift\Models\Schedule;

final class ShiftScheduleForm extends Form
{
    public ?CarbonImmutable $date = null;

    public User $user;

    public ?int $userId = null;

    public ?string $startTime = null;

    public ?string $endTime = null;

    public Schedule $schedule;

    public function rules()
    {
        return [
            'userId' => [
                'required',
            ],
            'date' => [
                'required',
            ],
            'startTime' => [
                'required',
                'date_format:H:i',
            ],
            'endTime' => [
                'required',
                'date_format:H:i',
                'after:startTime',
            ],
        ];
    }

    public function validationAttributes()
    {
        return [
            'startTime' => '開始時間',
            'endTime' => '終了時間',
        ];
    }

    public function save(): void
    {
        $this->validate();

        $params = [
            'user_id' => $this->userId,
            'date' => $this->date,
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
        ];

        Schedule::create($params);

        $this->reset(['date', 'name', 'startTime', 'endTime']);
    }

    public function setSchedule(Schedule $schedule): void
    {
        $this->schedule = $schedule;
        $this->date = $schedule->date;
        $this->user = $schedule->user;
        $this->userId = $this->user->id;
        $this->startTime = $schedule->start_time->format('H:i');
        $this->endTime = $schedule->end_time->format('H:i');
    }

    public function update(): void
    {
        $this->validate();

        $this->schedule->update([
            'user_id' => $this->userId,
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
        ]);
    }

    public function delete(): void
    {
        if ($this->schedule->draftSchedule) {
            $this->schedule->draftSchedule->update([
                'status' => '未承認',
            ]);
        }

        $this->schedule->delete();
    }
}
