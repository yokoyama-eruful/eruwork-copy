<x-modal-alert name="shift-view-modal-{{ $shift->id }}">
  <div class="flex items-center justify-between px-4 pt-4">
    <div class="text-xl font-bold">{{ $content['date']->format('Y.m.d') }}</div>
  </div>
  <div class="px-4 pb-4">
    @if ($this->overlappingSchedules($shift) || $this->overlappingShifts($shift))
      <div><i class="fa-solid fa-circle-exclamation p-1 text-rose-600"></i>予定が重複しています</div>
    @endif
    <div class="mt-4">
      <x-input-label for="start_time" value="開始時間" />

      <div class="mt-1 block w-full border-b">{{ $shift->start_time->format('H:i') }}</div>

      <x-input-error class="mt-2" :messages="$errors->userDeletion->get('start_time')" />
    </div>

    <div class="mt-2">
      <x-input-label for="end_time" value="終了時間" />

      <div class="mt-1 block w-full border-b">{{ $shift->end_time->format('H:i') }}</div>

      <x-input-error class="mt-2" :messages="$errors->userDeletion->get('end_time')" />
    </div>

    <div class="mt-6 flex justify-end">
      <x-secondary-button x-on:click="$dispatch('close')">
        閉じる
      </x-secondary-button>
    </div>
  </div>
</x-modal-alert>
