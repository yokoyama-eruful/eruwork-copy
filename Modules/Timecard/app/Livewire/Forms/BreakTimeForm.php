<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\Forms;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;
use Modules\Timecard\Models\BreakTime;

final class BreakTimeForm extends Form
{
    public ?int $attendanceId = null;

    public ?string $startTime = null;

    public ?string $endTime = null;

    public CarbonImmutable $date;

    public BreakTime $breakTime;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'startTime' => [
                'required',
                'date_format:H:i',
            ],
            'endTime' => [
                'nullable',
                'date_format:H:i',
                'after_or_equal:startTime',
            ],
        ];
    }

    public function validationAttributes()
    {
        return [
            'startTime' => '休憩開始時間',
            'endTime' => '休憩終了時間',
        ];
    }

    public function save($date): void
    {
        $this->validate();

        BreakTime::create([
            'attendance_id' => $this->attendanceId,
            'user_id' => Auth::id(),
            'date' => $date,
            'start_time' => $this->startTime,
            'end_time' => $this->endTime,
        ]);

        $this->reset(['startTime', 'endTime']);
    }

    public function setBreakTime(BreakTime $breakTime): void
    {
        $this->breakTime = $breakTime;
        $this->date = $breakTime->date;
        $this->startTime = $breakTime->start_time->format('H:i');
        $this->endTime = $breakTime->end_time?->format('H:i');
    }

    public function update(): void
    {
        $this->validate();

        $startTime = $this->startTime === '' ? null : $this->startTime;
        $endTime = $this->endTime === '' ? null : $this->endTime;

        $this->breakTime->update([
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);

        $this->reset(['attendanceId', 'startTime', 'endTime']);
    }

    public function delete(): void
    {
        $this->breakTime->delete();
    }
}
