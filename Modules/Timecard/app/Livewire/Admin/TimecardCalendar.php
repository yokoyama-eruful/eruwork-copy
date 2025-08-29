<?php

declare(strict_types=1);

namespace Modules\Timecard\Livewire\Admin;

use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

class TimecardCalendar extends Component
{
    public User $user;

    public $year;

    public $month;

    public $day;

    public function mount()
    {
        $this->user = Auth::user();
        $this->year = now()->year;
        $this->month = now()->month;
        $this->day = now()->day;
    }

    #[Computed]
    public function daysInMonth()
    {
        if ($this->year && $this->month) {
            return CarbonImmutable::create($this->year, $this->month, 1)->daysInMonth;
        }

        return 31; // 初期値
    }

    public function selectUser(User $selectedUser)
    {
        $this->user = $selectedUser;
    }

    #[Computed]
    public function users()
    {
        return User::orderBy('id', 'asc')->paginate(10);
    }

    public function render()
    {
        return view('timecard::admin.timecard.livewire.index');
    }
}
