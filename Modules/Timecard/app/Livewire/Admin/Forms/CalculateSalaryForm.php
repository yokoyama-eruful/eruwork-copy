<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\Admin\Forms;

use Livewire\Form;
use Modules\Timecard\Models\WagePremium;

class CalculateSalaryForm extends Form
{
    public ?WagePremium $wagePremium = null;

    // public $fraction;

    public $payUnit;

    public $overtimeRate;

    public $overtimeOver60Rate;

    public $nightRate;

    public $holidayRate;

    public function setValues($wagePremium)
    {
        $this->wagePremium = $wagePremium;
        // $this->fraction = $wagePremium?->fraction;
        $this->payUnit = $wagePremium?->pay_unit;
        $this->overtimeRate = $wagePremium?->overtime_rate;
        $this->overtimeOver60Rate = $wagePremium?->overtime_over_60_rate ?? 50;
        $this->nightRate = $wagePremium?->night_rate;
        $this->holidayRate = $wagePremium?->holiday_rate ?? 35;
    }

    public function rules(): array
    {
        return [
            'overtimeRate' => ['nullable', 'integer', 'min:0', 'required_without:nightRate'],
            'nightRate' => ['nullable', 'integer', 'min:0', 'required_without:overtimeRate'],
            'overtimeOver60Rate' => ['nullable', 'integer', 'min:0'],
            'holidayRate' => ['nullable', 'integer', 'min:0'],
        ];
    }

    public function attributes()
    {
        return [
            'overtimeRate' => '残業料金設定',
            'nightRate' => '深夜割増料金',
            'overtimeOver60Rate' => '60h超残業設定',
            'holidayRate' => '法定休日設定',
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
                // 'fraction' => $this->fraction,
                'pay_unit' => $this->payUnit,
                'overtime_rate' => ! empty($this->overtimeRate) ? $this->overtimeRate : 0,
                'overtime_over_60_rate' => ! empty($this->overtimeOver60Rate) ? $this->overtimeOver60Rate : 50,
                'night_rate' => ! empty($this->nightRate) ? $this->nightRate : 0,
                'holiday_rate' => ! empty($this->holidayRate) ? $this->holidayRate : 35,
            ]
        );
    }
}
