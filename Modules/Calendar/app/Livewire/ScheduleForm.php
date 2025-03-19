<?php

declare(strict_types=1);

namespace Modules\Calendar\Livewire;

use Livewire\Form;
use Modules\Calendar\Models\Schedule;

final class ScheduleForm extends Form
{
    public ?string $date = null;

    public ?string $title;

    public ?string $description = null;

    public int $userId;

    public ?string $startTime;

    public ?string $endTime;

    public Schedule $schedule;

    public function rules()
    {
        return [
            'title' => [
                'required',
            ],
            'description' => [
                'nullable',
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

    public function resetProperty()
    {
        $this->reset(['date', 'title', 'description', 'startTime', 'endTime']);
    }

    public function save(): void
    {
        $this->validate();

        $dateArray = explode(', ', $this->date);

        $insertData = [];

        foreach ($dateArray as $date) {
            $insertData[] = [
                'user_id' => $this->userId,
                'title' => $this->title,
                'description' => $this->description,
                'date' => $date,
                'start_time' => $this->startTime,
                'end_time' => $this->endTime,
            ];
        }

        Schedule::insert($insertData);

        $this->resetProperty();
    }

    public function setSchedule(Schedule $schedule): void
    {
        $this->schedule = $schedule;
        $this->date = $schedule->date->format('Y-m-d');
        $this->title = $schedule->title;
        $this->description = $schedule->description;

        $this->userId = $schedule->user->id;
        $this->startTime = $schedule->start_time->format('H:i');
        $this->endTime = $schedule->end_time->format('H:i');
    }

    public function update(): void
    {
        $this->validate();

        $this->schedule->update([
            'user_id' => $this->userId,
            'title' => $this->title,
            'description' => $this->description,
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
        ]);
    }

    public function delete(): void
    {
        $this->schedule->delete();
    }
}
