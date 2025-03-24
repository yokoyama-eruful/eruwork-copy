<x-modal name="open-schedule-edit-modal">
  <div class="flex items-center justify-between px-4 pt-4">
    <div>
      <h2 class="text-lg font-medium text-gray-900">
        スケジュール編集
      </h2>

      <p class="mt-1 text-sm text-gray-600">
        スケジュールを編集します。
      </p>
    </div>
    <form id="delete-schedule-form" method="post">
      @csrf
      @method('delete')
      <x-danger-button>削除</x-danger-button>
    </form>
  </div>
  <form class="px-4 pb-4" id="edit-schedule-form" method="post">
    @csrf
    @method('PATCH')

    <div class="mt-4">
      <x-input-label for="title" value="タイトル" />

      <x-text-input class="mt-1 block w-full" id="title" name="title" type="text" value=""
        placeholder="タイトル" required />

      <x-input-error class="mt-2" :messages="$errors->userDeletion->get('title')" />
    </div>

    <div class="mt-2">
      <x-input-label for="description" value="説明" />

      <x-text-area class="mt-1 block w-full" id="description" name="description" type="text" value=""
        placeholder="説明"></x-text-area>

      <x-input-error class="mt-2" :messages="$errors->userDeletion->get('description')" />
    </div>

    <div class="mt-4">
      <x-input-label for="start_date" value="開始日" />

      <x-text-input class="js-datepicker mt-1 block w-full" id="start_date" name="start_date" type="text"
        value="" required />

      <x-input-error class="mt-2" :messages="$errors->userDeletion->get('start_date')" />
    </div>

    <div class="mt-2">
      <x-input-label for="end_date" value="終了日" />

      <x-text-input class="js-datepicker mt-1 block w-full" id="end_date" name="end_date" type="text" value=""
        required />

      <x-input-error class="mt-2" :messages="$errors->userDeletion->get('end_date')" />
    </div>

    <div class="mt-4">
      <x-input-label for="start_time" value="開始時間" />

      <x-text-input class="mt-1 block w-full" id="start_time" name="start_time" type="time" value=""
        required />

      <x-input-error class="mt-2" :messages="$errors->userDeletion->get('start_time')" />
    </div>

    <div class="mt-2">
      <x-input-label for="end_time" value="終了時間" />

      <x-text-input class="mt-1 block w-full" id="end_time" name="end_time" type="time" value="" required />

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
