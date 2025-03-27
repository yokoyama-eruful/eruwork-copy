<div>
  <div class="mx-3 mb-2 flex min-h-2 flex-col px-1">
    <div class="flex justify-between border-b border-gray-800">
      <div class="font-bold text-emerald-700">
        <i class="fa-solid fa-check pr-1"></i>
        <span>確定シフト</span>
      </div>
      @include('shift::admin.livewire.layouts.shift-create')
    </div>

    @foreach ($shifts as $name => $schedules)
      <div class="flex flex-col rounded-sm bg-emerald-50 px-2 pb-2 text-left"
        wire:key="shift-{{ $date->format('Y-m-d') }}">
        <div class="truncate font-semibold underline decoration-gray-400"><i
            class="fa-solid fa-person-circle-check pr-1"></i>{{ $name }}</div>
        @foreach ($schedules as $id => $schedule)
          <div class="px-2" wire:key="{{ $schedule->id . $schedule->user_id }}">
            @include('shift::admin.livewire.layouts.shift-edit')
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
                wire:click="upShift({{ $draft->id }})">
                <i class="fa-regular fa-circle-up"></i>
              </button>
            </div>
          </div>
        @endforeach
      </div>
    @endforeach
  </div>
</div>
