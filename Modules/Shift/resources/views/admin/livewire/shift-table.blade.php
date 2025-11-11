<div>
  <div class="flex items-center justify-between px-[15px]">
    <div @class(['text-[15px] py-[15px]'])>{{ $date->isoFormat('D日') }}</div>
    @if ($type != '期間外')
      <div>
        @include('shift::admin.livewire.layouts.shift-create')
      </div>
    @endif
  </div>

  <div class="flex flex-col space-y-1">
    @foreach ($shifts as $name => $schedule)
      <div
        class="mr-[11px] flex items-center space-x-[6px] rounded-lg border border-[#39A338] bg-[#F6FFF6] px-[10px] py-[7px] text-left"
        wire:key="shift-{{ $date->format('Y-m-d') }}">
        <div
          class="flex h-[22px] w-[22px] items-center justify-center rounded bg-[#39A338] text-xs font-bold text-white">
          確
        </div>
        <div class="text-xs">
          {{-- <div class="font-bold">{{ $schedule->start_time->format('H:i') . ' ～ ' . $schedule->end_time?->format('H:i') }}
          </div> --}}
          <div>{{ $name }}</div>
        </div>
        {{-- <div class="truncate font-semibold underline decoration-gray-400"><i
            class="fa-solid fa-person-circle-check pr-1"></i>{{ $name }}</div>
        @foreach ($schedules as $id => $schedule)
          <div class="px-2" wire:key="{{ $schedule->id . $schedule->user_id }}">
            @include('shift::admin.livewire.layouts.shift-edit')
          </div>
        @endforeach --}}
      </div>
    @endforeach
  </div>
</div>
