<div>
  <button class="mt-2 rounded bg-gray-200 px-5 py-1 hover:bg-green-600 hover:text-white"
    x-on:click="$dispatch('open-modal','edit-modal-{{ $hourlyRate->id }}')">
    更　新
  </button>
  <x-modal name="edit-modal-{{ $hourlyRate->id }}" title="時給情報の編集">
    <form class="flex justify-end" wire:submit="delete">
      <button class="rounded px-2 py-1 text-red-600 hover:bg-red-600 hover:text-white" type="submit"
        onclick='return confirm("本当に削除しますか")'>
        <i class="fa-solid fa-trash me-1"></i>
        記録を削除
      </button>
    </form>

    <form class="p-4" wire:submit="update" x-data="Datepickr()" x-init="initDatepickr">

      <div class="mt-4">
        <x-input-label for="rate" value="時給" />

        <x-text-input class="mt-1 block w-full" id="rate" name="rate" type="number" min="0"
          wire:model="rate" required />

        @error('rate')
          <div class="font-normal text-red-500">{{ $message }}</div>
        @enderror
      </div>

      <div class="mt-4">
        <x-input-label for="date" value="開始日" />

        <x-text-input class="js-datepicker mt-1 block w-full" id="date" name="date" type="text"
          wire:model="date" required />

        @error('date')
          <div class="font-normal text-red-500">{{ $message }}</div>
        @enderror
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
