<x-dashboard.index>
  <x-dashboard.top>
    <div class="hidden items-center space-x-[30px] sm:flex">
      <a class="flex items-center space-x-[2px] hover:opacity-40" href="{{ route('shiftManager.index') }}">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
            d="M5.78964 9.39738C5.6843 9.29192 5.62514 9.14895 5.62514 8.99988C5.62514 8.85082 5.6843 8.70785 5.78964 8.60238L11.4146 2.97738C11.5213 2.87802 11.6623 2.82393 11.808 2.8265C11.9538 2.82907 12.0928 2.88811 12.1959 2.99117C12.2989 3.09423 12.358 3.23327 12.3605 3.37899C12.3631 3.52472 12.309 3.66575 12.2096 3.77238L6.98214 8.99988L12.2096 14.2274C12.2649 14.2789 12.3092 14.341 12.34 14.41C12.3707 14.479 12.3873 14.5535 12.3886 14.629C12.3899 14.7045 12.376 14.7795 12.3477 14.8496C12.3194 14.9196 12.2773 14.9832 12.2239 15.0367C12.1705 15.0901 12.1069 15.1322 12.0368 15.1605C11.9668 15.1888 11.8918 15.2027 11.8162 15.2013C11.7407 15.2 11.6662 15.1835 11.5972 15.1527C11.5282 15.122 11.4661 15.0777 11.4146 15.0224L5.78964 9.39738Z"
            fill="#3289FA" />
        </svg>
        <div class="text-sm font-bold text-[#3289FA]">一覧画面に戻る</div>
      </a>
      <div class="h-[35px] border-l sm:hidden"></div>
    </div>

    <div class="flex items-center justify-between sm:hidden">
      <h5 class="block text-xl font-bold sm:hidden">シフト表管理</h5>
    </div>
  </x-dashboard.top>
  <x-dashboard.container>
    <h5 class="hidden text-xl font-bold sm:block">シフト管理</h5>
    <div class="mt-[30px] flex items-center space-x-2 border-b px-5 pb-[10px] sm:mt-[20px] sm:px-0">
      <div class="text-xs text-[#AAB0B6]">期間:</div>
      <div class="text-[15px] font-semibold sm:text-[20px]">
        {{ $manager->submission_start_date->isoFormat('M月D日（ddd）') }}　～　{{ $manager->submission_end_date->isoFormat('M月D日（ddd）') }}
      </div>
    </div>

    <hr class="mt-5 block border-b sm:hidden" />

    <div class="mt-[25px] hidden grid-cols-7 sm:grid">
      <div class="flex items-center justify-center text-[15px]">月</div>
      <div class="flex items-center justify-center text-[15px]">火</div>
      <div class="flex items-center justify-center text-[15px]">水</div>
      <div class="flex items-center justify-center text-[15px]">木</div>
      <div class="flex items-center justify-center text-[15px]">金</div>
      <div class="flex items-center justify-center text-[15px] text-[#48CBFF]">土</div>
      <div class="flex items-center justify-center text-[15px] text-[#FF0000]">日</div>
      {{-- <div class="text-xl font-bold">{{ $selectedDate->isoFormat('M月') }}</div> --}}
    </div>
    <div class="mt-[15px] hidden grid-cols-7 divide-x divide-y rounded-lg border sm:grid">
      @foreach ($this->calendar as $key => $content)
        <div @class([
            'min-h-[170px] min-w-[140px]',
            'bg-gray-100 hidden sm:block' => $content['type'] == '期間外',
        ]) wire:key="calendar-{{ $content['date']->format('Y-m-d') }}">

          <div class="flex items-center justify-between px-[15px]">
            <div @class(['text-[15px] py-[15px]'])>{{ $content['date']->isoFormat('D日') }}</div>
            @if ($content['type'] != '期間外')
              <div>
                @include('shift::admin.livewire.layouts.shift-create')
              </div>
            @endif
          </div>

          <div class="mb-5 flex flex-col space-y-1">
            @foreach ($content['shifts'] as $shift)
              <div
                class="mr-[11px] flex cursor-pointer items-center space-x-[6px] rounded-lg border border-[#39A338] bg-[#F6FFF6] px-[10px] py-[7px]"
                x-on:click="$dispatch('open-modal','edit-modal-{{ $shift->id }}')"
                wire:click="setSchedule({{ $shift->id }})">
                <div class="flex h-[22px] w-[22px] items-center justify-center rounded bg-[#39A338] text-xs text-white">
                  確
                </div>
                <div class="flex flex-col space-y-[3px] text-xs text-[#39A338]">
                  <div class="font-bold">
                    {{ $shift->start_time->isoFormat('aH時mm分') }}～{{ $shift->end_time->isoFormat('HH:mm') }}
                  </div>
                  <div>{{ $shift->user->name }}</div>
                </div>
              </div>
              @include('shift::admin.livewire.layouts.shift-edit', ['schedule' => $shift])
            @endforeach

            @foreach ($content['drafts'] as $draft)
              <div
                class="mr-[11px] flex cursor-pointer items-center space-x-[6px] rounded-lg border border-[#DE993A] bg-[#FFF7EC] px-[10px] py-[7px]"
                wire:click="upShift({{ $draft->id }})">
                <div class="flex h-[22px] w-[22px] items-center justify-center rounded bg-[#DE993A] text-xs text-white">
                  希
                </div>
                <div class="flex flex-col space-y-[3px] text-xs text-[#DE993A]">
                  <div class="font-bold">
                    {{ $draft->start_time->isoFormat('aH時mm分') }}～{{ $draft->end_time->isoFormat('HH:mm') }}
                  </div>
                  <div>{{ $draft->user->name }}</div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endforeach
    </div>

    {{-- <div class="mt-[10px] block sm:hidden">
      <div class="border-b px-5 py-[10px] text-xl font-bold">{{ $selectedDate->isoFormat('M月') }}</div>
      @foreach ($this->calendar as $key => $content)
        @if ($content['type'] != '補助日')
          <div @class([
              'flex min-h-[60px] items-center justify-between border-b px-5 py-[10px]',
              'bg-[#F9FAFF]' => $content['date']->format('Ymd') === now()->format('Ymd'),
          ]) wire:key="calendar-{{ $content['date']->format('Y-m-d') }}">
            <div @class([
                'text-xs',
                'font-bold text-[#3289FA]' =>
                    $content['date']->format('Ymd') === now()->format('Ymd'),
                'text-[#48CBFF]' =>
                    $content['date']->format('Ymd') !== now()->format('Ymd') &&
                    $content['date']->isoFormat('ddd') === '土',
                'text-[#FF0000]' =>
                    $content['date']->format('Ymd') !== now()->format('Ymd') &&
                    $content['date']->isoFormat('ddd') === '日',
            ])>{{ $content['date']->isoFormat('D日（ddd曜）') }}</div>

          </div>
        @endif
      @endforeach
    </div> --}}

    <div class="block sm:hidden">
      @foreach ($this->calendar as $key => $content)
        <div @class([
            'grid grid-cols-[15%,75%,10%] min-h-[60px]  border-b py-[10px]',
            'bg-[#F9FAFF]' => $content['date']->format('Ymd') === now()->format('Ymd'),
        ]) wire:key="calendar-box-mobile-{{ $content['date']->format('Y-m-d') }}">
          <div @class([
              'text-xs flex flex-col items-center justify-center',
              'font-bold text-[#3289FA]' =>
                  $content['date']->format('Ymd') === now()->format('Ymd'),
              'text-[#48CBFF]' =>
                  $content['date']->format('Ymd') !== now()->format('Ymd') &&
                  $content['date']->isoFormat('ddd') === '土',
              'text-[#FF0000]' =>
                  $content['date']->format('Ymd') !== now()->format('Ymd') &&
                  $content['date']->isoFormat('ddd') === '日',
          ])>
            <div>{{ $content['date']->isoFormat('D日') }}</div>

            <div>{{ $content['date']->isoFormat('（ddd）') }}</div>
          </div>
          <div class="flex flex-col space-y-1">
            @foreach ($content['shifts'] as $shift)
              <div
                class="flex cursor-pointer items-center justify-between space-x-[6px] rounded-lg border border-[#39A338] bg-[#F6FFF6] px-[10px] py-[7px] text-xs text-[#39A338]"
                x-on:click="$dispatch('open-modal','edit-modal-{{ $shift->id }}')"
                wire:click="setSchedule({{ $shift->id }})">
                <div class="flex items-center space-x-2">
                  <div
                    class="flex h-[22px] w-[22px] items-center justify-center rounded bg-[#39A338] text-xs text-white">
                    確
                  </div>
                  <div class="font-semibold">
                    {{ $shift->start_time->isoFormat('aH時mm分') }}～{{ $shift->end_time->isoFormat('HH:mm') }}
                  </div>
                </div>
                <div class="">{{ $shift->user->name }}</div>
              </div>
              @include('shift::admin.livewire.layouts.shift-edit', ['schedule' => $shift])
            @endforeach

            @foreach ($content['drafts'] as $draft)
              <div
                class="flex cursor-pointer items-center justify-between space-x-[6px] rounded-lg border border-[#DE993A] bg-[#FFF7EC] px-[10px] py-[7px] text-xs text-[#DE993A]"
                wire:click="upShift({{ $draft->id }})">
                <div class="flex items-center space-x-2">
                  <div
                    class="flex h-[22px] w-[22px] items-center justify-center rounded bg-[#DE993A] text-xs text-white">
                    希
                  </div>
                  <div class="font-semibold">
                    {{ $draft->start_time->isoFormat('aH時mm分') }}～{{ $draft->end_time->isoFormat('HH:mm') }}
                  </div>
                </div>
                <div>{{ $draft->user->name }}</div>
              </div>
            @endforeach

          </div>
          <div class="flex items-center justify-center">
            @include('shift::admin.livewire.layouts.shift-create')
          </div>
        </div>
      @endforeach
    </div>

    {{-- <livewire:shift::admin.manager-edit :$manager @updated="$refresh" /> --}}
  </x-dashboard.container>
</x-dashboard.index>
