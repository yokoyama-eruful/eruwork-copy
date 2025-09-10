<x-dashboard-layout>
  <x-dashboard.index>
    <x-dashboard.top>
      <a class='flex h-[35px] items-center rounded-[5px] bg-[#3289fa] px-5 py-2 text-sm font-bold text-[#fff] hover:bg-[#3289fa4d]'
        href="#">
        <img class="mr-[5px] h-[15px] w-[15px]" src="{{ global_asset('img/icon/add-schedule.png') }}" />
        新規作成
      </a>
    </x-dashboard.top>
    <x-dashboard.container>
      <h5 class="text-xl font-bold">マニュアル管理</h5>
      <div class="mt-[30px] grid grid-cols-[70%,10%,10%,5%,5%]">
        <div class="pl-[30px] text-xs text-[#AAB0B6]">表題</div>
        <div class="text-xs text-[#AAB0B6]">メンバー</div>
        <div class="text-xs text-[#AAB0B6]">更新日</div>
        <div></div>
        <div></div>
      </div>
      <div class="mt-[10px] rounded-xl border">
        @foreach ($folders as $folder)
          <div @class([
              'grid grid-cols-[70%,10%,10%,5%,5%] py-[30px] text-[15px]',
              'border-b' => !$loop->last,
          ])>
            <div class="pl-[30px] font-bold">{{ $folder->title }}</div>
            <div>{{ $folder->user->name }}</div>
            <div>{{ $folder->updated_at?->format('Y年m月d日') }}</div>
            <div>
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M4.5 12C4.5 11.6022 4.65804 11.2206 4.93934 10.9393C5.22064 10.658 5.60218 10.5 6 10.5C6.39782 10.5 6.77936 10.658 7.06066 10.9393C7.34196 11.2206 7.5 11.6022 7.5 12C7.5 12.3978 7.34196 12.7794 7.06066 13.0607C6.77936 13.342 6.39782 13.5 6 13.5C5.60218 13.5 5.22064 13.342 4.93934 13.0607C4.65804 12.7794 4.5 12.3978 4.5 12ZM10.5 12C10.5 11.6022 10.658 11.2206 10.9393 10.9393C11.2206 10.658 11.6022 10.5 12 10.5C12.3978 10.5 12.7794 10.658 13.0607 10.9393C13.342 11.2206 13.5 11.6022 13.5 12C13.5 12.3978 13.342 12.7794 13.0607 13.0607C12.7794 13.342 12.3978 13.5 12 13.5C11.6022 13.5 11.2206 13.342 10.9393 13.0607C10.658 12.7794 10.5 12.3978 10.5 12ZM16.5 12C16.5 11.6022 16.658 11.2206 16.9393 10.9393C17.2206 10.658 17.6022 10.5 18 10.5C18.3978 10.5 18.7794 10.658 19.0607 10.9393C19.342 11.2206 19.5 11.6022 19.5 12C19.5 12.3978 19.342 12.7794 19.0607 13.0607C18.7794 13.342 18.3978 13.5 18 13.5C17.6022 13.5 17.2206 13.342 16.9393 13.0607C16.658 12.7794 16.5 12.3978 16.5 12Z"
                  fill="#AAB0B6" />
              </svg>
            </div>
            <a href="{{ route('manualFileManager.index', ['folder_id' => $folder->id]) }}">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.25 4.5L15.75 12L8.25 19.5" stroke="#AAB0B6" stroke-width="1.5" stroke-linecap="round"
                  stroke-linejoin="round" />
              </svg>
            </a>
          </div>
        @endforeach
      </div>
    </x-dashboard.container>
  </x-dashboard.index>
</x-dashboard-layout>
