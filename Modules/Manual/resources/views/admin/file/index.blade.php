<x-dashboard-layout>
  <x-dashboard.index>
    <x-dashboard.top>
      <a class="flex items-center space-x-[2px] text-[#3289FA] hover:opacity-40"
        href="{{ route('manualFolderManager.index') }}">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
            d="M5.78964 9.39738C5.6843 9.29192 5.62514 9.14895 5.62514 8.99988C5.62514 8.85082 5.6843 8.70785 5.78964 8.60238L11.4146 2.97738C11.5213 2.87802 11.6623 2.82393 11.808 2.8265C11.9538 2.82907 12.0928 2.88811 12.1959 2.99117C12.2989 3.09423 12.358 3.23327 12.3605 3.37899C12.3631 3.52472 12.309 3.66575 12.2096 3.77238L6.98214 8.99988L12.2096 14.2274C12.2649 14.2789 12.3092 14.341 12.34 14.41C12.3707 14.479 12.3873 14.5535 12.3886 14.629C12.3899 14.7045 12.376 14.7795 12.3477 14.8496C12.3194 14.9196 12.2773 14.9832 12.2239 15.0367C12.1705 15.0901 12.1069 15.1322 12.0368 15.1605C11.9668 15.1888 11.8918 15.2027 11.8162 15.2013C11.7407 15.2 11.6662 15.1835 11.5972 15.1527C11.5282 15.122 11.4661 15.0777 11.4146 15.0224L5.78964 9.39738Z"
            fill="#3289FA" />
        </svg>
        <p class="text-sm font-bold">一覧画面に戻る</p>
      </a>
      <div class="mx-[30px] h-[35px] border-r"></div>
      <a class='flex h-[35px] items-center rounded-[5px] bg-[#3289fa] px-5 py-2 text-sm font-bold text-[#fff] hover:bg-[#3289fa4d]'
        href="{{ route('manualFileManager.create', ['folder_id' => $folder->id]) }}">
        <img class="mr-[5px] h-[15px] w-[15px]" src="{{ global_asset('img/icon/add-schedule.png') }}" />
        新規作成
      </a>
    </x-dashboard.top>
    <x-dashboard.container>
      <h5 class="text-xl font-bold">{{ $folder->title }}</h5>
      <div class="mt-[30px] grid grid-cols-[10%,5%,41%,21%,21%,2%] px-5">
        <div class="text-xs text-[#AAB0B6]">サムネイル</div>
        <div class="text-xs text-[#AAB0B6]"></div>
        <div class="text-xs text-[#AAB0B6]">表題</div>
        <div class="text-xs text-[#AAB0B6]">メンバー</div>
        <div class="text-xs text-[#AAB0B6]">更新日</div>
        <div class="text-xs text-[#AAB0B6]"></div>
      </div>
      <div class="mt-[10px] rounded-xl border">
        @foreach ($files as $file)
          <div @class([
              'grid grid-cols-[10%,5%,41%,21%,21%,2%] py-[20px] text-[15px] items-center min-h-[121px] px-5',
              'border-b' => !$loop->last,
          ])>
            <img class="max-h-[80px] max-w-[145px] rounded"
              src="{{ global_asset('tenants/' . tenant()->id . '/app/' . $file->thumbnail_path) }}" />

            <div class="flex justify-end pr-1">
              @if (str_contains($file->type, 'video'))
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M13.125 8.75L17.0583 4.81667C17.1457 4.72937 17.2571 4.66993 17.3782 4.64586C17.4994 4.62179 17.625 4.63417 17.7391 4.68143C17.8532 4.72869 17.9508 4.80871 18.0195 4.91139C18.0882 5.01407 18.1249 5.1348 18.125 5.25833V14.7417C18.1249 14.8652 18.0882 14.9859 18.0195 15.0886C17.9508 15.1913 17.8532 15.2713 17.7391 15.3186C17.625 15.3658 17.4994 15.3782 17.3782 15.3541C17.2571 15.3301 17.1457 15.2706 17.0583 15.1833L13.125 11.25M3.75 15.625H11.25C11.7473 15.625 12.2242 15.4275 12.5758 15.0758C12.9275 14.7242 13.125 14.2473 13.125 13.75V6.25C13.125 5.75272 12.9275 5.27581 12.5758 4.92417C12.2242 4.57254 11.7473 4.375 11.25 4.375H3.75C3.25272 4.375 2.77581 4.57254 2.42417 4.92417C2.07254 5.27581 1.875 5.75272 1.875 6.25V13.75C1.875 14.2473 2.07254 14.7242 2.42417 15.0758C2.77581 15.4275 3.25272 15.625 3.75 15.625Z"
                    stroke="#3289FA" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              @endif
            </div>

            <div class="font-bold">{{ $file->title }}</div>

            <div>{{ $file->user->name ?? '' }}</div>

            <div>{{ $file->updated_at->format('Y年m月d日') ?? '' }}</div>

            <div class="flex items-center justify-end">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.25 4.5L15.75 12L8.25 19.5" stroke="#AAB0B6" stroke-width="1.5" stroke-linecap="round"
                  stroke-linejoin="round" />
              </svg>
            </div>
          </div>
        @endforeach
      </div>
    </x-dashboard.container>
  </x-dashboard.index>
</x-dashboard-layout>
