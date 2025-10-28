<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\Admin\Forms;

use Livewire\Form;
use Modules\Timecard\Models\WagePremium;

class CalculateSalaryForm extends Form
{
    public ?WagePremium $wagePremium = null;

    public $overtimeRate;

    public $nightRate;

    public function setValues($wagePremium)
    {
        $this->wagePremium = $wagePremium;
        $this->overtimeRate = $wagePremium?->overtime_rate;
        $this->nightRate = $wagePremium?->night_rate;
    }

    public function rules(): array
    {
        return [
            'overtimeRate' => ['required_without:nightRate'],
            'nightRate' => ['required_without:overtimeRate'],
        ];
    }

    public function attributes()
    {
        return [
            'overtimeRate' => '残業料金設定',
            'nightRate' => '深夜割増料金',
        ];
    }

    public function messages()
    {
        return [
            'overtimeRate.required_without' => '残業手当か夜間手当のどちらかを入力してください。',
            'nightRate.required_without' => '残業手当か夜間手当のどちらかを入力してください。',
        ];
    }

    public function create()
    {
        $this->validate();

        WagePremium::updateOrCreate(
            ['id' => $this->wagePremium?->id],
            [
                'overtime_rate' => ! empty($this->overtimeRate) ? $this->overtimeRate : 0,
                'night_rate' => ! empty($this->nightRate) ? $this->nightRate : 0,
            ]
        );
    }
}
