<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\Forms;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;
use Livewire\Form;
use Modules\Timecard\Models\Attendance;

final class WorkTimeForm extends Form
{
    public ?string $inTime = null;

    public ?string $outTime = null;

    public CarbonImmutable $date;

    public Attendance $attendance;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'inTime' => [
                'required',
                'date_format:H:i',
            ],
            'outTime' => [
                'nullable',
                'date_format:H:i',
                'after:inTime',
            ],
        ];
    }

    public function validationAttributes()
    {
        return [
            'inTime' => '開始時間',
            'outTime' => '終了時間',
        ];
    }

    public function save($date): void
    {
        $this->validate();

        Attendance::create([
            'user_id' => Auth::id(),
            'date' => $date,
            'in_time' => $this->inTime,
            'out_time' => $this->outTime,
        ]);

        $this->reset(['inTime', 'outTime']);
    }

    public function setAttendance(Attendance $attendance): void
    {
        $this->attendance = $attendance;
        $this->date = $attendance->date;
        $this->inTime = $attendance->in_time->format('H:i');
        $this->outTime = $attendance->out_time?->format('H:i');
    }

    public function update(): void
    {
        $this->validate();

        $inTime = $this->inTime === '' ? null : $this->inTime;
        $outTime = $this->outTime === '' ? null : $this->outTime;

        $this->attendance->update([
            'in_time' => $inTime,
            'out_time' => $outTime,
        ]);

        $this->reset(['inTime', 'outTime']);
    }

    public function delete(): void
    {
        $this->attendance->delete();
    }
}
