<div>
  <button class="me-2 ml-auto cursor-pointer bg-gray-300 px-3 py-1 text-base font-medium"
    x-on:click="$dispatch('open-modal','create-dialog')">
    <i class="fa-solid fa-plus me-2 text-lg"></i>追加
  </button>
  <x-modal name="create-dialog" title="時給情報の追加">
    <form class="p-4" wire:submit="save" x-data="Datepickr()" x-init="initDatepickr">

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
