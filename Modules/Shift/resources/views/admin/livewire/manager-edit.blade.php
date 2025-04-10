<div>
  <button
    class="focus:shadow-outline rounded bg-blue-500 px-4 py-2 font-bold text-white hover:bg-blue-700 focus:outline-none"
    type="button" x-on:click="$dispatch('open-modal', 'edit-modal')">
    受付期間の編集
  </button>
  <x-modal name="edit-modal" title="シフト受付期間編集">
    <form class="p-4" wire:submit="update">
      @csrf
      <div class="mt-4">
        <x-input-label for="submission_start_date" value="開始日" />

        <x-text-input class="mt-1 block w-full" id="submission_start_date" name="submission_start_date" type="date"
          wire:model="form.submissionStartDate" required />

        @error('form.submissionStartDate')
          <div class="font-normal text-red-500">{{ $message }}</div>
        @enderror
      </div>

      <div class="mt-2">
        <x-input-label for="submission_end_date" value="終了日" />

        <x-text-input class="mt-1 block w-full" id="submission_end_date" name="submission_end_date" type="date"
          wire:model="form.submissionEndDate" required />

        @error('form.submissionEndDate')
          <div class="font-normal text-red-500">{{ $message }}</div>
        @enderror
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
</div>
