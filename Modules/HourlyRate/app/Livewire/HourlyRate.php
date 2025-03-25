<?php

declare(strict_types=1);

namespace Modules\HourlyRate\Livewire;

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class HourlyRate extends Component
{
    #[Url(as: 'user_id')]
    public ?int $selectedId = null;

    public ?int $hourlyRate = null;

    public function selectUser(int $id)
    {
        $this->selectedId = $id;
    }

    #[Computed] #[On('reloadUsers')]
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
        return view('hourlyrate::livewire.hourly-rate');
    }
}
