<div>
  <button
    class='flex h-[35px] items-center rounded-[5px] bg-[#3289fa] px-5 py-2 text-sm font-bold text-[#fff] hover:bg-[#3289fa4d]'
    type="button" x-on:click="$dispatch('open-modal','multi-create-modal')">
    <img class="mr-[5px] h-[15px] w-[15px]" src="{{ global_asset('img/icon/add-schedule.png') }}" />
    複数日登録
  </button>
  <x-modal name="multi-create-modal" title="予定複数登録">
    <form class="px-[15px] py-5" id="multi-create-form" method="post" wire:submit="add">
      @csrf

      <div class="flex items-center">
        <x-input-label class="w-1/5" for="date" value="日付" />

        <x-text-input class="js-multiple-datepicker w-4/5" id="date" name="date" type="text"
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

      <div class="flex items-center">
        <x-input-label class="w-1/5" for="title" value="タイトル" />

        <x-text-input class="w-4/5" id="title" name="title" type="text" wire:model="form.title"
          placeholder="タイトル" required />

        @error('form.title')
          <div class="font-normal text-red-500">{{ $message }}</div>
        @enderror
      </div>

      <div class="flex pt-[11px]">
        <x-input-label class="w-1/5 pt-2" for="description" value="説明" />

        <x-text-area class="min-h-[110px] w-4/5" id="description" name="description" type="text"
          wire:model="form.description" placeholder="説明"></x-text-area>

        @error('form.description')
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
