<x-modal name="create-work-time-modal-{{ $user->id }}" :title="'勤務時間作成'">
  <form class="px-[20px] pb-[20px] pt-[30px]" wire:submit="storeWorkTime">

    @if ($errors->any())
      <div class="mb-4 rounded bg-red-100 p-3 text-red-700">
        <ul class="list-inside list-disc">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="mt-[20px] grid grid-cols-[20%,80%] items-center">
      <x-input-label for="in-date" value="開始日付" />

      <div class="relative w-full">
        <x-text-input class="js-datepicker mt-1 block w-full pr-10" name="in-date" type="text"
          wire:model="form.in_date" required />
        <svg class="pointer-events-none absolute right-3 top-1/2 h-[18px] w-[18px] -translate-y-1/2 text-[#3289FA]"
          xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0
        002-2V7a2 2 0 00-2-2H5a2 2 0
        00-2 2v12a2 2 0 002 2z" />
        </svg>
      </div>
    </div>

    <div class="mt-2 grid grid-cols-[20%,80%] items-center">
      <x-input-label for="in-time" value="開始時間" />
      <x-text-input class="mt-1 block w-full" name="in-time" type="time" wire:model="form.in_time" required />
    </div>

    <div class="mt-4 grid grid-cols-[20%,80%] items-center">
      <x-input-label for="out-date" value="終了日付" />
      <x-text-input class="mt-1 block w-full" name="out-date" type="date" wire:model="form.out_date" required />
    </div>

    <div class="mt-2 grid grid-cols-[20%,80%] items-center">
      <x-input-label for="out-time" value="終了時間" />
      <x-text-input class="mt-1 block w-full" name="out-time" type="time" wire:model="form.out_time" required />
    </div>

    <x-input-error class="mt-2" :messages="$errors->get('form.out_time')" />
    <div class="-mx-4 -mb-4 mt-[20px] flex items-center justify-center rounded-b bg-white py-4">
      <x-secondary-button x-on:click="$dispatch('close')">
        {{ __('Cancel') }}
      </x-secondary-button>

      <x-primary-button class="ms-3">
        登録
      </x-primary-button>
    </div>
  </form>
</x-modal>
