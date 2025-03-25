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
    public ?int $userId = null;

    public User $user;

    public bool $showEditDialog = false;

    public function mount(): void
    {
        $this->user = User::find($this->userId);
    }

    public function update()
    {
        $this->form->update();

        $this->reset('showEditDialog');
    }

    public function delete()
    {
        $this->form->delete();

        $this->reset('showEditDialog');
    }

    #[Computed] #[On('reloadUsers')]
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
