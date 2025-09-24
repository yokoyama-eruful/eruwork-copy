<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\Admin\Forms;

use App\Models\User;
use Carbon\CarbonImmutable;
use Livewire\Form;
use Modules\Timecard\Models\BreakTime;

class BreakTimeForm extends Form
{
    public $in_date;

    public $out_date;

    public $in_time;

    public $out_time;

    public ?User $user = null;

    public ?CarbonImmutable $date;

    public ?BreakTime $breakTime;

    public function setValues($breakTime)
    {
        $this->breakTime = $breakTime;
        $this->in_date = $breakTime->in_time->format('Y-m-d');
        $this->out_date = $breakTime->out_time->format('Y-m-d');
        $this->in_time = $breakTime->in_time->format('H:i');
        $this->out_time = $breakTime->out_time->format('H:i');
        $this->user = $breakTime->user;
        $this->date = $breakTime->date;
    }

    public function rules(): array
    {
        return [
            'in_date' => ['required', 'date'],
            'in_time' => ['required', 'date_format:H:i'],
            'out_date' => ['required', 'date'],
            'out_time' => ['required', 'date_format:H:i'],
            // 開始<終了 & 勤務時間内チェックをまとめて実行
            'out_date' => [
                function ($attribute, $value, $fail) {
                    if (! $this->user || ! $this->in_date || ! $this->in_time || ! $this->out_date || ! $this->out_time) {
                        return;
                    }

                    $inDateTime = "{$this->in_date} {$this->in_time}";
                    $outDateTime = "{$this->out_date} {$this->out_time}";

                    // 開始 < 終了
                    if (strtotime($inDateTime) >= strtotime($outDateTime)) {
                        $fail('終了日時は開始日時より後にしてください。');

                        return;
                    }

                    // 勤務時間内かチェック
                    $workTime = $this->user->workTime()
                        ->where('in_time', '<=', $inDateTime)
                        ->where('out_time', '>=', $outDateTime)
                        ->first();

                    if (! $workTime) {
                        $fail('休憩時間は勤務時間内で設定してください。');

                        return;
                    }

                    // 既存の休憩時間と重なっていないかチェック
                    $conflict = $this->user->breakTime()
                        ->where(function ($query) use ($inDateTime, $outDateTime) {
                            $query->whereBetween('in_time', [$inDateTime, $outDateTime])
                                ->orWhereBetween('out_time', [$inDateTime, $outDateTime])
                                ->orWhere(function ($q) use ($inDateTime, $outDateTime) {
                                    $q->where('in_time', '<=', $inDateTime)
                                        ->where('out_time', '>=', $outDateTime);
                                });
                        })->exists();

                    if ($conflict) {
                        $fail('この時間帯には既に休憩が設定されています。');
                    }
                },
            ],

        ];
    }

    public function create()
    {
        $this->validate();

        $in_time = CarbonImmutable::parse($this->in_date . $this->in_time);
        $out_time = CarbonImmutable::parse($this->out_date . $this->out_time);

        $workTime = $this->user->workTime()
            ->where('in_time', '<=', $in_time)
            ->where('out_time', '>=', $out_time)
            ->first();

        $this->user->breakTime()->create([
            'in_time' => $in_time,
            'out_time' => $out_time,
            'timecard__work_time_id' => $workTime->id,
        ]);

        $this->reset(['in_time', 'out_time', 'in_date', 'out_date']);
    }

    public function update()
    {
        $this->validate();

        $in_time = CarbonImmutable::parse($this->in_date . $this->in_time);
        $out_time = CarbonImmutable::parse($this->out_date . $this->out_time);

        $workTime = $this->user->workTime()
            ->where('in_time', '<=', $in_time)
            ->where('out_time', '>=', $out_time)
            ->first();

        $this->breakTime->update([
            'in_time' => $in_time,
            'out_time' => $out_time,
            'timecard__work_time_id' => $workTime->id,
        ]);
    }
}
