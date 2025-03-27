<x-modal name="edit-dialog-{{ $schedule->id }}" title="シフト希望編集">
  @if ($schedule->shiftStatus || !$manager->OverSubmissionPeriod)
    <div class="px-4 pb-4">
      <div class="mt-4 text-start text-lg font-bold">
        {{ $schedule->date->format('Y年m月d日') }}
      </div>

      <div class="mt-4">
        <x-input-label class="text-start" value="希望開始時間" />

        <div class="border-b p-2 text-left">
          {{ $schedule->start_time->format('H:i') }}
        </div>
      </div>

      <div class="mt-4">
        <x-input-label class="text-start" value="希望終了時間" />

        <div class="border-b p-2 text-left">
          {{ $schedule->end_time->format('H:i') }}
        </div>
      </div>

      <div class="mt-4">
        <x-input-label class="text-start" value="確定開始時間" />

        <div class="border-b p-2 text-left">
          {{ $schedule->shiftSchedule->start_time->format('H:i') }}
        </div>
      </div>

      <div class="mt-4">
        <x-input-label class="text-start" value="確定終了時間" />

        <div class="border-b p-2 text-left">
          {{ $schedule->shiftSchedule->end_time->format('H:i') }}
        </div>
      </div>

      <div class="mt-6 flex justify-end">
        <x-secondary-button x-on:click="$dispatch('close')">
          {{ __('Cancel') }}
        </x-secondary-button>
      </div>
    </div>
  @endif

  @if (!$schedule->shiftStatus && $manager->OverSubmissionPeriod)
    <form class="flex justify-end" wire:submit="delete">
      <x-danger-button>削除</x-danger-button>
    </form>
    <form class="px-4 pb-4" wire:submit="update">
      @csrf

      <div class="mt-4 text-start text-lg font-bold">
        {{ $schedule->date->format('Y年m月d日') }}
      </div>
      <div class="mt-4">
        <x-input-label class="text-start" for="start_time" value="開始時間" />

        <x-text-input class="mt-1 block w-full" id="start_time" name="start_time" type="time"
          wire:model="form.startTime" required />

        @error('form.start_time')
          <div class="font-normal text-red-500">{{ $message }}</div>
        @enderror
      </div>

      <div class="mt-2">
        <x-input-label class="text-start" for="end_time" value="終了時間" />

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
          更新
        </x-primary-button>
      </div>
    </form>
  @endif
</x-modal>
