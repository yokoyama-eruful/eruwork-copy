{{-- <x-dialog wire:model="showCreateDialog">
  <x-dialog.open>
    <button class="flex h-8 w-8 items-center justify-center rounded border bg-white text-black hover:bg-gray-200">
      <i class="fa-solid fa-plus"></i>
    </button>
  </x-dialog.open>
  <x-dialog.panel icon="グループの作成">
    <form class="flex flex-col" wire:submit.prevent="add" enctype="multipart/form-data" x-data="{ iconPreview: null }">
      <label class="flex items-center gap-x-4 py-4 text-black">
        <span class="w-24 whitespace-nowrap">アイコン</span>
        <input
          class="flex-1 rounded-lg border border-slate-300 px-3 py-2 font-normal read-only:cursor-not-allowed read-only:opacity-50"
          type="file" wire:model="form.icon"
          @change="iconPreview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
        <template x-if="iconPreview">
          <img class="flex h-14 w-14 items-center justify-center overflow-hidden rounded-full border border-gray-400"
            alt="Icon Preview" :src="iconPreview" />
        </template>
      </label>
      @error('form.icon')
        <div class="text-sm font-normal text-red-500">{{ $message }}</div>
      @enderror

      <label class="flex items-center gap-x-4 py-4 text-black">
        <span class="w-24 whitespace-nowrap">グループ名</span>
        <input
          class="flex-1 rounded-lg border border-slate-300 px-3 py-2 font-normal read-only:cursor-not-allowed read-only:opacity-50"
          type="text" wire:model="form.name">
      </label>
      @error('form.name')
        <div class="text-sm font-normal text-red-500">{{ $message }}</div>
      @enderror

      <div class="flex flex-col gap-2 text-black">
        <span class="font-semibold">メンバーの選択</span>
        <div class="grid grid-cols-4 gap-3">
          @foreach ($users as $user)
            <button type="button" @class([
                'flex cursor-pointer items-center justify-between rounded-lg border p-2',
                'bg-blue-500 text-white' => array_key_exists($user->id, $selectedUsers),
            ]) wire:click="toggleUser({{ $user->id }})">
              <span>{{ $user->name }}</span>
            </button>
          @endforeach
        </div>
      </div>

      <x-dialog.footer>
        <x-dialog.submit>
          作　成
        </x-dialog.submit>
        <x-dialog.cancel>
          キャンセル
        </x-dialog.cancel>
      </x-dialog.footer>
    </form>
  </x-dialog.panel>
</x-dialog> --}}

<x-modal name="view-group-create-dialog" wire:submit="store" enctype="multipart/form-data">
  <div class="p-4">
    <h2 class="text-lg font-medium text-gray-900">
      グループ作成
    </h2>

    <p class="mt-1 text-sm text-gray-600">
      グループを作成します。
    </p>

    <div class="mt-4">
      <x-input-label for="icon" value="アイコン" />

      <x-text-input class="mt-1 block w-full" id="icon" name="icon" type="file" wire:model="form.icon" />

      @error('form.icon')
        <div class="text-sm font-normal text-red-500">{{ $message }}</div>
      @enderror
    </div>

    <div class="mt-2">
      <x-input-label for="name" value="グループ名" />

      <x-text-area class="mt-1 block w-full" id="name" name="name" type="text" placeholder="グループ名"
        wire:model="form.name"></x-text-area>

      @error('form.name')
        <div class="text-sm font-normal text-red-500">{{ $message }}</div>
      @enderror
    </div>

    <div class="mt-4">
      <div class="flex flex-col gap-2 text-black">
        <span class="font-semibold">メンバーの選択</span>
        <div class="grid grid-cols-4 gap-3">
          @foreach ($this->users as $user)
            <div @class([
                'flex cursor-pointer items-center justify-between rounded-lg border p-2',
                'bg-blue-500 text-white' => array_key_exists($user->id, $selectedUsers),
            ])>
              <input class="form-checkbox" type="checkbox" wire:model="selectedUsers.{{ $user->id }}">
              <span>{{ $user->name }}</span>
            </div>
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
  </div>
</x-modal>
