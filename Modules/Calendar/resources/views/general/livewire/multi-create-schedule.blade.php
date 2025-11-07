<div>
  <button
    class='flex h-[35px] items-center rounded-[5px] bg-[#3289fa] px-5 py-2 text-sm font-bold text-[#fff] hover:bg-[#3289fa4d]'
    type="button" x-on:click="$dispatch('open-modal','multi-create-modal')">
    <img class="mr-[5px] h-[15px] w-[15px]" src="{{ asset('img/icon/add-schedule.png') }}" />
    複数日登録
  </button>
  <x-modal name="multi-create-modal" title="予定複数登録">
    <form method="post" wire:submit="add">
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

      <div class="mb-[20px] mt-[20px] flex items-center">
        <x-input-label class="w-1/5" for="date" value="日付" />

        <div class="relative w-4/5">
          <x-text-input
            class="js-multiple-datepicker block w-full appearance-none rounded border border-gray-300 py-1 pl-3 pr-8"
            id="date" name="date" type="text" wire:model="form.date" required />
          <!-- カレンダーアイコン（青 #3289FA） -->
          <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#3289FA]"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0
        002-2V7a2 2 0 00-2-2H5a2 2 0
        00-2 2v12a2 2 0 002 2z" />
          </svg>
        </div>
      </div>

      <script>
        document.addEventListener('DOMContentLoaded', function() {
          function initializeFlatpickr() {
            let datepicker;

            datepicker = flatpickr('.js-multiple-datepicker', {
              locale: {
                ...flatpickr.l10ns.ja,
                "firstDayOfWeek": 1
              },
              mode: "multiple",
              dateFormat: 'Y-m-d',
            });
          }
          initializeFlatpickr();

          Livewire.on('reset-property', () => {
            initializeFlatpickr();
          });
        });
      </script>

      <div class="mb-[20px] flex items-center">
        <x-input-label class="w-1/5" value="時間" />

        <x-text-input class="w-[35%]" id="start_time" name="start_time" type="time" wire:model="form.startTime"
          required />

        <div class="px-[8px]">〜</div>

        <x-text-input class="w-[35%]" id="end_time" name="end_time" type="time" wire:model="form.endTime"
          required />
      </div>

      <div class="flex items-center">
        <x-input-label class="w-1/5" for="title" value="タイトル" />

        <x-text-input class="w-4/5" id="title" name="title" type="text" wire:model="form.title"
          placeholder="タイトル" required />
      </div>

      <div class="flex pt-[20px]">
        <x-input-label class="w-1/5 pt-2" for="description" value="説明" />

        <x-text-area class="mb-[20px] min-h-[130px] w-4/5" id="description" name="description" type="text"
          wire:model="form.description" placeholder="説明"></x-text-area>
      </div>
      <div class="-mx-4 -mb-[30px] mt-[30px] flex items-center justify-center rounded-b bg-white py-4">
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
