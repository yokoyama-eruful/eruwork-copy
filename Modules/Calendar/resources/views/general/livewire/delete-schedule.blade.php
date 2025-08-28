<x-modal-alert name="schedule-delete-modal-{{ $schedule->id }}" title="予定削除" maxWidth="sm">
  <div class="flex flex-col items-center bg-[#F7F7F7] px-5 pb-8 pt-4 text-left">
    <p class="text-xs">以下のタイトルを削除いたします</p>
    <div class="pt-[13px] text-[15px] font-bold">{{ $schedule->title }}</div>
  </div>
  <div class="my-5 flex items-center justify-center space-x-[10px]">
    <div class="flex h-11 w-[150px] cursor-pointer items-center justify-center rounded border-2"
      @click="$dispatch('close-modal', 'schedule-delete-modal-{{ $schedule->id }}'); openModalSchedule{{ $schedule->id }}=false">
      キャンセル</div>
    <div class="flex h-11 w-[150px] cursor-pointer items-center justify-center rounded bg-[#FF4A62] text-white"
      x-on:click="openModalSchedule{{ $schedule->id }}=false" wire:click="delete({{ $schedule->id }})">削除する
    </div>
  </div>
</x-modal-alert>
