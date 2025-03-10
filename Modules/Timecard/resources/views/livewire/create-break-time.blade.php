<div>
  <button class="bg-ao-main px-4 text-white" x-on:click.prevent="$dispatch('open-modal', 'create-break-time')">追加</button>
  <x-modal name="create-break-time" wire:model="showCreateDialog">
    <form class="p-4" wire:submit="add">
      <h2 class="text-lg font-medium text-gray-900">
        休憩登録
      </h2>

      <p class="mt-1 text-sm text-gray-600">
        休憩を登録します。
      </p>

      <div class="mt-4">
        <x-input-label for="startTime" value="開始時間" />

        <x-text-input class="mt-1 block w-full" id="startTime" name="startTime" type="time"
          wire:model="form.startTime" required />

        <x-input-error class="mt-2" :messages="$errors->userDeletion->get('startTime')" />
      </div>

      <div class="mt-2">
        <x-input-label for="endTime" value="終了時間" />

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
          登録
        </x-primary-button>
      </div>

    </form>
  </x-modal>
</div>
