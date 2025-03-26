<?php

declare(strict_types=1);

namespace Modules\Account\Livewire;

use App\Models\User;
use Livewire\Component;

class Widget extends Component
{
    public array $accountCountList;

    public function mount()
    {
        $this->accountCountList = [
            '発行済みアカウント数' => User::withTrashed()->count(),
            '利用中アカウント数' => User::count(),
        ];
    }

    public function render()
    {
        return view('account::livewire.widget');
    }
}
