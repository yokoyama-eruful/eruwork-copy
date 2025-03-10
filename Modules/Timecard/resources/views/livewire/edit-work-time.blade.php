<div>
  <button
    class="my-1 rounded border bg-white px-2 py-1 text-sm font-medium text-gray-700 hover:bg-slate-100 hover:text-blue-500"
    x-on:click.prevent="$dispatch('open-modal', 'edit-work-time-{{ $attendance->id }}')">
    <i class="fa-regular fa-pen-to-square"></i>
  </button>
  <x-modal name="edit-work-time-{{ $attendance->id }}" wire:model="showEditDialog">
    <div class="flex items-center justify-between px-4 pt-4">
      <div>
        <h2 class="text-lg font-medium text-gray-900">
          勤怠編集
        </h2>
        <p class="mt-1 text-sm text-gray-600">
          勤怠を編集します。
        </p>
      </div>
      <form wire:submit="delete" method="post">
        @csrf
        @method('delete')
        <x-danger-button>削除</x-danger-button>
      </form>
    </div>

    <form class="px-4 pb-4" wire:submit="add">
      <div class="mt-4">
        <x-input-label for="inTime" value="開始時間" />

        <x-text-input class="mt-1 block w-full" id="inTime" name="inTime" type="time" wire:model="form.inTime"
          required />

        <x-input-error class="mt-2" :messages="$errors->userDeletion->get('inTime')" />
      </div>

      <div class="mt-2">
        <x-input-label for="outTime" value="終了時間" />

        <x-text-input class="mt-1 block w-full" id="outTime" name="outTime" type="time" wire:model="form.outTime"
          required />

        <x-input-error class="mt-2" :messages="$errors->userDeletion->get('outTime')" />
      </div>

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
