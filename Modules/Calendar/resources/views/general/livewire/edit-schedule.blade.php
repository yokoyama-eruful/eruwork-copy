<x-modal name="schedule-edit-modal-{{ $schedule->id }}" title="予定編集" maxWidth="lg">
  <div class="flex items-center justify-between px-4 pt-4">
    <div class="text-xl font-bold"> {{ $form->date }}</div>
    <form id="delete-schedule-form" wire:submit="delete">
      @csrf
      @method('delete')
      <x-danger-button>削除</x-danger-button>
    </form>
  </div>
  @if ($this->overlappingSchedules() || $this->overlappingShifts())
    <div><i class="fa-solid fa-circle-exclamation p-1 text-rose-600"></i>予定が重複しています</div>
  @endif
  <form class="px-4 pb-4" id="edit-form-{{ $schedule->id }}" id="edit-schedule-form" wire:submit="update">

    <div class="mt-4">
      <x-input-label for="title" value="タイトル" />

      <x-text-input class="mt-1 block w-full" id="title" name="title" type="text" wire:model="form.title"
        placeholder="タイトル" required />

      <x-input-error class="mt-2" :messages="$errors->userDeletion->get('title')" />
    </div>

    <div class="mt-2">
      <x-input-label for="description" value="説明" />

      <x-text-area class="mt-1 block w-full" id="description" name="description" type="text"
        wire:model="form.description" placeholder="説明"></x-text-area>

      <x-input-error class="mt-2" :messages="$errors->userDeletion->get('description')" />
    </div>

    <div class="mt-4">
      <x-input-label for="start_time" value="開始時間" />

      <x-text-input class="mt-1 block w-full" id="start_time" name="start_time" type="time"
        wire:model="form.startTime" required />

      <x-input-error class="mt-2" :messages="$errors->userDeletion->get('start_time')" />
    </div>

    <div class="mt-2">
      <x-input-label for="end_time" value="終了時間" />

      <x-text-input class="mt-1 block w-full" id="end_time" name="end_time" type="time" wire:model="form.endTime"
        required />

      <x-input-error class="mt-2" :messages="$errors->userDeletion->get('end_time')" />
    </div>
  </form>
  <x-slot:footer>
    <x-secondary-button x-on:click="$dispatch('close')">
      {{ __('Cancel') }}
    </x-secondary-button>

    <x-primary-button class="ms-3" form="edit-form-{{ $schedule->id }}">
      更新
    </x-primary-button>
  </x-slot:footer>
</x-modal>
