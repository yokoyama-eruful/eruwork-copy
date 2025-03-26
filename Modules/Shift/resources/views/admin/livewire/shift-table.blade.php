<div>
  <div class="mx-3 mb-2 flex min-h-2 flex-col px-1">
    <div class="flex justify-between border-b border-gray-800">
      <div class="font-bold text-emerald-700">
        <i class="fa-solid fa-check pr-1"></i>
        <span>確定シフト</span>
      </div>
      <button
        class="flex items-center justify-center rounded-sm px-1 font-medium text-ao-main hover:bg-ao-main hover:text-white"
        type="button" x-on:click="$dispatch('open-modal', 'create-dialog-{{ $date->format('Y-m-d') }}')">
        <i class="fa-regular fa-calendar-plus me-1"></i>
        <span>追加</span>
      </button>
      <livewire:shift::admin.shift-create :$date :key="$date->format('Ymd')" />
    </div>

    @foreach ($shifts as $name => $schedules)
      <div class="flex flex-col rounded-sm bg-emerald-50 px-2 pb-2 text-left"
        wire:key="shift-{{ $date->format('Y-m-d') }}">
        <div class="truncate font-semibold underline decoration-gray-400"><i
            class="fa-solid fa-person-circle-check pr-1"></i>{{ $name }}</div>
        @foreach ($schedules as $id => $schedule)
          <div class="px-2" wire:key="{{ $schedule->id . $schedule->user_id }}">

            <div class="flex flex-row items-center border-b hover:bg-slate-100 hover:text-blue-500"
              wire:click="setSchedule({{ $schedule->id }})"
              x-on:click="$dispatch('open-modal', 'edit-dialog-{{ $schedule->id }}')">
              @if (is_null($schedule->draftSchedule))
                <div>
                  ・{{ $schedule->start_time->format('H:i') . ' ～ ' . $schedule->end_time?->format('H:i') }}
                </div>
              @else
                <div @class([
                    'text-black',
                    'text-red-500' =>
                        $schedule->draftSchedule->start_time > $schedule->start_time ||
                        $schedule->draftSchedule->end_time < $schedule->end_time,
                ])>
                  ・{{ $schedule->start_time->format('H:i') . ' ～ ' . $schedule->end_time?->format('H:i') }}
                </div>
              @endif
              <button class="pl-1">
                <i class="fa-regular fa-pen-to-square"></i>
              </button>
            </div>
            <livewire:shift::admin.shift-edit :$schedule :key="$schedule->id . $schedule->updated_at->format('YmdHis')" />
          </div>
        @endforeach
      </div>
    @endforeach
  </div>

  <div class="mx-3 mb-2 flex min-h-2 flex-col px-1">
    <div class="border-b border-gray-800 font-bold text-amber-700">
      <i class="fa-solid fa-question pr-1"></i>
      <span>希望シフト</span>
    </div>
    @foreach ($drafts as $name => $drafts)
      <div class="flex flex-col rounded-sm bg-amber-50 px-2 pb-2 text-left">
        <div class="truncate font-semibold underline decoration-gray-400"><i
            class="fa-solid fa-person-circle-question pr-1"></i>{{ $name }}</div>
        @foreach ($drafts as $draft)
          <div class="px-2" wire:key="{{ $draft->id }}">
            <div class="flex flex-row items-center border-b">
              <div>
                ・{{ $draft->start_time->format('H:i') . ' ～ ' . $draft->end_time?->format('H:i') }}
              </div>
              <button class="pl-1 text-gray-700 hover:bg-slate-100 hover:text-blue-500"
                wire:click="goToShift({{ $draft->id }})">
                <i class="fa-regular fa-circle-up"></i>
              </button>
            </div>
          </div>
        @endforeach
      </div>
    @endforeach
  </div>
</div>
