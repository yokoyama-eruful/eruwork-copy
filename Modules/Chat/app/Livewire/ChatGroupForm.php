<?php

declare(strict_types=1);

namespace Modules\Chat\Livewire;

use Illuminate\Support\Facades\Auth;
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

    public function mount() {}

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

        $this->member[Auth::id()] = true;
        $userIds = array_keys($this->member);

        $base64 = $this->makeIcon($this->icon);

        $group = Group::create([
            'name' => $this->name,
            'icon' => $base64,
            'is_dm' => false,
        ]);

        $group->users()->sync($userIds);

        $this->reset(['icon', 'name', 'member']);
    }

    private function makeIcon($icon): ?string
    {
        if (is_null($this->icon)) {
            return null;
        }
        $manager = new ImageManager(new Driver);

        $filePath = $icon->getRealPath();

        $image = $manager->read($filePath);

        return $image->resize(100, 100)->toPng()->toDataUri();
    }

    public function setGroup($group): void
    {
        $this->group = $group;

        $this->icon = $group->icon;
        $this->name = $group->name;

        $this->member = $group->users->pluck('name', 'id')->toArray();
    }

    // public function update(): void
    // {
    //     $this->validate();

    //     $userIds = array_keys($this->member);

    //     $base64 = $this->makeIcon($this->icon);

    //     $this->group->update([
    //         'name' => $this->name,
    //         'icon' => $base64 ?? null,
    //     ]);

    //     $this->group->users()->sync($userIds);
    // }

    // public function delete(): void
    // {
    //     $this->group->delete();
    // }
}
