<x-modal-alert name="schedule-delete-modal-{{ $schedule->id }}" title="予定削除" maxWidth="sm">
  <div class="flex flex-col items-center bg-[#F7F7F7] px-5 pb-8 pt-4 text-left">
    <p class="text-xs">以下のタイトルを削除いたします</p>
    <div class="pt-[13px] text-[0.9375rem] font-bold">{{ $schedule->title }}</div>
  </div>
  <div class="my-5 flex flex-col gap-[10px] sm:flex-row sm:items-center sm:justify-center sm:space-x-[10px] sm:gap-0">
    <div class="flex h-11 w-[150px] whitespace-nowrap cursor-pointer items-center justify-center rounded border-2"
      @click="$dispatch('close-modal', 'schedule-delete-modal-{{ $schedule->id }}'); openModalSchedule{{ $schedule->id }}=false">
      キャンセル</div>
    <div class="flex h-11 w-[150px] whitespace-nowrap cursor-pointer items-center justify-center rounded bg-[#FF4A62] text-white"
      x-on:click="openModalSchedule{{ $schedule->id }}=false" wire:click="delete({{ $schedule->id }})">削除する
    </div>
  </div>
</x-modal-alert>
