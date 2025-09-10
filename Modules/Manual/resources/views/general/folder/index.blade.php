<x-app-layout>
  <x-main.index>
    <x-main.top>
    </x-main.top>
    <x-main.container>
      <h5 class="text-xl font-bold">マニュアル</h5>
      <div class="mt-8">
        <div class="grid grid-cols-[95%,5%] px-[30px] text-xs text-[#AAB0B6]">
          <div>表題</div>
          <div></div>
        </div>
        <div class="mt-2 rounded-lg border border-[#DDDDDD]">
          @foreach ($folders as $folder)
            <div @class([
                'grid grid-cols-[95%,5%]  px-[30px] text-[15px] py-[30px]',
                'border-b' => !$loop->last,
            ])>
              <div class="break-words font-bold">{{ $folder->title }}</div>
              <a class="flex items-center justify-end hover:opacity-40"
                href="{{ route('manualFile.index', ['folder_id' => $folder->id]) }}">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M8.25 4.5L15.75 12L8.25 19.5" stroke="#AAB0B6" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
              </a>
            </div>
          @endforeach
        </div>
      </div>
    </x-main.container>
  </x-main.index>
</x-app-layout>
