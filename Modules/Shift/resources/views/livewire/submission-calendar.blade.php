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
        @foreach ($this->calendar as $content)
          <div wire:click='setDate("{{ $content['date']->format('Y-m-d') }}")'
            x-on:click="$dispatch('open-modal', 'create-dialog-{{ $content['date']->format('Y-m-d') }}')"
            @class([
                'cursor-pointer flex flex-col min-h-24 border',
                'bg-sky-100' => $content['type'] == '土曜日',
                'bg-red-100' => $content['type'] == '日曜日',
                'bg-orange-200' => $content['type'] == '公休日',
                'bg-gray-100 hidden sm:block' => $content['type'] == '期間外',
            ]) wire:key="calendar-box-{{ $content['date']->format('Y-m-d') }}">
            <div class="flex justify-between">
              @if ($content['type'] != '期間外')
                <div class="ms-1">{{ $content['date']->isoFormat('D日') }}</div>
              @endif
            </div>
            <div class="flex flex-col items-center justify-center px-1 text-center sm:text-sm">
              @foreach ($content['draftShifts'] as $key => $time)
                <div class="flex rounded-sm py-1" wire:key="{{ $time->id }}">
                  <button class="hover:text-ao-main" type="button" wire:click="setData({{ $time->id }})"
                    x-on:click.stop="$dispatch('open-modal', 'edit-dialog-{{ $content['date']->format('Y-m-d') }}')">
                    {{ $time->ViewSubmissionTime }}
                  </button>
                </div>
              @endforeach
            </div>
          </div>
          @if ($content['type'] != '期間外')
            @include('shift::livewire.layouts.submission-create-modal')
            @include('shift::livewire.layouts.submission-edit-modal')
          @endif
        @endforeach
      </div>
    </div>
  </div>
</div>
