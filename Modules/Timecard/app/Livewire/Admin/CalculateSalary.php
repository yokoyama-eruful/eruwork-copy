<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\Admin;

use Livewire\Component;
use Modules\Timecard\Livewire\Admin\Forms\CalculateSalaryForm;
use Modules\Timecard\Models\WagePremium;

class CalculateSalary extends Component
{
    // public $fraction;

    public $payUnit;

    public $overtimeRate;

    public $nightRate;

    public $startDate;

    public $endDate;

    public CalculateSalaryForm $form;

    public function mount()
    {
        $wagePremium = WagePremium::first();
        $this->overtimeRate = $wagePremium?->overtime_rate;
        $this->nightRate = $wagePremium?->night_rate;
        // $this->fraction = $wagePremium?->fraction;
        $this->payUnit = $wagePremium?->pay_unit;
        $this->form->setValues($wagePremium);
    }

    public function create()
    {
        $this->form->create();

        return to_route('attendanceManager.index', ['startDate' => $this->startDate, 'endDate' => $this->endDate]);
    }

    public function render()
    {
        return view('timecard::admin.attendance.livewire.calculate-salary');
    }
}
