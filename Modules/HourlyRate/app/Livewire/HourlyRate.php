<?php

declare(strict_types=1);

namespace Modules\HourlyRate\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class HourlyRate extends Component
{
    #[Url(as: 'user_id')]
    public ?int $selectedId = null;

    public ?User $selectedUser;

    public ?int $hourlyRate = null;

    public function mount()
    {
        $this->selectedUser = Auth::user();
    }

    public function selectUser(int $id)
    {
        $this->selectedId = $id;
        $this->selectedUser =
            $this->users
                ->where('id', $id)
                ->first();
    }

    public function refreshUser()
    {
        $this->selectedId = null;
        $this->selectedUser = null;
    }

    #[Computed] #[On('reloadRate')]
    public function users()
    {
        return User::orderBy('id')->get();
    }

    #[Computed]
    public function selectedUser()
    {
        return
            User::with('hourlyRate')
                ->find($this->selectedId);
    }

    public function render()
    {
        $agent = new Agent;

        return $agent->isMobile() || $agent->isTablet()
               ? view('hourlyrate::livewire.mobile-hourly-rate')
               : view('hourlyrate::livewire.desktop-hourly-rate');
    }
}
