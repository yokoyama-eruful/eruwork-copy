<div>
  <button class="x:mt-0 mt-2 rounded border border-ao-main bg-ao-sub px-2 hover:bg-ao-main" type="button"
    x-on:click="$dispatch('open-modal','multi-create-modal')"><i class="fa-regular fa-calendar-plus"></i> 複数日登録</button>
  <x-modal name="multi-create-modal" title="予定複数登録">
    <form class="p-4" method="post" wire:submit="add">
      @csrf

      <div class="mt-4">
        <x-input-label for="date" value="日付" />

        <x-text-input class="js-multiple-datepicker mt-1 block w-full" id="date" name="date" type="text"
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

      <div class="mt-4">
        <x-input-label for="title" value="タイトル" />

        <x-text-input class="mt-1 block w-full" id="title" name="title" type="text" wire:model="form.title"
          placeholder="タイトル" required />

        @error('form.title')
          <div class="font-normal text-red-500">{{ $message }}</div>
        @enderror
      </div>

      <div class="mt-2">
        <x-input-label for="description" value="説明" />

        <x-text-area class="mt-1 block w-full" id="description" name="description" type="text"
          wire:model="form.description" placeholder="説明"></x-text-area>

        @error('form.description')
          <div class="font-normal text-red-500">{{ $message }}</div>
        @enderror
      </div>

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
</div>
