<div>
  <button
    class="focus:shadow-outline rounded bg-blue-500 px-4 py-2 font-bold text-white hover:bg-blue-700 focus:outline-none"
    type="button" x-on:click="$dispatch('open-modal', 'edit-modal')">
    受付期間の編集
  </button>
  <x-modal name="edit-modal" title="シフト受付期間編集">
    <form wire:submit="update">
      @csrf

      @if ($errors->any())
        <div class="mb-4 rounded border border-red-300 bg-red-50 p-3 text-xs text-red-600">
          <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="mt-4">
        <x-input-label for="submission_start_date" value="開始日" />

        <x-text-input class="mt-1 block w-full" id="submission_start_date" name="submission_start_date" type="date"
          wire:model="form.submissionStartDate" required />
      </div>

      <div class="mt-2">
        <x-input-label for="submission_end_date" value="終了日" />

        <x-text-input class="mt-1 block w-full" id="submission_end_date" name="submission_end_date" type="date"
          wire:model="form.submissionEndDate" required />
      </div>

      <div class="-mx-4 -mb-[30px] mt-[30px] flex items-center justify-center rounded-b bg-white py-4">
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
