<x-modal name="work-time-modal" title="{{ $workData->id ? '勤怠修正' : '勤怠登録' }}">
  <div class="flex items-center justify-between px-4 pt-4">
    <div class="text-xl font-bold">{{ $selectedDate->isoFormat('YYYY.MM.DD(ddd)') }}</div>
    @if ($workData->id)
      <form wire:submit="deleteWorkTime">
        <x-danger-button>削除</x-danger-button>
      </form>
    @endif
  </div>
  <form wire:submit="storeWorkTime">

    <div class="mt-4">
      <x-input-label for="title" value="開始時間" />

      <x-text-input class="mt-1 block w-full" name="in-time" type="time" wire:model="workData.inTime" required />

      <x-input-error class="mt-2" :messages="$errors->get('workData.inTime')" />
    </div>

    <div class="mt-4">
      <x-input-label for="title" value="終了時間" />

      <x-text-input class="mt-1 block w-full" name="out-time" type="time" wire:model="workData.outTime" required />

      <x-input-error class="mt-2" :messages="$errors->get('workData.outTime')" />
    </div>
    <x-input-error class="mt-2" :messages="$errors->get('workError')" />
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
