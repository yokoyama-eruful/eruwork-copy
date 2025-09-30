<div>
  <button class="flex items-center space-x-[6px] hover:opacity-40" x-on:click="$dispatch('open-modal','create-modal')">
    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path
        d="M12.4615 6.75C12.4615 5.23521 11.86 3.78221 10.7889 2.71109C9.71779 1.63997 8.26479 1.03846 6.75 1.03846C5.23521 1.03846 3.78221 1.63997 2.71109 2.71109C1.63997 3.78221 1.03846 5.23521 1.03846 6.75C1.03846 7.50005 1.18615 8.24282 1.47318 8.93577C1.76021 9.62871 2.18073 10.2586 2.71109 10.7889C3.24144 11.3193 3.87129 11.7398 4.56423 12.0268C5.25718 12.3138 5.99995 12.4615 6.75 12.4615C7.50005 12.4615 8.24282 12.3138 8.93577 12.0268C9.62871 11.7398 10.2586 11.3193 10.7889 10.7889C11.3193 10.2586 11.7398 9.62871 12.0268 8.93577C12.3138 8.24282 12.4615 7.50005 12.4615 6.75ZM6.23077 8.82692V7.26923H4.67308C4.38631 7.26923 4.15385 7.03676 4.15385 6.75C4.15385 6.46324 4.38631 6.23077 4.67308 6.23077H6.23077V4.67308C6.23077 4.38631 6.46324 4.15385 6.75 4.15385C7.03676 4.15385 7.26923 4.38631 7.26923 4.67308V6.23077H8.82692C9.11369 6.23077 9.34615 6.46324 9.34615 6.75C9.34615 7.03676 9.11369 7.26923 8.82692 7.26923H7.26923V8.82692C7.26923 9.11369 7.03676 9.34615 6.75 9.34615C6.46324 9.34615 6.23077 9.11369 6.23077 8.82692ZM13.5 6.75C13.5 7.63642 13.3254 8.51436 12.9862 9.33331C12.647 10.1522 12.1499 10.8964 11.5231 11.5231C10.8964 12.1499 10.1522 12.647 9.33331 12.9862C8.51436 13.3254 7.63642 13.5 6.75 13.5C5.86358 13.5 4.98564 13.3254 4.16669 12.9862C3.34781 12.647 2.60361 12.1499 1.97686 11.5231C1.35011 10.8964 0.85304 10.1522 0.513822 9.33331C0.174603 8.51436 -1.21928e-08 7.63642 0 6.75C2.66762e-08 4.95979 0.710992 3.24273 1.97686 1.97686C3.24273 0.710993 4.95979 0 6.75 0C8.54021 0 10.2573 0.710993 11.5231 1.97686C12.789 3.24273 13.5 4.95979 13.5 6.75Z"
        fill="#3289FA" />
    </svg>
    <div class="text-sm font-bold text-[#3289FA]">時給を追加</div>
  </button>
  <x-modal name="create-modal" title="時給情報の追加">
    <form class="p-4" wire:submit="save" x-data="Datepickr()" x-init="initDatepickr">
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

      <div class="grid grid-cols-[20%,80%] items-center">
        <x-input-label for="rate" value="時給" />

        <x-text-input class="mt-1 block w-full" id="rate" name="rate" type="number" min="0"
          wire:model="rate" required />
      </div>

      <div class="mb-[30px] mt-4 grid grid-cols-[20%,80%] items-center">
        <x-input-label for="date" value="開始日" />

        <div class="relative mt-1">
          <x-text-input class="js-datepicker block w-full rounded border border-gray-300" id="date" name="date"
            type="text" wire:model="date" required />
          <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#3289FA]"
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
          登録
        </x-primary-button>
      </div>
    </form>
  </x-modal>
</div>
