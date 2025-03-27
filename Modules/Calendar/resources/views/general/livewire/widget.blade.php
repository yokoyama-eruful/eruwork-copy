<div class="hidden xl:block">
  <x-widget>
    <div class="flex flex-wrap items-center justify-between pb-2">
      <div class="flex flex-row items-center space-x-2">
        <div class="h-auto self-stretch border-l-4 border-ao-main"></div>
        <div class="text-lg font-bold">カレンダー</div>
      </div>
    </div>
    <div class="flex justify-between">
      <div class="mb-2 flex items-center justify-end gap-1">
        <h1 class="text-2xl font-bold">{{ $startDate->format('Y年n月') }}</h1>
        <button
          class="rounded-lg border border-gray-300 bg-hai-sub px-4 text-gray-400 shadow transition duration-150 ease-in-out hover:bg-hai-main"
          wire:click="setPreviousWeek">
          <i class="fa-solid fa-angles-left"></i> 前週
        </button>
        <button
          class="rounded-lg border border-gray-300 bg-hai-sub px-4 text-gray-400 shadow transition duration-150 ease-in-out hover:bg-hai-main"
          wire:click="setPreviousDay">
          <i class="fa-solid fa-angle-left"></i> 前日
        </button>
        <button
          class="rounded-lg border border-gray-300 bg-hai-sub px-4 text-gray-400 shadow transition duration-150 ease-in-out hover:bg-hai-main"
          wire:click="setToday">
          今日
        </button>
        <button
          class="rounded-lg border border-gray-300 bg-hai-sub px-4 text-gray-400 shadow transition duration-150 ease-in-out hover:bg-hai-main"
          wire:click="setNextDay">
          翌日<i class="fa-solid fa-chevron-right"></i>
        </button>
        <button
          class="rounded-lg border border-gray-300 bg-hai-sub px-4 text-gray-400 shadow transition duration-150 ease-in-out hover:bg-hai-main"
          wire:click="setNextWeek">
          翌週<i class="fa-solid fa-angles-right"></i>
        </button>
      </div>

    </div>
    <div class="flex justify-center">
      <div class="flex w-full flex-row overflow-x-auto">
        @foreach ($this->calendar as $key => $content)
          <div class=
                'm-0 mb-3 min-h-48 border md:w-1/6'>
            <div @class([
                'text-lg w-full border-b flex justify-center py-1 bg-ao-sub',
                'bg-rose-200' => $content['type'] === '土曜日',
                'bg-sky-200' => $content['type'] === '日曜日',
                'bg-orange-200' => $content['type'] === '公休日',
            ])>
              {{ $content['date']->isoFormat('MM/DD(ddd)') }}{{ $content['date_name'] }}
            </div>
            <div class="m-2 flex justify-end">
              <button class="text-2xl opacity-30 hover:text-ao-main hover:opacity-100 xl:text-xl" type="button"
                x-on:click="$dispatch('open-modal', 'create-dialog-{{ $content['date']->format('Y-m-d') }}')">
                <i class="fa-regular fa-square-plus"></i>
              </button>
            </div>
            <div class="flex flex-col space-y-1">
              @foreach ($content['shifts'] as $shift)
                <button
                  class="mx-1 mb-1 cursor-pointer truncate rounded border border-emerald-500 bg-emerald-300 pb-1 ps-1 hover:bg-emerald-500"
                  x-on:click="$dispatch('open-modal','shift-view-modal-{{ $shift->id }}')">
                  <div class="flex justify-between">
                    <div class="underline decoration-gray-400">
                      シフト
                    </div>
                    {{-- @if ($this->overlappingSchedules($content['shifts']) || $this->overlappingShifts())
                      <i class="fa-solid fa-circle-exclamation p-1 text-rose-600"></i>
                    @endif --}}
                  </div>
                  <div class="ms-1 text-start">
                    {{ $shift->start_time->format('H:i') . '～' . $shift->end_time?->format('H:i') }}
                  </div>
                </button>
                @include('calendar::general.livewire.layouts.shift-view-modal')
              @endforeach
              @foreach ($content['schedules'] as $schedule)
                <button
                  class="mx-1 mb-1 cursor-pointer truncate rounded border border-sky-500 bg-sky-300 pb-1 ps-1 hover:bg-sky-500"
                  x-on:click="$dispatch('open-modal','schedule-edit-modal-{{ $schedule->id }}')">
                  <div class="flex justify-between">
                    <div class="underline decoration-gray-400">
                      {{ $schedule->title }}
                    </div>
                    {{-- @if ($this->overlappingSchedules($content['shifts']) || $this->overlappingShifts())
                  <i class="fa-solid fa-circle-exclamation p-1 text-rose-600"></i>
                @endif --}}
                  </div>
                  <div class="ms-1 text-start">
                    {{ $schedule->start_time->format('H:i') . '～' . $schedule->end_time?->format('H:i') }}
                  </div>
                </button>
                <livewire:calendar::general.edit-schedule @updated="$refresh" :$schedule :key="$schedule->id . $content['date']->format('Ym')" />
              @endforeach
            </div>
          </div>
          <livewire:calendar::general.create-schedule @added="$refresh" :date="$content['date']" :key="$content['date']->format('Ymd') . $key" />
        @endforeach
      </div>
    </div>
  </x-widget>
</div>
