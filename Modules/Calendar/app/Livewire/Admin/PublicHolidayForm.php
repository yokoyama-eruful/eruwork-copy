<?php

declare(strict_types=1);

namespace Modules\Calendar\Livewire\Admin;

use Carbon\CarbonImmutable;
use Livewire\Form;
use Modules\Calendar\Models\PublicHoliday;

final class PublicHolidayForm extends Form
{
    public ?string $date = null;

    public ?string $name = null;

    public PublicHoliday $publicHoliday;

    public function rules()
    {
        return [
            'date' => [
                'required',
            ],
            'name' => [
                'required',
            ],
        ];
    }

    public function resetProperty()
    {
        $this->reset(['date', 'name']);
    }

    public function save(): void
    {
        // TODO
        $this->validate();

        $dateArray = explode(', ', $this->date);
        $existingHolidayDates = PublicHoliday::whereIn('date', $dateArray)->pluck('date')->toArray();

        $updateData = [];
        $insertData = [];

        foreach ($dateArray as $date) {
            $data = [
                'date' => $date,
                'name' => $this->name,
            ];

            if (in_array(CarbonImmutable::parse($date), $existingHolidayDates)) {
                $updateData[] = $data;
            } else {
                $insertData[] = $data;
            }
        }

        if ($insertData) {
            PublicHoliday::insert($insertData);
        }

        foreach ($updateData as $data) {
            PublicHoliday::where('date', $data['date'])->update(['name' => $data['name']]);
        }

        $this->resetProperty();
    }

    public function setPublicHoliday(PublicHoliday $publicHoliday): void
    {
        $this->publicHoliday = $publicHoliday;
        $this->date = $publicHoliday->date->format('Y-m-d');
        $this->name = $publicHoliday->name;
    }

    public function update(): void
    {
        $this->validate();

        $this->publicHoliday->update([
            'name' => $this->name,
        ]);
    }

    public function delete(): void
    {
        $this->publicHoliday->delete();
    }
}
