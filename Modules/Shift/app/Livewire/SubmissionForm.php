<?php

declare(strict_types=1);

namespace Modules\Shift\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Form;
use Modules\Shift\Models\DraftSchedule;

class SubmissionForm extends Form
{
    public ?int $id = null;

    public ?int $managerId = null;

    public ?int $userId = null;

    public ?string $date = null;

    public ?string $startTime;

    public ?string $endTime;

    public DraftSchedule $schedule;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'date' => [
                'required',
            ],
            'startTime' => [
                'required',
                'date_format:H:i',
            ],
            'endTime' => [
                'nullable',
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

    public function setData(DraftSchedule $draftSchedule)
    {
        $this->schedule = $draftSchedule;
        $this->userId = $draftSchedule->user_id;
        $this->date = $draftSchedule->date->format('Y-m-d');
        $this->id = $draftSchedule->id;
        $this->managerId = $draftSchedule->manager_id;
        $this->startTime = $draftSchedule->start_time?->format('H:i');
        $this->endTime = $draftSchedule->end_time?->format('H:i');
    }

    public function save(): void
    {
        $this->validate();

        DraftSchedule::create([
            'manager_id' => $this->managerId,
            'user_id' => Auth::id(),
            'date' => $this->date,
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
            'status' => '未承認',
        ]);

        $this->reset(['date', 'startTime', 'endTime']);
    }

    public function multiSave()
    {
        $this->validate();

        $dateArray = explode(', ', $this->date);

        $insertData = [];

        foreach ($dateArray as $date) {
            $insertData[] = [
                'manager_id' => $this->managerId,
                'user_id' => Auth::id(),
                'date' => $date,
                'start_time' => $this->startTime,
                'end_time' => $this->endTime,
                'status' => '未承認',
            ];
        }

        DraftSchedule::insert($insertData);

        $this->reset(['date',  'startTime', 'endTime']);
    }

    public function update(): void
    {
        $this->validate();

        $this->schedule->update(
            [
                'date' => $this->date,
                'start_time' => $this->startTime,
                'end_time' => $this->endTime,
            ]
        );
    }

    public function delete()
    {
        DraftSchedule::destroy($this->id);

        $this->reset(['date', 'startTime', 'endTime']);
    }
}
