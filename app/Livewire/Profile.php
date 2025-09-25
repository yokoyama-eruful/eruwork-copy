<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Livewire\Forms\ProfileForm;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public ProfileForm $form;

    public function mount()
    {
        $user = Auth::user();
        $this->form->setValue($user);
    }

    public function update()
    {
        $this->form->update();

        if ($this->getErrorBag()->isEmpty()) {
            $this->dispatch('close', 'profile');
        }
    }

    public function render()
    {
        return view('livewire.profile');
    }
}
