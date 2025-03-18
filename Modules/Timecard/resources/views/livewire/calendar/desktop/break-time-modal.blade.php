<x-modal name="break-time-modal" title="{{ $breakData->id ? '休憩修正' : '休憩登録' }}">
  <div class="flex items-center justify-between px-4 pt-4">
    <div class="text-xl font-bold">{{ $selectedDate->isoFormat('Y年M月D日(ddd)') }}</div>
    @if ($breakData->id)
      <form wire:submit="deleteBreakTime">
        <x-danger-button>削除</x-danger-button>
      </form>
    @endif
  </div>
  <form class="px-4 pb-4" wire:submit="storeBreakTime">

    <div class="mt-4">
      <x-input-label for="title" value="開始時間" />

      <x-text-input class="mt-1 block w-full" name="in-time" type="time" wire:model="breakData.inTime" required />

      <x-input-error class="mt-2" :messages="$errors->get('breakData.inTime')" />
    </div>

    <div class="mt-4">
      <x-input-label for="title" value="終了時間" />

      <x-text-input class="mt-1 block w-full" name="out-time" type="time" wire:model="breakData.outTime" required />

      <x-input-error class="mt-2" :messages="$errors->get('breakData.outTime')" />
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
