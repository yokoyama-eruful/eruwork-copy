<div>
  <button
    class='flex h-[35px] items-center rounded-[5px] bg-[#3289fa] px-5 py-2 text-sm font-bold text-[#fff] hover:bg-[#3289fa4d]'
    type="button" x-on:click="$dispatch('open-modal','multi-create-modal')">
    <img class="mr-[5px] h-[15px] w-[15px]" src="{{ asset('img/icon/add-schedule.png') }}" />
    複数日登録
  </button>
  <x-modal name="multi-create-modal" title="シフト希望複数登録">
    <form method="post" wire:submit="save">
      @csrf

      @if ($errors->any())
        <div class="mb-4 rounded border border-red-300 bg-red-50 p-3 text-xs text-red-600">
          <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="mb-[20px] mt-[20px] grid w-full grid-cols-[30%,70%] items-center">
        <x-input-label for="date" value="日付" />

        <div class="relative">
          <x-text-input
            class="js-multiple-term-datepicker block w-full appearance-none rounded border border-gray-300 py-1 pl-3 pr-8"
            id="date" name="date" type="text" wire:model="form.date" required
            min="{{ $manager->start_date->format('Y-m-d') }}" min="{{ $manager->end_date->format('Y-m-d') }}" />
          <!-- カレンダーアイコン（青 #3289FA） -->
          <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#3289FA]"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0
        002-2V7a2 2 0 00-2-2H5a2 2 0
        00-2 2v12a2 2 0 002 2z" />
          </svg>
        </div>
      </div>

      <script>
        document.addEventListener('DOMContentLoaded', function() {
          const startDate = @json($manager->start_date->format('Y-m-d'));
          const endDate = @json($manager->end_date->format('Y-m-d'));

          let datepicker;

          datepicker = flatpickr('.js-multiple-term-datepicker', {
            locale: {
              ...flatpickr.l10ns.ja,
              "firstDayOfWeek": 1
            },
            mode: "multiple",
            dateFormat: 'Y-m-d',
            minDate: startDate,
            maxDate: endDate,
          });

          Livewire.on('reset-property', function() {
            if (datepicker) {
              datepicker.clear();
            }
          });
        });
      </script>

      <div class="mr-[20px] mt-4 grid w-full grid-cols-[30%,70%] items-center">
        <x-input-label value="勤務時間" />
        <div class="flex items-center space-x-5">
          <div @class([
              'cursor-pointer rounded px-2 py-1 font-bold',
              'bg-[#3289FA1A] bg-opacity-10 text-[#3289FA]' => $item === 'time',
              'text-[#AAB0B6] hover:opacity-40' => $item !== 'time',
          ]) wire:click="changeItem('time')">
            時間指定</div>
          <div @class([
              'cursor-pointer rounded px-2 py-1 font-bold',
              'bg-[#3289FA1A] bg-opacity-10 text-[#3289FA]' => $item === 'pattern',
              'text-[#AAB0B6] hover:opacity-40' => $item !== 'pattern',
          ]) wire:click="changeItem('pattern')">
            パターン指定</div>
        </div>
      </div>

      @if ($item === 'time')
        <div class="mr-[20px] mt-4 grid w-full grid-cols-[30%,70%] items-center">
          <x-input-label class="font-normal" value="時間設定" />
          <div class="flex w-full items-center space-x-1">
            <x-text-input class="flex-1" id="start_time" name="start_time" type="time" wire:model="form.startTime" />

            <div class="px-[10px]">〜</div>

            <x-text-input class="flex-1" id="end_time" name="end_time" type="time" wire:model="form.endTime" />
          </div>
        </div>
      @endif

      @if ($item === 'pattern')
        <div class="mr-[20px] mt-4 grid w-full grid-cols-[30%,70%] items-start">
          <x-input-label class="font-normal" value="パターン設定" />
          <div class="flex flex-col justify-center space-y-3">
            @forelse (Auth::user()->patterns as $pattern)
              @if (!is_null($pattern->start_time) && !is_null($pattern->end_time))
                <div class="flex items-center space-x-1">
                  <label class="flex cursor-pointer items-center space-x-1">
                    <input name="pattern_id" type="radio"
                      wire:click="selectPattern('{{ $pattern->start_time->format('H:i') }}','{{ $pattern->end_time->format('H:i') }}')">
                    <span>{{ $pattern->start_time->format('H:i') }}~{{ $pattern->end_time->format('H:i') }}</span>
                  </label>
                </div>
              @endif
            @endforeach
          </div>
        </div>
      @endif

      <div class="-mx-4 -mb-[30px] mt-[30px] flex items-center justify-center rounded-b bg-white py-4">
        <x-secondary-button x-on:click="$dispatch('close')">
          {{ __('Cancel') }}
        </x-secondary-button>

        <x-primary-button class="ms-3">
          登録
        </x-primary-button>
      </div>
    </form>
  </x-modal>
</div>
