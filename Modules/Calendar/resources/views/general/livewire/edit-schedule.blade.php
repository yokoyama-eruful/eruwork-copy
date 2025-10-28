<x-modal name="schedule-edit-modal-{{ $schedule->id }}" title="予定編集">
  <div class="flex items-center justify-between px-4 pt-4">
    <div class="text-xl font-bold"> {{ $form->date }}</div>
    <form wire:submit="delete">
      @csrf
      @method('delete')
      <x-danger-button>削除</x-danger-button>
    </form>
  </div>
  @if ($this->overlappingSchedules() || $this->overlappingShifts())
    <div><i class="fa-solid fa-circle-exclamation p-1 text-rose-600"></i>予定が重複しています</div>
  @endif
  <form class="p-4" wire:submit="update">

    <div class="grid grid-cols-[20%,80%] items-center">
      <x-input-label for="title" value="タイトル" />

      <x-text-input class="mt-1 block w-full" type="text" wire:model="form.title" placeholder="タイトル" required />

      <x-input-error class="mt-2" :messages="$errors->userDeletion->get('title')" />
    </div>

    <div class="mt-4 grid grid-cols-[20%,80%] items-center">
      <x-input-label for="description" value="説明" />

      <x-text-area class="mt-1 block w-full" type="text" wire:model="form.description"
        placeholder="説明"></x-text-area>

      <x-input-error class="mt-2" :messages="$errors->userDeletion->get('description')" />
    </div>

    <div class="mt-4 grid grid-cols-[20%,80%] items-center">
      <x-input-label for="start_time" value="開始時間" />

      <x-text-input class="mt-1 block w-full" type="time" wire:model="form.startTime" required />

      <x-input-error class="mt-2" :messages="$errors->userDeletion->get('start_time')" />
    </div>

    <div class="mt-4 grid grid-cols-[20%,80%] items-center">
      <x-input-label for="end_time" value="終了時間" />

      <x-text-input class="mt-1 block w-full" type="time" wire:model="form.endTime" required />

      <x-input-error class="mt-2" :messages="$errors->userDeletion->get('end_time')" />
    </div>
    <div class="-mx-4 -mb-4 mt-4 flex items-center justify-center rounded-b bg-white py-4">
      <x-secondary-button x-on:click="$dispatch('close')">
        {{ __('Cancel') }}
      </x-secondary-button>

      <x-primary-button class="ms-3">
        更新
      </x-primary-button>
    </div>
  </form>
</x-modal>
