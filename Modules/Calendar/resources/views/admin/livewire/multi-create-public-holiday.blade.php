<div>
  <button class="rounded border border-ao-main bg-ao-sub px-2 hover:bg-ao-main" type="button"
    x-on:click="$dispatch('open-modal','multi-create-dialog')">複数日登録</button>
  <x-modal name="multi-create-dialog" title="予定複数登録">
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
        <x-input-label for="name" value="公休日名" />

        <x-text-input class="mt-1 block w-full" id="name" name="name" type="text" wire:model="form.name"
          placeholder="公休日名" required />

        @error('form.name')
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
