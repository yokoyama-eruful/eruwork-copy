<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\Admin\Forms;

use App\Models\User;
use Carbon\CarbonImmutable;
use Livewire\Form;
use Modules\Timecard\Models\WorkTime;

class WorkTimeForm extends Form
{
    public $in_time;

    public $out_time;

    public ?User $user;

    public ?CarbonImmutable $date;

    public ?WorkTime $workTime;

    public function setValues($workTime)
    {
        $this->workTime = $workTime;
        $this->in_time = $workTime->in_time->format('H:i');
        $this->out_time = $workTime->out_time->format('H:i');
        $this->user = $workTime->user;
        $this->date = $workTime->date;
    }

    public function create()
    {
        $this->user->workTime()->create([
            'date' => $this->date,
            'in_time' => $this->in_time,
            'out_time' => $this->out_time,
        ]);

        $this->reset(['in_time', 'out_time']);
    }

    public function update()
    {
        $this->workTime->update([
            'in_time' => $this->in_time,
            'out_time' => $this->out_time,
        ]);
    }
}
