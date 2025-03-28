<div>
  <button
    class="flex cursor-pointer items-center space-x-1 rounded border border-hai-main px-6 py-1 text-base font-medium hover:bg-gray-200"
    type="button" x-on:click="$dispatch('open-modal', 'manager-create-modal')">
    <span>シフト表を追加する</span>
    <i class="fa-solid fa-plus rounded-full bg-ao-sub p-1 text-hai-main"></i>
  </button>
  <x-modal name="manager-create-modal" title="シフト表作成">
    <form class="p-4" wire:submit="save">
      <div class="mt-4">
        <x-input-label for="start_date" value="シフト表開始日" />

        <x-text-input class="js-datepicker mt-1 block w-full" id="start_date" name="start_date" type="text"
          wire:model="form.startDate" required />

        @error('form.startDate')
          <div class="font-normal text-red-500">{{ $message }}</div>
        @enderror
      </div>

      <div class="mt-2">
        <x-input-label for="end_date" value="シフト表終了日" />

        <x-text-input class="js-datepicker mt-1 block w-full" id="end_date" name="end_date" type="text"
          wire:model="form.endDate" required />

        @error('form.endDate')
          <div class="font-normal text-red-500">{{ $message }}</div>
        @enderror
      </div>

      <div class="mt-4">
        <x-input-label for="submission_start_date" value="シフト表掲載開始日" />

        <x-text-input class="js-datepicker mt-1 block w-full" id="submission_start_date" name="submission_start_date"
          type="text" wire:model="form.submissionStartDate" required />

        @error('form.submissionStartDate')
          <div class="font-normal text-red-500">{{ $message }}</div>
        @enderror
      </div>

      <div class="mt-2">
        <x-input-label for="submission_end_date" value="シフト表掲載終了日" />

        <x-text-input class="js-datepicker mt-1 block w-full" id="submission_end_date" name="submission_end_date"
          type="text" wire:model="form.submissionEndDate" required />

        @error('form.submissionEndDate')
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
