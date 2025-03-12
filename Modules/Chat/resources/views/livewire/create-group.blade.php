<x-modal name="view-group-create-dialog">
  <form wire:submit="store" enctype="multipart/form-data">
    <x-slot:title>
      グループ作成
    </x-slot:title>

    <div class="mt-4">
      <x-input-label for="icon" value="アイコン" />

      <x-text-input class="mt-1 block w-full" id="icon" name="icon" type="file" wire:model="form.icon" />

      @error('form.icon')
        <div class="text-sm font-normal text-red-500">{{ $message }}</div>
      @enderror
    </div>

    <div class="mt-2">
      <x-input-label for="name" value="グループ名" />

      <x-text-input class="mt-1 block w-full" id="name" name="name" type="text" placeholder="グループ名"
        wire:model="form.name" required />

      @error('form.name')
        <div class="text-sm font-normal text-red-500">{{ $message }}</div>
      @enderror
    </div>

    <div class="mt-4">
      <div class="flex flex-col gap-2 text-black">
        <span class="font-semibold">メンバーの選択</span>
        <div class="grid grid-cols-4 gap-3">
          @foreach ($this->users as $user)
            <label class="block cursor-pointer rounded border p-2 transition" x-data="{ checked: false }"
              :class="checked ? 'bg-sky-600 text-white' : 'bg-white'">
              <input class="hidden" type="checkbox" x-model="checked" wire:model="form.member.{{ $user->id }}">
              {{ $user->name }}
            </label>
          @endforeach
        </div>
      </div>
    </div>

    <div class="mt-6 flex justify-end">
      <x-secondary-button x-on:click="$dispatch('close')">
        {{ __('Cancel') }}
      </x-secondary-button>

      <x-primary-button class="ms-3">
        登録
      </x-primary-button>
    </div>
  </form>
</x-modal>
