<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\Admin\Forms;

use App\Models\User;
use Carbon\CarbonImmutable;
use Livewire\Form;
use Modules\Timecard\Models\BreakTime;

class BreakTimeForm extends Form
{
    public $in_time;

    public $out_time;

    public ?User $user;

    public ?CarbonImmutable $date;

    public ?BreakTime $breakTime;

    public function setValues($breakTime)
    {
        $this->breakTime = $breakTime;
        $this->in_time = $breakTime->in_time->format('H:i');
        $this->out_time = $breakTime->out_time->format('H:i');
        $this->user = $breakTime->user;
        $this->date = $breakTime->date;
    }

    public function create()
    {
        $this->user->breakTime()->create([
            'date' => $this->date,
            'in_time' => $this->in_time,
            'out_time' => $this->out_time,
        ]);

        $this->reset(['in_time', 'out_time']);
    }

    public function update()
    {
        $this->breakTime->update([
            'in_time' => $this->in_time,
            'out_time' => $this->out_time,
        ]);
    }
}
