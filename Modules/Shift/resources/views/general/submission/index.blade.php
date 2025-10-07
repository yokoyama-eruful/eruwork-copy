<x-app-layout :url="route('shift.schedule', ['category' => 'week'])">
  <x-main.index>
    <x-main.top>
      <h5 class="block text-xl font-bold sm:hidden">シフト表一覧</h5>
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
      @if ($managers->total() === 0)
        <div class="mt-[30px] flex h-[calc(100vh-190px)] flex-col items-center justify-center rounded-xl border">
          <svg width="55" height="55" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g opacity="0.1">
              <path fill-rule="evenodd" clip-rule="evenodd"
                d="M6.25 23.4375C6.25 19.1208 9.75 15.625 14.0625 15.625H85.9375C90.25 15.625 93.75 19.125 93.75 23.4375V76.5625C93.75 80.875 90.25 84.375 85.9375 84.375H14.0625C11.9905 84.375 10.0034 83.5519 8.53823 82.0868C7.0731 80.6216 6.25 78.6345 6.25 76.5625V23.4375ZM87.5 39.0625C87.5 38.6481 87.3354 38.2507 87.0424 37.9576C86.7493 37.6646 86.3519 37.5 85.9375 37.5H54.6875C54.2731 37.5 53.8757 37.6646 53.5826 37.9576C53.2896 38.2507 53.125 38.6481 53.125 39.0625V45.3125C53.125 46.175 53.825 46.875 54.6875 46.875H85.9375C86.3519 46.875 86.7493 46.7104 87.0424 46.4174C87.3354 46.1243 87.5 45.7269 87.5 45.3125V39.0625ZM87.5 54.6875C87.5 54.2731 87.3354 53.8757 87.0424 53.5826C86.7493 53.2896 86.3519 53.125 85.9375 53.125H54.6875C54.2731 53.125 53.8757 53.2896 53.5826 53.5826C53.2896 53.8757 53.125 54.2731 53.125 54.6875V60.9375C53.125 61.8 53.825 62.5 54.6875 62.5H85.9375C86.3519 62.5 86.7493 62.3354 87.0424 62.0424C87.3354 61.7493 87.5 61.3519 87.5 60.9375V54.6875ZM87.5 70.3125C87.5 69.8981 87.3354 69.5007 87.0424 69.2076C86.7493 68.9146 86.3519 68.75 85.9375 68.75H54.6875C54.2731 68.75 53.8757 68.9146 53.5826 69.2076C53.2896 69.5007 53.125 69.8981 53.125 70.3125V76.5625C53.125 77.425 53.825 78.125 54.6875 78.125H85.9375C86.3519 78.125 86.7493 77.9604 87.0424 77.6674C87.3354 77.3743 87.5 76.9769 87.5 76.5625V70.3125ZM45.3125 78.125C45.7269 78.125 46.1243 77.9604 46.4174 77.6674C46.7104 77.3743 46.875 76.9769 46.875 76.5625V70.3125C46.875 69.8981 46.7104 69.5007 46.4174 69.2076C46.1243 68.9146 45.7269 68.75 45.3125 68.75H14.0625C13.6481 68.75 13.2507 68.9146 12.9576 69.2076C12.6646 69.5007 12.5 69.8981 12.5 70.3125V76.5625C12.5 77.425 13.2 78.125 14.0625 78.125H45.3125ZM14.0625 62.5H45.3125C45.7269 62.5 46.1243 62.3354 46.4174 62.0424C46.7104 61.7493 46.875 61.3519 46.875 60.9375V54.6875C46.875 54.2731 46.7104 53.8757 46.4174 53.5826C46.1243 53.2896 45.7269 53.125 45.3125 53.125H14.0625C13.6481 53.125 13.2507 53.2896 12.9576 53.5826C12.6646 53.8757 12.5 54.2731 12.5 54.6875V60.9375C12.5 61.8 13.2 62.5 14.0625 62.5ZM14.0625 46.875H45.3125C45.7269 46.875 46.1243 46.7104 46.4174 46.4174C46.7104 46.1243 46.875 45.7269 46.875 45.3125V39.0625C46.875 38.6481 46.7104 38.2507 46.4174 37.9576C46.1243 37.6646 45.7269 37.5 45.3125 37.5H14.0625C13.6481 37.5 13.2507 37.6646 12.9576 37.9576C12.6646 38.2507 12.5 38.6481 12.5 39.0625V45.3125C12.5 46.175 13.2 46.875 14.0625 46.875Z"
                fill="black" />
            </g>
          </svg>
          <div class="mt-5 text-[20px] font-bold text-[#222222] text-opacity-10">シフト表がありません</div>
        </div>
      @else
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
                  'bg-[#F76E80]' => $manager->ReceptionStatus === '終了',
                  'bg-[#7F8E94]' => $manager->ReceptionStatus === '準備中',
              ])>
                {{ $manager->ReceptionStatus }}
              </div>

              <div class="text-[15px] font-bold">
                {{ $manager->start_date->isoFormat('YYYY年MM月DD日（ddd）') }}～{{ $manager->end_date->isoFormat('YYYY年MM月DD日（ddd）') }}
              </div>

              <div class="hidden text-[15px] sm:block">{{ $manager->submission_end_date->isoFormat('YYYY年MM月DD日') }}
              </div>

              <a class="hidden text-center text-[#3289FA] hover:opacity-40 sm:block"
                href="{{ route('shift.submission.show', ['manager' => $manager]) }}">表示する</a>
            </div>
          @endforeach
        </div>
      @endif

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
