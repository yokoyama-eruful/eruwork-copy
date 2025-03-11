<x-dialog.panel title="{{ $breakData->id ? '休憩修正' : '休憩登録' }}">
  <div class="flex flex-wrap items-center justify-between">
    <div class="text-xl font-bold">{{ $selectedDate->isoFormat('Y年M月D日(ddd)') }}</div>
    @if ($breakData->id)
      <form wire:submit="deleteBreakTime">
        <x-danger-button>削除</x-danger-button>
      </form>
    @endif
  </div>
  <form class="flex flex-col" wire:submit="storeBreakTime">
    <div class="mt-2 flex flex-row items-center space-x-2">
      <x-input-label class="w-24" for="in-time" value="開始時間" />

      <div class="flex flex-1 flex-col">
        <x-text-input class="mt-1 block flex-1" name="in-time" type="time" wire:model="breakData.inTime" />

        <x-input-error class="mt-2" :messages="$errors->get('breakData.inTime')" />
      </div>
    </div>

    <div class="mt-2 flex flex-row items-center space-x-2">
      <x-input-label class="w-24" for="out-time" value="終了時間" />

      <div class="flex flex-1 flex-col">
        <x-text-input class="mt-1 block flex-1" name="out-time" type="time" wire:model="breakData.outTime" />

        <x-input-error class="mt-2" :messages="$errors->get('breakData.outTime')" />
      </div>
    </div>

    <div class="flex flex-row space-x-2 bg-gray-50 px-4 py-3">
      <x-dialog.submit>
        登　録
      </x-dialog.submit>
      <x-dialog.cancel>
        キャンセル
      </x-dialog.cancel>
    </div>
  </form>
</x-dialog.panel>
