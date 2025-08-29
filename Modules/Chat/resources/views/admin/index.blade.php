<x-dashboard-layout>
  <x-dashboard.index>
    <x-dashboard.top>
      <a class='flex h-[35px] items-center rounded-[5px] bg-[#3289fa] px-5 py-2 text-sm font-bold text-[#fff] hover:bg-[#3289fa4d]'
        href="{{ route('chatManager.create') }}">
        <img class="mr-[5px] h-[15px] w-[15px]" src="{{ global_asset('img/icon/add-schedule.png') }}" />
        グループを追加
      </a>
    </x-dashboard.top>
    <x-dashboard.container>
      <h5 class="hidden text-xl font-bold sm:block">チャット管理</h5>
      <div class="mt-[30px] hidden grid-cols-[8%,29%,45%,14%,4%] sm:grid">
        <div class="pl-[25px] pr-[20px] text-left text-xs font-normal text-[#AAB0B6]"></div>
        <div class="pr-[20px] text-left text-xs font-normal text-[#AAB0B6]">グループ名</div>
        <div class="pr-[87px] text-left text-xs font-normal text-[#AAB0B6]">メンバー</div>
        <div class="text-left text-xs font-normal text-[#AAB0B6]">更新日</div>
        <div class="text-left text-xs font-normal text-[#AAB0B6]"></div>
      </div>
      <div class="mt-[24px] rounded-lg border-b sm:-mx-0 sm:mt-[8px] sm:border">
        @foreach ($groups as $group)
          <div @class([
              'sm:grid sm:grid-cols-[8%,29%,45%,14%,4%] sm:py-[18px] py-3 text-[15px] sm:px-0 px-5 cursor-pointer items-center',
              'border-b' => !$loop->last,
          ])>
            <div
              class="ml-[25px] mr-[20px] flex h-[45px] w-[45px] items-center justify-center overflow-hidden rounded-full bg-gray-200 text-3xl text-gray-800">
              @if ($group->icon)
                <img class="h-full w-full object-cover" src="{{ $group->icon }}">
              @else
                <div class="flex h-[45px] w-[45px] items-center justify-center rounded-full border bg-white"><i
                    class="fa-solid fa-image"></i>
                </div>
              @endif
            </div>
            <div class="truncate pr-[20px] text-[15px] font-bold">{{ $group->name }}</div>
            <div class="break-words pr-[87px] text-[15px]">{{ $group->users->implode('name', '　') }}</div>
            <div class="text-[15px]">{{ $group->updated_at->format('Y年m月d日') }}</div>

            <div class="relative block" x-data="{ openDialog{{ $group->id }}: false }">
              <div onclick="event.stopPropagation();"
                @click="openDialog{{ $group->id }} = !openDialog{{ $group->id }};">…</div>
              <div class="absolute -left-20 top-7 z-10 rounded-xl bg-white px-4 py-2 shadow-md"
                @click.away="openDialog{{ $group->id }} = false" x-show="openDialog{{ $group->id }}===true"
                x-cloak>
                <a class="flex items-center" href="{{ route('chatManager.edit', ['group' => $group]) }}">
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M1.875 15.6248V6.87476C1.87505 6.21179 2.13863 5.57597 2.60742 5.10718C3.07625 4.6384 3.71201 4.37476 4.375 4.37476H8.33333C8.67844 4.37476 8.95822 4.65467 8.95833 4.99976C8.95833 5.34493 8.67851 5.62476 8.33333 5.62476H4.375C4.04353 5.62476 3.72562 5.75661 3.49121 5.99097C3.25684 6.22534 3.12505 6.54331 3.125 6.87476V15.6248C3.125 15.9562 3.25686 16.2741 3.49121 16.5085C3.72563 16.743 4.04348 16.8748 4.375 16.8748H13.125C13.4565 16.8748 13.7744 16.743 14.0088 16.5085C14.2431 16.2741 14.375 15.9562 14.375 15.6248V11.6664C14.3751 11.3213 14.6549 11.0414 15 11.0414C15.3451 11.0414 15.6249 11.3213 15.625 11.6664V15.6248C15.625 16.2877 15.3614 16.9235 14.8926 17.3923C14.4237 17.8612 13.788 18.1248 13.125 18.1248H4.375C3.71196 18.1248 3.07626 17.8612 2.60742 17.3923C2.13865 16.9235 1.875 16.2877 1.875 15.6248ZM17.5 3.43726C17.4999 3.18864 17.4016 2.94981 17.2257 2.77401C17.0499 2.59822 16.8111 2.49976 16.5625 2.49976C16.3139 2.49976 16.0751 2.59822 15.8993 2.77401L14.9349 3.73836L16.2614 5.06486L17.2257 4.1005C17.4015 3.92466 17.5 3.6859 17.5 3.43726ZM14.0511 4.62215L7.05078 11.6233C6.72977 11.9445 6.48236 12.3312 6.3265 12.7561L6.26546 12.9408L5.92855 14.0704L7.05892 13.7343L7.24365 13.6733C7.66852 13.5174 8.05526 13.2708 8.37646 12.9498L15.3776 5.94865L14.0511 4.62215ZM18.75 3.43726C18.75 4.01742 18.5197 4.57403 18.1095 4.98429L9.26025 13.8336C8.74635 14.3472 8.11251 14.7248 7.41618 14.9322L5.17822 15.5987C4.95832 15.6642 4.72035 15.6039 4.55811 15.4417C4.39591 15.2794 4.33554 15.0414 4.40104 14.8215L5.06755 12.5844C5.2749 11.8879 5.65249 11.2535 6.16618 10.7395L15.0155 1.89103C15.4257 1.48082 15.9823 1.24976 16.5625 1.24976C17.1427 1.24976 17.6993 1.48001 18.1095 1.89022C18.5198 2.30044 18.7499 2.85711 18.75 3.43726Z"
                      fill="#777777" />
                  </svg>
                  <p class="px-[2px] text-sm font-bold text-[#777777]">編集</p>
                  <svg width="11" height="11" viewBox="0 0 11 10" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.78125 2.0625L7.21875 5.5L3.78125 8.9375" stroke="#777777" stroke-width="1.1"
                      stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </a>
                <button class="flex items-center pt-[11px]" type="button" onclick="event.stopPropagation();"
                  x-on:click="$dispatch('open-modal', 'delete-modal-{{ $group->id }}')">
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M12.2833 7.49995L11.995 14.9999M8.005 14.9999L7.71667 7.49995M16.0233 4.82495C16.3083 4.86828 16.5917 4.91411 16.875 4.96328M16.0233 4.82495L15.1333 16.3941C15.097 16.8651 14.8842 17.3051 14.5375 17.626C14.1908 17.9469 13.7358 18.1251 13.2633 18.1249H6.73667C6.26425 18.1251 5.80919 17.9469 5.46248 17.626C5.11578 17.3051 4.90299 16.8651 4.86667 16.3941L3.97667 4.82495M16.0233 4.82495C15.0616 4.67954 14.0948 4.56919 13.125 4.49411M3.97667 4.82495C3.69167 4.86745 3.40833 4.91328 3.125 4.96245M3.97667 4.82495C4.93844 4.67955 5.9052 4.56919 6.875 4.49411M13.125 4.49411V3.73078C13.125 2.74745 12.3667 1.92745 11.3833 1.89661C10.4613 1.86714 9.53865 1.86714 8.61667 1.89661C7.63333 1.92745 6.875 2.74828 6.875 3.73078V4.49411M13.125 4.49411C11.0448 4.33334 8.95523 4.33334 6.875 4.49411"
                      stroke="#F76E80" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  <p class="px-[2px] text-sm font-bold text-[#F76E80]">削除</p>
                  <svg width="11" height="11" viewBox="0 0 11 10" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.78125 2.0625L7.21875 5.5L3.78125 8.9375" stroke="#F76E80" stroke-width="1.1"
                      stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </button>

                <x-modal-alert name="delete-modal-{{ $group->id }}" title="削除" maxWidth="sm">
                  <form method="POST" action="{{ route('chatManager.destroy', ['group' => $group]) }}">
                    @csrf
                    @method('delete')
                    <div class="flex flex-col items-center bg-[#F7F7F7] px-5 pb-8 pt-4 text-left">
                      <p class="text-xs">以下のグループを削除いたします</p>
                      <div class="pt-[13px] text-[15px] font-bold">{{ $group->name }}</div>
                    </div>
                    <div class="my-5 flex items-center justify-center space-x-[10px]">
                      <div class="flex h-11 w-[150px] cursor-pointer items-center justify-center rounded border-2"
                        @click="$dispatch('close-modal', 'delete-modal-{{ $group->id }}')">キャンセル</div>
                      <button
                        class="flex h-11 w-[150px] cursor-pointer items-center justify-center rounded bg-[#FF4A62] text-white"
                        type="submit">削除する</button>
                    </div>
                  </form>
                </x-modal-alert>
              </div>
            </div>
          </div>
        @endforeach
        {{ $groups->links('vendor.pagination.tailwind') }}
    </x-dashboard.container>
  </x-dashboard.index>
</x-dashboard-layout>
