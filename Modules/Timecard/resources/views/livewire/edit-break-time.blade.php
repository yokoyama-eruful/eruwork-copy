<div>
  <button
    class="my-1 rounded border bg-white px-2 py-1 text-sm font-medium text-gray-700 hover:bg-slate-100 hover:text-blue-500"
    x-on:click.prevent="$dispatch('open-modal', 'create-break-time-{{ $breakTime->id }}')">
    <i class="fa-regular fa-pen-to-square"></i>
  </button>
  <x-modal name="create-break-time-{{ $breakTime->id }}" wire:model="showCreateDialog">
    <div class="flex items-center justify-between px-4 pt-4">
      <div>
        <h2 class="text-lg font-medium text-gray-900">
          休憩編集
        </h2>

        <p class="mt-1 text-sm text-gray-600">
          休憩を編集します。
        </p>
      </div>
      <form wire:submit="delete" method="post">
        @csrf
        @method('delete')
        <x-danger-button>削除</x-danger-button>
      </form>
    </div>

    <form class="p-4" wire:submit="add">
      <div class="mt-4">
        <x-input-label for="startTime" value="休憩開始" />

        <x-text-input class="mt-1 block w-full" id="startTime" name="startTime" type="time"
          wire:model="form.startTime" required />

        <x-input-error class="mt-2" :messages="$errors->userDeletion->get('startTime')" />
      </div>

      <div class="mt-2">
        <x-input-label for="endTime" value="休憩終了" />

        <x-text-input class="mt-1 block w-full" id="endTime" name="endTime" type="time" wire:model="form.endTime"
          required />

        <x-input-error class="mt-2" :messages="$errors->userDeletion->get('endTime')" />
      </div>

      @if (session('status'))
        <div class="font-normal text-red-500">
          {{ session('status') }}
        </div>
      @endif

      <div class="mt-6 flex justify-end">
        <x-secondary-button x-on:click="$dispatch('close')">
          {{ __('Cancel') }}
        </x-secondary-button>

        <x-primary-button class="ms-3">
          更新
        </x-primary-button>
      </div>

    </form>
  </x-modal>
</div>
