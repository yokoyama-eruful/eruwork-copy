<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\Admin\Forms;

use App\Models\User;
use Carbon\CarbonImmutable;
use Livewire\Form;
use Modules\Timecard\Models\WorkTime;

class WorkTimeForm extends Form
{
    public $in_date;

    public $out_date;

    public $in_time;

    public $out_time;

    public ?User $user;

    public ?CarbonImmutable $date;

    public ?WorkTime $workTime = null;

    public function setValues($workTime)
    {
        $this->workTime = $workTime;
        $this->in_date = $workTime->in_time?->format('Y-m-d');
        $this->out_date = $workTime->out_time?->format('Y-m-d');
        $this->in_time = $workTime->in_time?->format('H:i');
        $this->out_time = $workTime->out_time?->format('H:i');
        $this->user = $workTime->user;
        $this->date = $workTime->date;
    }

    public function rules(): array
    {
        return [
            'in_date' => ['required', 'date'],
            'in_time' => ['required', 'date_format:H:i'],
            'out_date' => ['required', 'date'],
            'out_time' => ['required', 'date_format:H:i'],

            // 開始 < 終了 と重複チェック
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

                    // 既存勤務時間と重なりチェック
                    $conflict = $this->user->workTime()
                        ->where(function ($query) use ($inDateTime, $outDateTime) {
                            $query->whereBetween('in_time', [$inDateTime, $outDateTime])
                                ->orWhereBetween('out_time', [$inDateTime, $outDateTime])
                                ->orWhere(function ($q) use ($inDateTime, $outDateTime) {
                                    $q->where('in_time', '<=', $inDateTime)
                                        ->where('out_time', '>=', $outDateTime);
                                });
                        })
                        ->when($this->workTime?->id, function ($query, $id) {
                            // 更新時は自分自身を除外
                            $query->where('id', '<>', $id);
                        })
                        ->exists();

                    if ($conflict) {
                        $fail('この時間帯には既に勤務が設定されています。');
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

        $this->user->workTime()->create([
            'in_time' => $in_time,
            'out_time' => $out_time,
        ]);

        $this->reset(['in_time', 'out_time']);
    }

    public function update()
    {
        $this->validate();

        $in_time = CarbonImmutable::parse($this->in_date . $this->in_time);
        $out_time = CarbonImmutable::parse($this->out_date . $this->out_time);

        $this->workTime->update([
            'in_time' => $in_time,
            'out_time' => $out_time,
        ]);
    }
}
