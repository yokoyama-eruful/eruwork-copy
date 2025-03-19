<x-modal name="schedule-edit-modal-{{ $schedule->id }}" title="予定編集">
  <div class="flex items-center justify-between px-4 pt-4">
    <div class="text-xl font-bold"> {{ $form->date }}</div>
    <form id="delete-schedule-form" wire:submit="delete">
      @csrf
      @method('delete')
      <x-danger-button>削除</x-danger-button>
    </form>
  </div>
  <form class="px-4 pb-4" id="edit-schedule-form" wire:submit="update">

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
