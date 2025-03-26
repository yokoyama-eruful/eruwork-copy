<div class="hidden w-3/12 flex-col px-3 py-4 sm:block">
  <div>{{ $selectedDate->isoFormat('Y年M月D日(ddd)') }}</div>
  <div class="mb-2 flex flex-col space-y-5 border-t-8 border-ao-main bg-ao-sub p-5" wire:key="view-area">
    <div>
      <div class="flex justify-between">
        <div>勤務時間</div>
        <button class="bg-ao-main px-4 text-white" type="button"
          x-on:click.prevent="$dispatch('open-modal', 'work-time-modal')" wire:click="setWorkTime(null)">追加</button>
      </div>
      @include('timecard::general.livewire.calendar.desktop.work-time-modal')
      <div class="bg-white p-2">
        @forelse ($workTimeForm->workTimes as $key => $time)
          <div
            class="flex flex-wrap items-center justify-between rounded-sm border-b border-dashed border-gray-400 bg-white hover:bg-sky-200"
            wire:key="{{ $time->id }}">
            <div class="ms-1 min-w-32 leading-5 text-gray-800">
              {{ $time->term() }}
            </div>
            <button
              class="my-1 rounded bg-white px-2 py-1 text-sm font-medium text-gray-700 hover:bg-slate-100 hover:text-blue-500"
              type="button" x-on:click.prevent="$dispatch('open-modal', 'work-time-modal')"
              wire:click="setWorkTime('{{ $time->id }}')">
              <i class="fa-regular fa-pen-to-square"></i>
            </button>
          </div>
        @empty
          <div class="flex items-center rounded-sm border-b border-dashed border-gray-400 hover:bg-sky-200">
            <div class="p-1 leading-5 text-gray-800">
              記録なし
            </div>
          </div>
        @endforelse
      </div>
    </div>

    <div>
      <div class="flex justify-between">
        <div>休憩時間</div>
        <button class="bg-ao-main px-4 text-white" type="button"
          x-on:click.prevent="$dispatch('open-modal', 'break-time-modal')" wire:click="setBreakTime(null)">追加</button>
      </div>
      @include('timecard::general.livewire.calendar.desktop.break-time-modal')
      <div class="bg-white p-2">
        @forelse ($breakTimeForm->breakTimes as $key => $time)
          <div
            class="flex flex-wrap items-center justify-between rounded-sm border-b border-dashed border-gray-400 bg-white hover:bg-sky-200"
            wire:key="{{ $time->id }}">
            <div class="ms-1 min-w-32 leading-5 text-gray-800">
              {{ $time->term() }}
            </div>
            <button
              class="my-1 rounded bg-white px-2 py-1 text-sm font-medium text-gray-700 hover:bg-slate-100 hover:text-blue-500"
              wire:click="setBreakTime('{{ $time->id }}')"
              x-on:click.prevent="$dispatch('open-modal', 'break-time-modal')">
              <i class="fa-regular fa-pen-to-square"></i>
            </button>
          </div>
        @empty
          <div class="flex items-center rounded-sm border-b border-dashed border-gray-400 hover:bg-sky-200">
            <div class="p-1 leading-5 text-gray-800">
              記録なし
            </div>
          </div>
        @endforelse
      </div>
    </div>
  </div>
</div>
