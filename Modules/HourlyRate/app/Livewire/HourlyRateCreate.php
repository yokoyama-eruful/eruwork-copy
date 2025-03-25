<?php

declare(strict_types=1);

namespace Modules\HourlyRate\Livewire;

use App\Models\User;
use Carbon\CarbonImmutable;
use Livewire\Component;

class HourlyRateCreate extends Component
{
    public string $loginId;

    public User $user;

    public ?int $rate;

    public ?CarbonImmutable $date;

    public function rules()
    {
        return [
            'rate' => ['required', 'max:10'],
            'date' => ['required'],
        ];
    }

    public function validationAttributes()
    {
        return [
            'rate' => '時給',
            'date' => '開始日',
        ];
    }

    public function save()
    {
        $this->validate();

        $this->user
            ->hourlyRate()
            ->create(
                [
                    'rate' => $this->rate,
                    'effective_date' => $this->date,
                ]
            );

        $this->reset(['rate', 'date']);

        $this->dispatch('close-modal', 'create-dialog');

        $this->dispatch('reloadRate');
    }

    public function render()
    {
        return view('hourlyrate::livewire.hourly-rate-create');
    }
}
