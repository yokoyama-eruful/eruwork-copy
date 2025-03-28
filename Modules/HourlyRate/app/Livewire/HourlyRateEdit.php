<?php

declare(strict_types=1);

namespace Modules\HourlyRate\Livewire;

use Livewire\Component;
use Modules\HourlyRate\Models\HourlyRate;

class HourlyRateEdit extends Component
{
    public int $userId;

    public HourlyRate $hourlyRate;

    public int $rate;

    public string $date;

    public function mount(): void
    {
        $this->rate = $this->hourlyRate->rate;

        $this->date = $this->hourlyRate->effective_date->format('Y-m-d');
    }

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

    public function update()
    {
        $this->validate();

        $this->hourlyRate->update([
            'rate' => $this->rate,
            'effective_date' => $this->date,
        ]);

        $this->dispatch('close-modal', 'edit-modal-' . $this->hourlyRate->id);
        $this->dispatch('reloadRate');
    }

    public function delete()
    {
        $this->hourlyRate->delete();

        $this->dispatch('close-modal', 'edit-modal-' . $this->hourlyRate->id);
        $this->dispatch('reloadRate');
    }

    public function render()
    {
        return view('hourlyrate::livewire.hourly-rate-edit');
    }
}
