<div>
  <button class="bg-ao-main px-4 text-white" x-on:click.prevent="$dispatch('open-modal', 'create-work-time')">追加</button>
  <x-modal name="create-work-time" wire:model="showCreateDialog">
    <form class="p-4" wire:submit="add">
      <h2 class="text-lg font-medium text-gray-900">
        勤怠登録
      </h2>

      <p class="mt-1 text-sm text-gray-600">
        勤怠を登録します。
      </p>

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
          登録
        </x-primary-button>
      </div>

    </form>
  </x-modal>
</div>
