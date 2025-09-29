<x-modal name="view-group-create-modal">
  <form class="p-4" wire:submit="store" enctype="multipart/form-data">
    @csrf
    <x-slot:title>
      グループ作成
    </x-slot:title>

    @if ($errors->any())
      <div class="mb-4 rounded border border-red-300 bg-red-50 p-3 text-xs text-red-600">
        <ul class="list-disc pl-5">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div>
      <x-input-label for="icon" value="アイコン" />

      <x-text-input class="mt-1 block w-full" id="icon" name="icon" type="file" wire:model="form.icon" />
    </div>

    <div class="mt-2">
      <x-input-label for="name" value="グループ名" />

      <x-text-input class="mt-1 block w-full" id="name" name="name" type="text" placeholder="グループ名"
        wire:model="form.name" required />
    </div>

    <div class="mt-4">
      <div class="flex flex-col gap-2 text-black">
        <span class="text-xs font-semibold">メンバーの選択</span>
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

    <div class="-mx-4 -mb-4 mt-4 flex items-center justify-center rounded-b bg-white py-4">
      <x-secondary-button x-on:click="$dispatch('close')">
        {{ __('Cancel') }}
      </x-secondary-button>

      <x-primary-button class="ms-3">
        登録
      </x-primary-button>
    </div>
  </form>
</x-modal>
