<?php

declare(strict_types=1);

namespace Modules\HourlyRate\Livewire;

use Livewire\Component;
use Modules\HourlyRate\Models\WagePremium;

class WagePremiumsCreate extends Component
{
    public $morningPremium;

    public $morningStartTime;

    public $morningEndTime;

    public $nightPremium;

    public $nightStartTime;

    public $nightEndTime;

    public function mount()
    {
        $morningValue = WagePremium::where('name', '早朝')->first();

        $nightValue = WagePremium::where('name', '深夜')->first();

        $this->morningPremium = optional($morningValue)->rate;
        $this->morningStartTime = optional($morningValue)->start_time;
        $this->morningEndTime = optional($morningValue)->end_time;

        $this->nightPremium = optional($nightValue)->rate;
        $this->nightStartTime = optional($nightValue)->start_time;
        $this->nightEndTime = optional($nightValue)->end_time;
    }

    protected $validationAttributes = [
        'morningPremium' => '早朝割増率',
        'morningStartTime' => '早朝開始時間',
        'morningEndTime' => '早朝終了時間',
        'nightPremium' => '深夜割増率',
        'nightStartTime' => '深夜開始時間',
        'nightEndTime' => '深夜終了時間',
    ];

    public function messages()
    {
        return [
            'morningStartTime.required_with' => ':attribute は、早朝割増率または早朝終了時間が入力されている場合必須です。',
            'morningEndTime.required_with' => ':attribute は、早朝割増率または早朝開始時間が入力されている場合必須です。',
            'morningPremium.required_with' => ':attribute は、早朝開始時間または早朝終了時間が入力されている場合必須です。',

            'nightStartTime.required_with' => ':attribute は、深夜割増率または深夜終了時間が入力されている場合必須です。',
            'nightEndTime.required_with' => ':attribute は、深夜割増率または深夜開始時間が入力されている場合必須です。',
            'nightPremium.required_with' => ':attribute は、深夜開始時間または深夜終了時間が入力されている場合必須です。',
        ];
    }

    public function rules()
    {
        return [
            'morningPremium' => ['nullable', 'numeric', 'min:0', 'required_with:morningStartTime,morningEndTime'],
            'morningStartTime' => ['nullable', 'required_with:morningPremium,morningEndTime'],
            'morningEndTime' => ['nullable', 'required_with:morningPremium,morningStartTime'],

            'nightPremium' => ['nullable', 'numeric', 'min:0', 'required_with:nightStartTime,nightEndTime'],
            'nightStartTime' => ['nullable', 'required_with:nightPremium,nightEndTime'],
            'nightEndTime' => ['nullable', 'required_with:nightPremium,nightStartTime'],
        ];
    }

    public function save()
    {
        $this->validate();

        if ($this->morningPremium && $this->morningStartTime && $this->morningEndTime) {
            WagePremium::updateOrInsert(
                ['name' => '早朝'],
                [
                    'rate' => $this->morningPremium,
                    'start_time' => $this->morningStartTime,
                    'end_time' => $this->morningEndTime,
                ]
            );
        }

        if ($this->nightPremium && $this->nightStartTime && $this->nightEndTime) {
            WagePremium::updateOrInsert(
                ['name' => '深夜'],
                [
                    'rate' => $this->nightPremium,
                    'start_time' => $this->nightStartTime,
                    'end_time' => $this->nightEndTime,
                ]
            );
        }

        return to_route('hourlyRate.index');
    }

    public function render()
    {
        return view('hourlyrate::livewire.wage-premiums-create');
    }
}
