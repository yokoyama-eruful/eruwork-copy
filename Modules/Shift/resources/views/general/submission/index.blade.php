<x-app-layout>
  <x-main.index>
    <x-main.top>
      <a class="flex items-center space-x-[10px] hover:opacity-40 sm:space-x-0"
        href="{{ route('shift.schedule', ['category' => 'week']) }}">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
            d="M5.78988 9.39751C5.68455 9.29204 5.62538 9.14907 5.62538 9.00001C5.62538 8.85094 5.68455 8.70798 5.78988 8.60251L11.4149 2.97751C11.5215 2.87815 11.6626 2.82405 11.8083 2.82663C11.954 2.8292 12.093 2.88823 12.1961 2.99129C12.2992 3.09435 12.3582 3.23339 12.3608 3.37911C12.3633 3.52484 12.3092 3.66588 12.2099 3.77251L6.98238 9.00001L12.2099 14.2275C12.2651 14.279 12.3095 14.3411 12.3402 14.4101C12.371 14.4791 12.3875 14.5536 12.3888 14.6291C12.3902 14.7046 12.3763 14.7797 12.348 14.8497C12.3197 14.9197 12.2776 14.9834 12.2242 15.0368C12.1707 15.0902 12.1071 15.1323 12.0371 15.1606C11.967 15.1889 11.892 15.2028 11.8165 15.2015C11.741 15.2001 11.6665 15.1836 11.5975 15.1528C11.5285 15.1221 11.4664 15.0778 11.4149 15.0225L5.78988 9.39751Z"
            fill="#3289FA" />
        </svg>
        <p class="hidden ps-[2px] text-sm font-bold text-[#3289FA] sm:block">シフト画面に戻る</p>
        <h5 class="block text-xl font-bold sm:hidden">シフト表一覧</h5>
      </a>
    </x-main.top>
    <x-main.container>
      <div class="hidden items-center justify-between sm:flex">
        <h5 class="text-xl font-bold">シフト表一覧</h5>
        {{-- <div class="flex items-center">
          <p class="text-xs">シフト提出依頼：</p>
          <div class="ml-3 rounded bg-[#F7F7F7] px-5 py-[13px]">

          </div>
        </div> --}}
      </div>
      {{-- デスクトップ版  --}}
      <div class="mt-[30px] hidden grid-cols-[10%,64%,14%,12%] sm:grid">
        <div class="px-[30px] text-left text-xs font-normal text-[#AAB0B6]">ステータス</div>
        <div class="text-left text-xs font-normal text-[#AAB0B6]">期間</div>
        <div class="text-left text-xs font-normal text-[#AAB0B6]">受付終了日</div>
        <div class="text-center text-xs font-normal text-[#AAB0B6]"></div>
      </div>
      <div class="mt-[24px] rounded-lg border-b sm:-mx-0 sm:mt-[8px] sm:border">
        @foreach ($managers as $manager)
          <div @class([
              'sm:grid sm:grid-cols-[10%,64%,14%,12%] sm:py-[30px] py-3 text-[15px] sm:px-0 px-5 cursor-pointer',
              'border-b' => !$loop->last,
          ])>
            <div @class([
                'hidden truncate px-[12px] w-fit font-bold sm:block text-xs text-white mx-[30px] rounded-full py-1',
                'bg-[#48CBFF]' => $manager->ReceptionStatus === '受付中',
                'bg-[#F76E80]' => $manager->ReceptionStatus === '受付終了',
                'bg-[#7F8E94]' => $manager->ReceptionStatus === '準備中',
            ])>
              {{ $manager->ReceptionStatus }}
            </div>

            <div class="text-[15px] font-bold">
              {{ $manager->start_date->isoFormat('YYYY年MM月DD日（ddd）') }}～{{ $manager->end_date->isoFormat('YYYY年MM月DD日（ddd）') }}
            </div>

            <div class="text-[15px]">{{ $manager->submission_end_date->isoFormat('YYYY年MM月DD日') }}</div>

            <a class="text-center text-[#3289FA] hover:opacity-40"
              href="{{ route('shift.submission.show', ['manager' => $manager]) }}">表示する</a>
          </div>
        @endforeach
      </div>

      {{-- モバイル版 --}}
      <div class="mt-[30px] block sm:hidden">
        <div class="mx-5 rounded-lg border">
          @foreach ($managers as $manager)
            <div @class(['py-5 px-[13px] cursor-pointer', 'border-b' => !$loop->last])
              onclick="window.location='{{ route('shift.submission.show', ['manager' => $manager]) }}'">
              <div class="flex items-center justify-between">
                <div @class([
                    'px-[15px] py-1 flex items-center justify-center rounded-full text-[10px] font-bold text-white',
                    'bg-[#F76E80]' => $manager->ReceptionStatus === '終了',
                    'bg-[#48CBFF]' => $manager->ReceptionStatus === '受付中',
                    'bg-[#39A338]' => $manager->ReceptionStatus === '準備中',
                ])>{{ $manager->ReceptionStatus }}</div>
                <div class="flex items-center space-x-[10px] text-xs">
                  <div class="text-[#AAB0B6]">受付終了日:</div>
                  <div>{{ $manager->submission_end_date->isoFormat('YYYY年MM月DD日') }}</div>
                </div>
              </div>
              <div class="mt-3 text-sm font-bold">
                {{ $manager->start_date->isoFormat('YYYY年MM月DD日（ddd）') }}　～　{{ $manager->end_date->isoFormat('YYYY年MM月DD日（ddd）') }}
              </div>
            </div>
          @endforeach
        </div>
      </div>

      {{ $managers->links('vendor.pagination.tailwind') }}
    </x-main.container>
  </x-main.index>
</x-app-layout>
