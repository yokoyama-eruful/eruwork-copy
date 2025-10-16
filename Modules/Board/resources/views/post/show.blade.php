<x-app-layout :url="route('board.index')">
  <x-main.index>
    <x-main.top>
      <a class="hidden items-center lg:flex" href="{{ route('board.index') }}">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
            d="M5.78964 9.39738C5.6843 9.29192 5.62514 9.14895 5.62514 8.99988C5.62514 8.85082 5.6843 8.70785 5.78964 8.60238L11.4146 2.97738C11.5213 2.87802 11.6623 2.82393 11.808 2.8265C11.9538 2.82907 12.0928 2.88811 12.1959 2.99117C12.2989 3.09423 12.358 3.23327 12.3605 3.37899C12.3631 3.52472 12.309 3.66575 12.2096 3.77238L6.98214 8.99988L12.2096 14.2274C12.2649 14.2789 12.3092 14.341 12.34 14.41C12.3707 14.479 12.3873 14.5535 12.3886 14.629C12.3899 14.7045 12.376 14.7795 12.3477 14.8496C12.3194 14.9196 12.2773 14.9832 12.2239 15.0367C12.1705 15.0901 12.1069 15.1322 12.0368 15.1605C11.9668 15.1888 11.8918 15.2027 11.8162 15.2013C11.7407 15.2 11.6662 15.1835 11.5972 15.1527C11.5282 15.122 11.4661 15.0777 11.4146 15.0224L5.78964 9.39738Z"
            fill="#3289FA" />
        </svg>
        <p class="text-sm font-bold text-[#3289FA]">一覧画面に戻る</p>
      </a>
      <div class="w-full lg:hidden">
        <div class="flex items-center justify-between">
          <h5 class="text-[15px] text-[#AAB0B6]">{{ $post->created_at?->format('Y.m.d') }}</h5>
          <div class="flex items-center">
            <div class="text-xs text-[#AAB0B6]">作成者:</div>
            <div class="pl-[6px] text-[15px]">{{ $post->user->name }}</div>
          </div>
        </div>
        <div class="mt-2 flex items-center justify-between">
          <div class="break-words text-[22px] font-bold">{{ $post->title }}</div>
        </div>
      </div>
    </x-main.top>
    <x-main.container>
      <div class="mx-auto flex flex-col lg:max-w-[70%]">
        <h5 class="hidden text-[15px] text-[#AAB0B6] lg:block">{{ $post->created_at?->format('Y.m.d') }}</h5>
        <div class="mt-2 hidden grid-cols-[90%,10%] items-end justify-between lg:grid">
          <div class="break-words text-[22px] font-bold">{{ $post->title }}</div>
          <div class="flex items-center justify-end">
            <div class="text-xs text-[#AAB0B6]">作成者:</div>
            <div class="pl-[6px] text-[15px]">{{ $post->user->name }}</div>
          </div>
        </div>
        <div class="mt-[19px] border-t"></div>
        <div class="p-5 text-[15px] leading-8 lg:p-0 lg:pb-[10px] lg:pt-5" x-ref="element" readonly>
          {!! $post->contents !!}
        </div>
        <livewire:board::download :post="$post" :canBeDeleted="false" />
        <livewire:board::like :postId="$post->id" />
      </div>
    </x-main.container>
  </x-main.index>

</x-app-layout>
