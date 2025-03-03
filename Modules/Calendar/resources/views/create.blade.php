<x-modal name="open-schedule-create-modal" focusable>
  <form class="p-4" method="post" action="{{ route('calendar.store') }}">
    @csrf

    <h2 class="text-lg font-medium text-gray-900">
      スケジュール登録
    </h2>

    <p class="mt-1 text-sm text-gray-600">
      スケジュールを登録します。
    </p>

    <div class="mt-4">
      <x-input-label for="title" value="タイトル" />

      <x-text-input class="mt-1 block w-full" id="title" name="title" type="text" placeholder="タイトル" required />

      <x-input-error class="mt-2" :messages="$errors->userDeletion->get('title')" />
    </div>

    <div class="mt-2">
      <x-input-label for="description" value="説明" />

      <x-text-area class="mt-1 block w-full" id="description" name="description" type="text"
        placeholder="説明"></x-text-area>

      <x-input-error class="mt-2" :messages="$errors->userDeletion->get('description')" />
    </div>

    <div class="mt-4">
      <x-input-label for="start_date" value="開始日" />

      <x-text-input class="mt-1 block w-full" id="start_date" name="start_date" type="date" required />

      <x-input-error class="mt-2" :messages="$errors->userDeletion->get('start_date')" />
    </div>

    <div class="mt-2">
      <x-input-label for="end_date" value="終了日" />

      <x-text-input class="mt-1 block w-full" id="end_date" name="end_date" type="date" required />

      <x-input-error class="mt-2" :messages="$errors->userDeletion->get('end_date')" />
    </div>

    <div class="mt-4">
      <x-input-label for="start_time" value="開始時間" />

      <x-text-input class="mt-1 block w-full" id="start_time" name="start_time" type="time" required />

      <x-input-error class="mt-2" :messages="$errors->userDeletion->get('start_time')" />
    </div>

    <div class="mt-2">
      <x-input-label for="end_time" value="終了時間" />

      <x-text-input class="mt-1 block w-full" id="end_time" name="end_time" type="time" required />

      <x-input-error class="mt-2" :messages="$errors->userDeletion->get('end_time')" />
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
