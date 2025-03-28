<?php

declare(strict_types=1);

namespace Modules\Timecard\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        // TODO 使えてないから変更

        $rules = [
            'date' => [
                'required',
                'date_format:Y-m-d',
            ],
            'in_time' => [
                'required',
                'date_format:H:i',
            ],
            'out_time' => [
                'nullable',
                'date_format:H:i',
                'after:in_time',
            ],
        ];

        if ($this->has('start_time') && is_array($this->input('start_time')) && count($this->input('start_time')) > 0) {
            $rules['start_time'] = ['array'];
            $rules['start_time.*'] = ['required', 'date_format:H:i', 'after_or_equal:in_time'];
        }

        if ($this->has('end_time') && is_array($this->input('end_time')) && count($this->input('end_time')) > 0) {
            $rules['end_time'] = ['array'];
            $rules['end_time.*'] = [
                'required',
                'date_format:H:i',
                'after:start_time.*',
            ];

            if ($this->filled('out_time')) {
                $rules['end_time.*'][] = 'before_or_equal:out_time';
            }
        }

        // 休憩時間の重複チェック
        $rules['break_times'] = [function ($attribute, $value, $fail) {
            $startTimes = $this->input('start_time', []);
            $endTimes = $this->input('end_time', []);

            for ($i = 0; $i < count($startTimes); $i++) {
                for ($j = $i + 1; $j < count($startTimes); $j++) {
                    if (
                        ($startTimes[$i] < $endTimes[$j] && $endTimes[$i] > $startTimes[$j]) ||
                        ($startTimes[$j] < $endTimes[$i] && $endTimes[$j] > $startTimes[$i])
                    ) {
                        $fail("休憩時間が重複しています: {$startTimes[$i]} - {$endTimes[$i]} と {$startTimes[$j]} - {$endTimes[$j]}");
                    }
                }
            }
        }];

        return $rules;
    }
}
