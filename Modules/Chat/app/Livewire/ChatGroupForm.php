<?php

declare(strict_types=1);

namespace Modules\Chat\Livewire;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Form;
use Modules\Chat\Models\Group;

final class ChatGroupForm extends Form
{
    public $icon;

    public ?string $name = null;

    public array $member = [];

    public ?Group $group = null;

    public function rules()
    {
        $rules = [
            'icon' => ['nullable', 'image'],
            'name' => ['required', 'string', 'unique:chat__groups,name'],
        ];

        if ($this->group) {
            $rules['name'] = ['required', 'string', 'unique:chat__groups,name,' . $this->group?->id . ',id'];
        }

        return $rules;
    }

    public function validationAttributes()
    {
        return [
            'icon' => 'グループアイコン',
            'name' => 'グループ名',
            'member' => 'メンバー',
        ];
    }

    public function save(): void
    {
        $this->validate();

        $userIds = array_keys($this->member);

        if ($this->icon) {
            $manager = new ImageManager(new Driver);

            $filePath = $this->icon->getRealPath();

            $image = $manager->read($filePath);

            $base64 = $image->resize(100, 100)->toPng()->toDataUri();
        }

        $group = Group::create([
            'name' => $this->name,
            'icon' => $base64 ?? null,
            'is_dm' => false,
        ]);

        $group->users()->sync($userIds);

        $this->reset(['icon', 'name', 'member']);
    }

    public function setGroup($group): void
    {
        $this->group = $group;

        $this->icon = $group->icon;
        $this->name = $group->name;

        $this->member = $group->users->pluck('name', 'id')->toArray();
    }

    public function update(): void
    {
        $this->validate();

        $userIds = array_keys($this->member);

        if ($this->icon) {
            $manager = new ImageManager(new Driver);

            $filePath = $this->icon->getRealPath();

            $image = $manager->read($filePath);

            $base64 = $image->resize(100, 100)->toPng()->toDataUri();
        }

        $this->group->update([
            'name' => $this->name,
            'icon' => $base64 ?? null,
        ]);

        $this->group->users()->sync($userIds);
    }

    public function delete(): void
    {
        $this->group->delete();
    }
}
