<div class="w-full rounded-t bg-white py-2 xl:px-5">
  <div class="flex flex-row items-center justify-between rounded-t-md border-x border-t bg-gray-100 p-4">
    <div class="flex flex-col text-lg font-semibold text-gray-700 sm:flex-row xl:items-center">
      <div>シフト受付期間</div>
      <div class="hidden sm:block"> : </div>
      <div>{{ $manager->submission_start_date->format('Y年m月d日') }} ~ </div>
      <div>{{ $manager->submission_end_date->format('Y年m月d日') }}</div>
    </div>
    <livewire:shift::admin.manager-edit :$manager @updated="$refresh" />
  </div>
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
          ]) wire:key="{{ $content['date']->format('Y-m-d') }}">
            @if ($content['type'] != '期間外')
              <div class="px-1">
                @if ($content['date']->day == 1 || $key == 1)
                  {{ $content['date']->isoFormat('Y年M月D日') }}
                @else
                  {{ $content['date']->isoFormat('D日') }}
                @endif
              </div>
              <livewire:shift::admin.shift-table :date="$content['date']" :shifts="$content['shifts']" :drafts="$content['drafts']"
                :key="$content['date']->format('Ymd')" />
            @endif
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
