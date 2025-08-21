{{-- <div>
  <div class="overflow-hidden rounded-lg bg-white">
    <div class="flex flex-col items-center py-2 xl:flex-row xl:justify-between">
      <div class="flex w-full flex-row items-center space-x-5 pb-2 xl:w-auto xl:pb-0">
        <a class="inline-block rounded border border-transparent bg-ao-main px-2 py-1 text-white transition duration-300 ease-in-out hover:bg-sky-600 hover:text-gray-100"
          href="{{ route('board.create') }}">
          <div class="flex flex-row items-center justify-center space-x-3">
            <i class="fa-solid fa-plus"></i>
            <p>新規投稿</p>
          </div>
        </a>
        <a class="inline-block rounded border border-transparent bg-ao-main px-2 py-1 text-white transition duration-300 ease-in-out hover:bg-sky-600 hover:text-gray-100"
          href="{{ route('draft.index') }}">
          <div class="flex flex-row items-center justify-center space-x-3">
            <i class="fa-solid fa-check"></i>
            <p>下書き一覧</p>
          </div>
        </a>
      </div>
      <div class="w-full xl:w-auto">
        <div class="relative">
          <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
            <i class="fa-solid fa-magnifying-glass h-4 w-4 text-gray-500"></i>
          </div>
          <input
            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
            type="search" wire:model.live="search" placeholder="表題検索..." required />
        </div>
      </div>
    </div>

    @if ($posts->isEmpty())
      <p>投稿はありません</p>
    @else
      <table class="min-w-full table-auto rounded-lg bg-white shadow-lg">
        <thead>
          <tr class="border-t-4 border-t-ao-main bg-ao-sub text-left">
            <th class="py-2 text-left font-medium text-gray-600"></th>
            <th class="py-2 pr-4 text-left font-medium text-gray-600">表題</th>
            <th class="px-1 py-2 text-left font-medium text-gray-600">作成者</th>
            <th class="px-1 py-2 text-left font-medium text-gray-600">作成日</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($posts as $post)
            <tr class='cursor-pointer hover:bg-gray-100'
              onclick="window.location.href='{{ route('board.show', ['id' => $post->id]) }}'">
              <td class="border-b border-ao-main py-2 text-center sm:w-7">
                @if ($post->attachments->isNotEmpty())
                  <i class="fas fa-paperclip mx-1 text-blue-700"></i>
                @endif
              </td>
              <td @class([
                  'sm:max-w-xs truncate border-b border-ao-main py-2 truncate max-w-20 sm:pr-4 text-blue-500 underline',
                  'text-gray-400' => $post->ReadStatus != null,
              ])>
                {!! nl2br(e($post->title)) !!}
              </td>
              <td class="border-b border-ao-main px-1 py-2">{{ $post->user->profile->name ?? 'UnknownUser' }}
              </td>
              <td class="border-b border-ao-main px-1 py-2">{{ $post->updated_at?->format('Y/m/d H:i') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>
  <div class="mt-4">
    {{ $posts->links('vendor.pagination.tailwind') }}
  </div>
</div> --}}

<x-main.index>
  <x-main.top>
    <x-main.add-a href="{{ route('board.create') }}">新規投稿</x-main.add-a>
  </x-main.top>
  <x-main.container>
    <div class="flex items-center justify-between">
      <h5 class="text-xl font-bold">掲示板</h5>
      <a class="flex items-center text-sm text-[#3289FA] hover:text-[#3289fa4d]" href="{{ route('draft.index') }}">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M1.875 15.6248V6.87476C1.87505 6.21179 2.13863 5.57597 2.60742 5.10718C3.07625 4.6384 3.71201 4.37476 4.375 4.37476H8.33333C8.67844 4.37476 8.95822 4.65467 8.95833 4.99976C8.95833 5.34493 8.67851 5.62476 8.33333 5.62476H4.375C4.04353 5.62476 3.72562 5.75661 3.49121 5.99097C3.25684 6.22534 3.12505 6.54331 3.125 6.87476V15.6248C3.125 15.9562 3.25686 16.2741 3.49121 16.5085C3.72563 16.743 4.04348 16.8748 4.375 16.8748H13.125C13.4565 16.8748 13.7744 16.743 14.0088 16.5085C14.2431 16.2741 14.375 15.9562 14.375 15.6248V11.6664C14.3751 11.3213 14.6549 11.0414 15 11.0414C15.3451 11.0414 15.6249 11.3213 15.625 11.6664V15.6248C15.625 16.2877 15.3614 16.9235 14.8926 17.3923C14.4237 17.8612 13.788 18.1248 13.125 18.1248H4.375C3.71196 18.1248 3.07626 17.8612 2.60742 17.3923C2.13865 16.9235 1.875 16.2877 1.875 15.6248ZM17.5 3.43726C17.4999 3.18864 17.4016 2.94981 17.2257 2.77401C17.0499 2.59822 16.8111 2.49976 16.5625 2.49976C16.3139 2.49976 16.0751 2.59822 15.8993 2.77401L14.9349 3.73836L16.2614 5.06486L17.2257 4.1005C17.4015 3.92466 17.5 3.6859 17.5 3.43726ZM14.0511 4.62215L7.05078 11.6233C6.72977 11.9445 6.48236 12.3312 6.3265 12.7561L6.26546 12.9408L5.92855 14.0704L7.05892 13.7343L7.24365 13.6733C7.66852 13.5174 8.05526 13.2708 8.37646 12.9498L15.3776 5.94865L14.0511 4.62215ZM18.75 3.43726C18.75 4.01742 18.5197 4.57403 18.1095 4.98429L9.26025 13.8336C8.74635 14.3472 8.11251 14.7248 7.41618 14.9322L5.17822 15.5987C4.95832 15.6642 4.72035 15.6039 4.55811 15.4417C4.39591 15.2794 4.33554 15.0414 4.40104 14.8215L5.06755 12.5844C5.2749 11.8879 5.65249 11.2535 6.16618 10.7395L15.0155 1.89103C15.4257 1.48082 15.9823 1.24976 16.5625 1.24976C17.1427 1.24976 17.6993 1.48001 18.1095 1.89022C18.5198 2.30044 18.7499 2.85711 18.75 3.43726Z"
            fill="#3289FA" />
        </svg>
        <p>下書き一覧</p>
      </a>
    </div>

    <div class="mt-[30px] grid grid-cols-[60%,10%,10%,10%,1fr]">
      <div class="ps-[30px] text-left text-xs font-normal text-[#AAB0B6]">表題</div>
      <div class="text-left text-xs font-normal text-[#AAB0B6]">作成者</div>
      <div class="text-left text-xs font-normal text-[#AAB0B6]">作成日時</div>
      <div class="text-left text-xs font-normal text-[#AAB0B6]">添付ファイル</div>
      <div class="text-left text-xs font-normal text-[#AAB0B6]"></div>
    </div>

    <div class="mt-[11px] grid grid-cols-[60%,10%,10%,10%,1fr] rounded-lg border">

    </div>

    {{-- <div class="mt-[30px] w-full overflow-hidden rounded-lg border">
      <table class="w-full">
        <thead class="bg-gray-50">
          <tr>
            <th class="w-[70%] ps-[30px] text-left text-xs font-normal text-[#AAB0B6]">表題</th>
            <th class="w-[10%] text-left text-xs font-normal text-[#AAB0B6]">作成者</th>
            <th class="w-[10%] text-left text-xs font-normal text-[#AAB0B6]">作成日時</th>
            <th class="w-[10%] text-left text-xs font-normal text-[#AAB0B6]">添付ファイル</th>
            <th class="w-[5%]"></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($posts as $post)
            <tr @class(['h-20', 'border-b' => !$loop->last])>
              <td class="truncate ps-[30px] text-[15px] font-bold">{!! nl2br(e($post->title)) !!}</td>
              <td class="truncate text-[15px]">{{ $post->user->profile->name ?? 'UnknownUser' }}</td>
              <td>{{ $post->updated_at?->format('Y年m月d日') }}</td>
              <td>📎</td>
              <td>…</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div> --}}
  </x-main.container>
</x-main.index>
