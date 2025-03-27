<?php

declare(strict_types=1);

namespace Modules\HourlyRate\Livewire;

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Modules\HourlyRate\Models\HourlyRate;

class HourlyRateShow extends Component
{
    public User $user;

    public function mount($selectedUser)
    {
        $this->user = $selectedUser;
    }

    public function update()
    {
        $this->form->update();
    }

    public function delete()
    {
        $this->form->delete();
    }

    #[Computed] #[On('reloadRate')]
    public function rateTable()
    {
        return
           HourlyRate::where('user_id', $this->user->id)
               ->orderBy('effective_date')
               ->get();
    }

    public function render()
    {
        return view('hourlyrate::livewire.hourly-rate-show');
    }
}
