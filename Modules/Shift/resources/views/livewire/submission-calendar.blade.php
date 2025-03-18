<div class="w-full rounded-t bg-white py-2 xl:px-5">
  <div>
    <div class="items-center overflow-x-auto">
      <div class="hidden w-full grid-cols-7 border sm:grid">
        <div class="border-x bg-gray-300 text-center text-gray-800">月</div>
        <div class="border-x bg-gray-300 text-center text-gray-800">火</div>
        <div class="border-x bg-gray-300 text-center text-gray-800">水</div>
        <div class="border-x bg-gray-300 text-center text-gray-800">木</div>
        <div class="border-x bg-gray-300 text-center text-gray-800">金</div>
        <div class="border-x bg-sky-200 text-center text-gray-800">土</div>
        <div class="border-x bg-red-200 text-center text-gray-800">日</div>
      </div>

      <div class="grid w-full sm:grid-cols-7" wire:key="calendar-grid">
        @foreach ($this->calendar as $key => $content)
          <div @class([
              'cursor-pointer flex flex-col min-h-24 border',
              'bg-sky-100' => $content['type'] == '土曜日',
              'bg-red-100' => $content['type'] == '日曜日',
              'bg-orange-200' => $content['type'] == '公休日',
              'bg-gray-100 hidden sm:block' => $content['type'] == '期間外',
          ]) wire:key="calendar-box-{{ $content['date']->format('Y-m-d') }}">
            <div class="mx-1 flex items-center justify-between">
              @if ($content['type'] != '期間外')
                <div>
                  @if ($content['date']->day == 1 || $key == 1)
                    {{ $content['date']->isoFormat('Y年M月D日') }}
                  @else
                    {{ $content['date']->isoFormat('D日') }}
                  @endif
                </div>
                @if ($manager->OverSubmissionPeriod)
                  <button class="text-2xl opacity-30 hover:text-ao-main hover:opacity-100 xl:text-xl" type="button"
                    x-on:click="$dispatch('open-modal', 'create-dialog-{{ $content['date']->format('Y-m-d') }}')">
                    <i class="fa-regular fa-square-plus"></i>
                  </button>
                @endif
              @endif
            </div>
            <div class="flex flex-col items-center justify-center px-1 text-center sm:text-sm">
              @foreach ($content['draftShifts'] as $key => $schedule)
                <button class="flex w-full justify-start rounded-sm py-1 hover:bg-gray-100" type="button"
                  wire:key="{{ $schedule->id }}"
                  x-on:click.stop="$dispatch('open-modal', 'edit-dialog-{{ $content['date']->format('Y-m-d') }}')">
                  <div class="flex flex-row items-center space-x-1">
                    @if (!$schedule->shiftStatus)
                      <div class="rounded bg-yellow-300 px-1 font-medium">未</div>
                      <div>{{ $schedule->ViewSubmissionTime }}</div>
                    @endif

                    @if ($schedule->shiftStatus)
                      <div class="rounded bg-green-300 px-1 font-medium">確</div>
                      <div>{{ $schedule->ViewSubmissionTime }}</div>
                    @endif
                  </div>
                </button>
                <livewire:shift::submission-edit-modal @edited="$refresh" :key="$schedule->id" :$schedule :$manager />
              @endforeach
            </div>
          </div>
          @if ($content['type'] != '期間外')
            <livewire:shift::submission-create-modal @added="$refresh" :key="$content['date']->format('Ymd')" :day="$content['date']"
              :manager="$manager" />
          @endif
        @endforeach
      </div>
    </div>
  </div>
</div>
