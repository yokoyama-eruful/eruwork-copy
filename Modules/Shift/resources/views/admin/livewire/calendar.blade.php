{{-- <div class="w-full rounded-t bg-white py-2 xl:px-5">
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
</div> --}}

<x-dashboard.index>
  <x-dashboard.top>
    <div class="flex items-center space-x-[30px]">
      <a class="flex items-center space-x-[2px] hover:opacity-40" href="{{ route('shiftManager.index') }}">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
            d="M5.78964 9.39738C5.6843 9.29192 5.62514 9.14895 5.62514 8.99988C5.62514 8.85082 5.6843 8.70785 5.78964 8.60238L11.4146 2.97738C11.5213 2.87802 11.6623 2.82393 11.808 2.8265C11.9538 2.82907 12.0928 2.88811 12.1959 2.99117C12.2989 3.09423 12.358 3.23327 12.3605 3.37899C12.3631 3.52472 12.309 3.66575 12.2096 3.77238L6.98214 8.99988L12.2096 14.2274C12.2649 14.2789 12.3092 14.341 12.34 14.41C12.3707 14.479 12.3873 14.5535 12.3886 14.629C12.3899 14.7045 12.376 14.7795 12.3477 14.8496C12.3194 14.9196 12.2773 14.9832 12.2239 15.0367C12.1705 15.0901 12.1069 15.1322 12.0368 15.1605C11.9668 15.1888 11.8918 15.2027 11.8162 15.2013C11.7407 15.2 11.6662 15.1835 11.5972 15.1527C11.5282 15.122 11.4661 15.0777 11.4146 15.0224L5.78964 9.39738Z"
            fill="#3289FA" />
        </svg>
        <div class="text-sm font-bold text-[#3289FA]">一覧画面に戻る</div>
      </a>
      <div class="h-[35px] border-l"></div>
      {{-- <div class="flex items-center space-x-[6px] hover:opacity-40">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M6.07992 10.8382C8.87144 10.5322 11.6899 10.5544 14.4775 10.9041L15.0879 10.9855C15.4295 11.034 15.6669 11.3502 15.6185 11.6919C15.5787 11.9726 15.358 12.1798 15.0911 12.2192L15.2873 14.375H15.6242L15.7471 14.3693C15.8692 14.3573 15.9889 14.3269 16.1027 14.2798C16.2544 14.217 16.3927 14.1249 16.5088 14.0088C16.6248 13.8928 16.717 13.7551 16.7798 13.6035C16.8426 13.4518 16.875 13.2892 16.875 13.125V7.88005C16.875 7.27348 16.4465 6.7707 15.8765 6.68538C15.3549 6.60737 14.8318 6.53977 14.3075 6.48275C11.4443 6.17122 8.55569 6.17122 5.69255 6.48275C5.16824 6.53977 4.64513 6.60737 4.12354 6.68538C3.55352 6.7707 3.125 7.27348 3.125 7.88005V13.125C3.125 13.4565 3.25679 13.7744 3.49121 14.0088C3.72563 14.2432 4.04348 14.375 4.375 14.375H4.71273L4.90804 12.2192C4.64153 12.1795 4.42128 11.9723 4.38151 11.6919C4.33311 11.3502 4.57047 11.034 4.91211 10.9855C5.11547 10.9567 5.31908 10.9296 5.52246 10.9041L6.07992 10.8382ZM13.8232 12.085C11.282 11.8034 8.71723 11.8034 6.17594 12.085L5.71533 17.159C5.69862 17.3425 5.84246 17.5 6.0262 17.5H13.9738C14.0172 17.5 14.0602 17.4907 14.0999 17.4731C14.1397 17.4556 14.1756 17.4303 14.2049 17.3983C14.2342 17.3662 14.2562 17.3279 14.27 17.2868C14.2769 17.2664 14.2813 17.2454 14.2839 17.2241L14.2847 17.159L14.0975 15.0928C14.0943 15.0714 14.0919 15.0497 14.091 15.0277L13.8232 12.085ZM12.5065 8.125C12.8517 8.125 13.1315 8.40482 13.1315 8.75V8.75651C13.1315 9.10169 12.8517 9.38151 12.5065 9.38151H12.5C12.1548 9.38151 11.875 9.10169 11.875 8.75651V8.75C11.875 8.40482 12.1548 8.125 12.5 8.125H12.5065ZM15.0065 8.125C15.3517 8.125 15.6315 8.40482 15.6315 8.75V8.75651C15.6315 9.10169 15.3517 9.38151 15.0065 9.38151H15C14.6548 9.38151 14.375 9.10169 14.375 8.75651V8.75C14.375 8.40482 14.6548 8.125 15 8.125H15.0065ZM13.75 2.8125C13.75 2.64018 13.6098 2.5 13.4375 2.5H6.5625C6.39018 2.5 6.25 2.64018 6.25 2.8125V5.17171C8.74481 4.94297 11.2552 4.94297 13.75 5.17171V2.8125ZM15 5.30599C15.3544 5.3495 15.7088 5.39639 16.062 5.44922C17.2735 5.6307 18.125 6.68504 18.125 7.88005V13.125L18.1128 13.3708C18.0887 13.6149 18.0288 13.8546 17.9346 14.082C17.8089 14.3854 17.6248 14.6612 17.3926 14.8934C17.1603 15.1255 16.8846 15.3098 16.5812 15.4354C16.3536 15.5296 16.1134 15.5888 15.8691 15.6128L15.6242 15.625H15.4012L15.5298 17.0459L15.5363 17.2078C15.5342 17.37 15.5068 17.5312 15.4549 17.6855C15.3857 17.8913 15.2741 18.0802 15.1278 18.2406C14.9814 18.4009 14.8031 18.5297 14.6045 18.6173C14.4061 18.7049 14.1915 18.7499 13.9746 18.75H6.0262C5.10663 18.75 4.38696 17.9607 4.47021 17.0459L4.5988 15.625H4.375C3.71196 15.625 3.07626 15.3614 2.60742 14.8926C2.13858 14.4237 1.875 13.788 1.875 13.125V7.88005C1.875 6.68504 2.7265 5.6307 3.93799 5.44922C4.29118 5.39639 4.64556 5.3495 5 5.30599V2.8125C5 1.94982 5.69982 1.25 6.5625 1.25H13.4375C14.3002 1.25 15 1.94982 15 2.8125V5.30599Z"
            fill="#3289FA" />
        </svg>
        <div class="text-sm font-bold text-[#3289FA]">印刷する</div>
      </div> --}}
    </div>
  </x-dashboard.top>
  <x-dashboard.container>
    <h5 class="hidden text-xl font-bold sm:block">シフト管理</h5>
    <div class="mt-[20px] flex items-center space-x-2">
      <div class="text-xs text-[#AAB0B6]">期間:</div>
      <div class="text-[20px] font-semibold">
        {{ $manager->submission_start_date->isoFormat('M月D日（ddd）') }}　～　{{ $manager->submission_end_date->isoFormat('M月D日（ddd）') }}
      </div>
    </div>

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

          {{-- <livewire:shift::admin.shift-table :type="$content['type']" :date="$content['date']" :shifts="$content['shifts']" :drafts="$content['drafts']"
            :key="$content['date']->format('Ymd')" /> --}}

        </div>
      @endforeach
    </div>

    {{-- <livewire:shift::admin.manager-edit :$manager @updated="$refresh" /> --}}
  </x-dashboard.container>
</x-dashboard.index>
