{{-- <div>
  <button class="x:mt-0 mt-2 rounded border border-ao-main bg-ao-sub px-2 hover:bg-ao-main" type="button"
    x-on:click="$dispatch('open-modal','submission-multi-create-modal')"><i class="fa-regular fa-calendar-plus"></i>
    複数日登録</button>
  <x-modal name="submission-multi-create-modal" title="複数日登録">
    <form class="p-4" wire:submit="save">
      @csrf

      <div class="mt-4">
        <x-input-label for="date" value="日付" />

        <x-text-input class="js-multiple-term-datepicker mt-1 block w-full" id="date" name="date" type="text"
          min="{{ $manager->start_date->format('Y-m-d') }}" min="{{ $manager->end_date->format('Y-m-d') }}"
          wire:model="form.date" required />

        @error('form.date')
          <div class="font-normal text-red-500">{{ $message }}</div>
        @enderror
      </div>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          const startDate = @json($manager->start_date->format('Y-m-d'));
          const endDate = @json($manager->end_date->format('Y-m-d'));

          let datepicker;

          datepicker = flatpickr('.js-multiple-term-datepicker', {
            locale: {
              ...flatpickr.l10ns.ja,
              "firstDayOfWeek": 1
            },
            mode: "multiple",
            dateFormat: 'Y-m-d',
            minDate: startDate,
            maxDate: endDate,
          });

          Livewire.on('reset-property', function() {
            if (datepicker) {
              datepicker.clear();
            }
          });
        });
      </script>

      <div class="mt-4">
        <x-input-label for="start_time" value="開始時間" />

        <x-text-input class="mt-1 block w-full" id="start_time" name="start_time" type="time"
          wire:model="form.startTime" required />

        @error('form.startTime')
          <div class="font-normal text-red-500">{{ $message }}</div>
        @enderror
      </div>

      <div class="mt-2">
        <x-input-label for="end_time" value="終了時間" />

        <x-text-input class="mt-1 block w-full" id="end_time" name="end_time" type="time" wire:model="form.endTime"
          required />

        @error('form.endTime')
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
</div> --}}

<div>
  <button
    class='flex h-[35px] items-center rounded-[5px] bg-[#3289fa] px-5 py-2 text-sm font-bold text-[#fff] hover:bg-[#3289fa4d]'
    type="button" x-on:click="$dispatch('open-modal','multi-create-modal')">
    <img class="mr-[5px] h-[15px] w-[15px]" src="{{ global_asset('img/icon/add-schedule.png') }}" />
    複数日登録
  </button>
  <x-modal name="multi-create-modal" title="予定複数登録">
    <form class="px-[15px] py-5" id="multi-create-form" method="post" wire:submit="save">
      @csrf

      <div class="flex items-center">
        <x-input-label class="w-1/5" for="date" value="日付" />

        <x-text-input class="js-multiple-term-datepicker mt-1 block w-full" id="date" name="date" type="text"
          min="{{ $manager->start_date->format('Y-m-d') }}" min="{{ $manager->end_date->format('Y-m-d') }}"
          wire:model="form.date" required />

        @error('form.date')
          <div class="font-normal text-red-500">{{ $message }}</div>
        @enderror
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

      <div class="flex items-center">
        <x-input-label class="w-1/5" value="時間" />

        <x-text-input class="w-1/5" id="start_time" name="start_time" type="time" wire:model="form.startTime"
          required />

        <div class="px-[10px]">〜</div>

        <x-text-input class="w-1/5" id="end_time" name="end_time" type="time" wire:model="form.endTime" required />

        @error('form.startTime')
          <div class="font-normal text-red-500">{{ $message }}</div>
        @enderror
        @error('form.endTime')
          <div class="font-normal text-red-500">{{ $message }}</div>
        @enderror
      </div>

    </form>
    <x-slot:footer>
      <x-secondary-button x-on:click="$dispatch('close')">
        {{ __('Cancel') }}
      </x-secondary-button>

      <x-primary-button class="ms-3" form="multi-create-form">
        登録
      </x-primary-button>
    </x-slot:footer>
  </x-modal>
</div>
