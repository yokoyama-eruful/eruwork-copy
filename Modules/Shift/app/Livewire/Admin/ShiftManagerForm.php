<?php

declare(strict_types=1);

namespace Modules\Shift\Livewire\Admin;

use Livewire\Form;
use Modules\Shift\Models\Manager;
use Modules\Shift\Models\Schedule;

final class ShiftManagerForm extends Form
{
    public ?string $startDate = null;

    public ?string $endDate = null;

    public ?string $submissionStartDate = null;

    public ?string $submissionEndDate = null;

    public Schedule $schedule;

    public function rules()
    {
        return [
            'startDate' => [
                'required',
                'date_format:Y-m-d',
            ],
            'endDate' => [
                'required',
                'date_format:Y-m-d',
                'after:startDate',
            ],

            'submissionStartDate' => [
                'required',
                'date_format:Y-m-d',
            ],
            'submissionEndDate' => [
                'required',
                'date_format:Y-m-d',
                'after:submissionStartDate',
            ],
        ];
    }

    public function validationAttributes()
    {
        return [
            'startDate' => 'シフト表開始日',
            'endDate' => 'シフト表終了日',
            'submissionStartDate' => 'シフト募集開始日',
            'submissionEndDate' => 'シフト募集終了日',
        ];
    }

    public function save(): void
    {
        $this->validate();

        Manager::create([
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'submission_start_date' => $this->submissionStartDate,
            'submission_end_date' => $this->submissionEndDate,
        ]);

        $this->reset(['startDate', 'endDate', 'submissionStartDate', 'submissionEndDate']);
    }

    public function delete(): void
    {
        $this->schedule->delete();
    }
}
