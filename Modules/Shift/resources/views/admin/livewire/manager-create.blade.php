<div>
  <button
    class='flex h-[35px] items-center rounded-[5px] bg-[#3289fa] px-5 py-2 text-sm font-bold text-[#fff] hover:bg-[#3289fa4d]'
    type="button" x-on:click="$dispatch('open-modal', 'manager-create-modal')">
    <img class="mr-[5px] h-[15px] w-[15px]" src="{{ asset('img/icon/add-schedule.png') }}" />
    シフト表を追加
  </button>
  <x-modal name="manager-create-modal" title="シフト表作成">
    <form class="px-[20px] pb-[20px] pt-[30px]" wire:submit="save">
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

      <div class="font-bold">シフト表</div>

      <div class="mt-[20px] grid grid-cols-[20%,80%] items-center">
        <x-input-label for="start_date" value="開始日" />

        <div class="relative w-full">
          <x-text-input class="js-datepicker mt-1 block w-full pr-10" id="start_date" name="start_date" type="text"
            wire:model="form.startDate" required />
          <svg class="pointer-events-none absolute right-3 top-1/2 h-[18px] w-[18px] -translate-y-1/2 text-[#3289FA]"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0
        002-2V7a2 2 0 00-2-2H5a2 2 0
        00-2 2v12a2 2 0 002 2z" />
          </svg>
        </div>
      </div>

      <div class="mb-[30px] mt-[10px] grid grid-cols-[20%,80%] items-center">
        <x-input-label for="end_date" value="終了日" />

        <div class="relative w-full">
          <x-text-input class="js-datepicker mt-1 block w-full pr-10" id="end_date" name="end_date" type="text"
            wire:model="form.endDate" required />
          <svg class="pointer-events-none absolute right-3 top-1/2 h-[18px] w-[18px] -translate-y-1/2 text-[#3289FA]"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0
        002-2V7a2 2 0 00-2-2H5a2 2 0
        00-2 2v12a2 2 0 002 2z" />
          </svg>
        </div>
      </div>

      <div class="mt-[20px] font-bold">シフト掲載期間</div>

      <div class="mt-[20px] grid grid-cols-[20%,80%] items-center">
        <x-input-label for="submission_start_date" value="開始日" />

        <div class="relative w-full">
          <x-text-input class="js-datepicker mt-1 block w-full pr-10" id="submission_start_date"
            name="submission_start_date" type="text" wire:model="form.submissionStartDate" required />
          <svg class="pointer-events-none absolute right-3 top-1/2 h-[18px] w-[18px] -translate-y-1/2 text-[#3289FA]"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0
        002-2V7a2 2 0 00-2-2H5a2 2 0
        00-2 2v12a2 2 0 002 2z" />
          </svg>
        </div>
      </div>

      <div class="mb-[40px] mt-[10px] grid grid-cols-[20%,80%] items-center">
        <x-input-label for="submission_end_date" value="終了日" />

        <div class="relative w-full">
          <x-text-input class="js-datepicker mt-1 block w-full pr-10" id="submission_end_date"
            name="submission_end_date" type="text" wire:model="form.submissionEndDate" required />
          <svg class="pointer-events-none absolute right-3 top-1/2 h-[18px] w-[18px] -translate-y-1/2 text-[#3289FA]"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0
        002-2V7a2 2 0 00-2-2H5a2 2 0
        00-2 2v12a2 2 0 002 2z" />
          </svg>
        </div>
      </div>

      <div class="-mx-4 -mb-4 mt-4 flex items-center justify-center rounded-b bg-white py-4">
        <x-secondary-button x-on:click="$dispatch('close')">
          {{ __('Cancel') }}
        </x-secondary-button>

        <x-primary-button class="ms-3">
          登 録
        </x-primary-button>
      </div>
    </form>
  </x-modal>
</div>
