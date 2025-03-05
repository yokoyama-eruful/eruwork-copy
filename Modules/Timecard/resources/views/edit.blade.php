<x-modal name="open-attendance-edit-modal">
  <div class="flex items-center justify-between px-4 pt-4">
    <div>
      <h2 class="text-lg font-medium text-gray-900">
        スケジュール編集
      </h2>

      <p class="mt-1 text-sm text-gray-600">
        スケジュールを編集します。
      </p>
    </div>
    <form id="delete-attendance-form" method="post">
      @csrf
      @method('delete')
      <x-danger-button>削除</x-danger-button>
    </form>
  </div>
  <form class="px-4 pb-4" id="edit-attendance-form" method="post">
    @csrf
    @method('PATCH')

    <div class="mt-4">
      <x-input-label for="date" value="日付" />

      <x-text-input class="mt-1 block w-full" id="date" name="date" type="date" value="" required />

      <x-input-error class="mt-2" :messages="$errors->userDeletion->get('date')" />
    </div>

    <div class="mt-4">
      <x-input-label for="in_time" value="開始時間" />

      <x-text-input class="mt-1 block w-full" id="in_time" name="in_time" type="time" value="" required />

      <x-input-error class="mt-2" :messages="$errors->userDeletion->get('in_time')" />
    </div>

    <div class="mt-2">
      <x-input-label for="out_time" value="終了時間" />

      <x-text-input class="mt-1 block w-full" id="out_time" name="out_time" type="time" value="" required />

      <x-input-error class="mt-2" :messages="$errors->userDeletion->get('out_time')" />
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
