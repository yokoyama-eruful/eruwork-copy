<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\Punch;

use Livewire\Attributes\On;
use Livewire\Component;
use Modules\Timecard\Enums\StampStatus;
use Modules\Timecard\Models\BreakTime;
use Modules\Timecard\Models\WorkTime;

class Member extends Component
{
    public $user;

    public $selectUser;

    public $buttonStatus;

    public function mount($user, $selectUser)
    {
        $this->buttonStatus();
        $this->user = $user;
        $this->selectUser = $selectUser;
    }

    #[On('statusUpdate')]
    public function buttonStatus()
    {
        $workTime = WorkTime::where('user_id', $this->user->id)
            ->whereNull('out_time')
            ->orderBy('in_time', 'desc')
            ->first();

        $breakTime = null;
        if ($workTime) {
            $breakTime = BreakTime::where('user_id', $this->user->id)
                ->where('timecard__work_time_id', $workTime->id)
                ->whereNull('out_time')
                ->orderBy('in_time', 'desc')
                ->first();
        }

        $this->buttonStatus = StampStatus::buttonStatus($workTime, $breakTime);
    }

    public function render()
    {
        return view('timecard::punch.livewire.member');
    }
}
