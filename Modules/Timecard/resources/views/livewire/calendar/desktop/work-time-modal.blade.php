<x-dialog.panel title="{{ $workData->id ? '勤怠修正' : '勤怠登録' }}">
  <div class="flex flex-wrap items-center justify-between">
    <div class="text-xl font-bold">{{ $selectedDate->isoFormat('Y年M月D日(ddd)') }}</div>
    @if ($workData->id)
      <form wire:submit="deleteWorkTime">
        <x-danger-button>削除</x-danger-button>
      </form>
    @endif
  </div>
  <form class="flex flex-col" wire:submit="storeWorkTime">
    <div class="mt-2 flex flex-row items-center space-x-2">
      <x-input-label class="w-24" for="in-time" value="開始時間" />

      <div class="flex flex-1 flex-col">
        <x-text-input class="mt-1 block" name="in-time" type="time" wire:model="workData.inTime" />

        <x-input-error class="mt-2" :messages="$errors->get('workData.inTime')" />
      </div>
    </div>

    <div class="mt-2 flex flex-row items-center space-x-2">
      <x-input-label class="w-24" for="out-time" value="終了時間" />

      <div class="flex flex-1 flex-col">
        <x-text-input class="mt-1 block" name="out-time" type="time" wire:model="workData.outTime" />

        <x-input-error class="mt-2" :messages="$errors->get('workData.outTime')" />
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
