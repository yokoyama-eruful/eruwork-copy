<x-dashboard-layout>
  <x-dashboard.index>
    <x-dashboard.top>
      <div class="hidden lg:block">
        <livewire:manual::admin.folder.create-modal />
      </div>
      <div class="flex w-full items-center justify-between lg:hidden">
        <h5 class="text-xl font-bold lg:hidden">マニュアル管理</h5>
        <div class="lg:hidden">
          <livewire:manual::admin.folder.create-modal />
        </div>
      </div>
    </x-dashboard.top>
    <x-dashboard.container>
      <div class="flex items-center justify-between">
        <h5 class="hidden text-xl font-bold lg:block">マニュアル管理</h5>
        <a class="flex items-center px-5 text-sm text-[#3289FA] hover:opacity-40 lg:px-0"
          href="{{ route('manualFileManager.draft') }}">
          <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M1.875 15.6248V6.87476C1.87505 6.21179 2.13863 5.57597 2.60742 5.10718C3.07625 4.6384 3.71201 4.37476 4.375 4.37476H8.33333C8.67844 4.37476 8.95822 4.65467 8.95833 4.99976C8.95833 5.34493 8.67851 5.62476 8.33333 5.62476H4.375C4.04353 5.62476 3.72562 5.75661 3.49121 5.99097C3.25684 6.22534 3.12505 6.54331 3.125 6.87476V15.6248C3.125 15.9562 3.25686 16.2741 3.49121 16.5085C3.72563 16.743 4.04348 16.8748 4.375 16.8748H13.125C13.4565 16.8748 13.7744 16.743 14.0088 16.5085C14.2431 16.2741 14.375 15.9562 14.375 15.6248V11.6664C14.3751 11.3213 14.6549 11.0414 15 11.0414C15.3451 11.0414 15.6249 11.3213 15.625 11.6664V15.6248C15.625 16.2877 15.3614 16.9235 14.8926 17.3923C14.4237 17.8612 13.788 18.1248 13.125 18.1248H4.375C3.71196 18.1248 3.07626 17.8612 2.60742 17.3923C2.13865 16.9235 1.875 16.2877 1.875 15.6248ZM17.5 3.43726C17.4999 3.18864 17.4016 2.94981 17.2257 2.77401C17.0499 2.59822 16.8111 2.49976 16.5625 2.49976C16.3139 2.49976 16.0751 2.59822 15.8993 2.77401L14.9349 3.73836L16.2614 5.06486L17.2257 4.1005C17.4015 3.92466 17.5 3.6859 17.5 3.43726ZM14.0511 4.62215L7.05078 11.6233C6.72977 11.9445 6.48236 12.3312 6.3265 12.7561L6.26546 12.9408L5.92855 14.0704L7.05892 13.7343L7.24365 13.6733C7.66852 13.5174 8.05526 13.2708 8.37646 12.9498L15.3776 5.94865L14.0511 4.62215ZM18.75 3.43726C18.75 4.01742 18.5197 4.57403 18.1095 4.98429L9.26025 13.8336C8.74635 14.3472 8.11251 14.7248 7.41618 14.9322L5.17822 15.5987C4.95832 15.6642 4.72035 15.6039 4.55811 15.4417C4.39591 15.2794 4.33554 15.0414 4.40104 14.8215L5.06755 12.5844C5.2749 11.8879 5.65249 11.2535 6.16618 10.7395L15.0155 1.89103C15.4257 1.48082 15.9823 1.24976 16.5625 1.24976C17.1427 1.24976 17.6993 1.48001 18.1095 1.89022C18.5198 2.30044 18.7499 2.85711 18.75 3.43726Z"
              fill="#3289FA" />
          </svg>
          <p class="ml-[4px]">下書き一覧</p>
        </a>
      </div>

      @if ($folders->isNotEmpty())
        <div class="mt-[30px] hidden grid-cols-[60%,15%,15%,5%,5%] lg:grid">
          <div class="pl-[30px] text-xs text-[#AAB0B6]">表題</div>
          <div class="text-xs text-[#AAB0B6]">メンバー</div>
          <div class="text-xs text-[#AAB0B6]">更新日</div>
          <div></div>
          <div></div>
        </div>
        <div class="mt-[10px] border-b lg:rounded-xl lg:border">
          @foreach ($folders as $folder)
            <a href="{{ route('manualFileManager.index', ['folder_id' => $folder->id]) }}" @class([
                'grid lg:grid-cols-[60%,15%,15%,5%,5%] grid-cols-[77%,13%,10%] lg:py-[30px] py-5 text-[15px] flex items-center cursor-pointer',
                'border-b' => !$loop->last,
            ])>
              <div class="pl-[30px] font-bold">{{ $folder->title }}</div>
              <div class="hidden lg:block">{{ $folder->user->name }}</div>
              <div class="hidden lg:block">{{ $folder->updated_at?->format('Y/m/d') }}</div>
              <div class="relative" x-data="{ openDialog{{ $folder->id }}: false }">
                <button class="flex items-center" type="button"
                  @click.prevent.stop="openDialog{{ $folder->id }} = !openDialog{{ $folder->id }};">
                  <img class="h-6 w-6 hover:opacity-40" src="{{ asset('img/icon/dot_gray.png') }}" />
                </button>
                <div
                  class="absolute -left-20 top-7 z-10 flex flex-col space-y-[10px] rounded-xl bg-white px-3 py-[10px] shadow-[0_4px_13px_0_#5D5F6240]"
                  @click.away.prevent.stop="openDialog{{ $folder->id }}=false"
                  x-show="openDialog{{ $folder->id }}===true" x-cloak>
                  <button class="flex items-center" type="button"
                    @click.prevent.stop="$dispatch('open-modal','manual-folder-edit-modal-{{ $folder->id }}')">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                      xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M1.875 15.6248V6.87476C1.87505 6.21179 2.13863 5.57597 2.60742 5.10718C3.07625 4.6384 3.71201 4.37476 4.375 4.37476H8.33333C8.67844 4.37476 8.95822 4.65467 8.95833 4.99976C8.95833 5.34493 8.67851 5.62476 8.33333 5.62476H4.375C4.04353 5.62476 3.72562 5.75661 3.49121 5.99097C3.25684 6.22534 3.12505 6.54331 3.125 6.87476V15.6248C3.125 15.9562 3.25686 16.2741 3.49121 16.5085C3.72563 16.743 4.04348 16.8748 4.375 16.8748H13.125C13.4565 16.8748 13.7744 16.743 14.0088 16.5085C14.2431 16.2741 14.375 15.9562 14.375 15.6248V11.6664C14.3751 11.3213 14.6549 11.0414 15 11.0414C15.3451 11.0414 15.6249 11.3213 15.625 11.6664V15.6248C15.625 16.2877 15.3614 16.9235 14.8926 17.3923C14.4237 17.8612 13.788 18.1248 13.125 18.1248H4.375C3.71196 18.1248 3.07626 17.8612 2.60742 17.3923C2.13865 16.9235 1.875 16.2877 1.875 15.6248ZM17.5 3.43726C17.4999 3.18864 17.4016 2.94981 17.2257 2.77401C17.0499 2.59822 16.8111 2.49976 16.5625 2.49976C16.3139 2.49976 16.0751 2.59822 15.8993 2.77401L14.9349 3.73836L16.2614 5.06486L17.2257 4.1005C17.4015 3.92466 17.5 3.6859 17.5 3.43726ZM14.0511 4.62215L7.05078 11.6233C6.72977 11.9445 6.48236 12.3312 6.3265 12.7561L6.26546 12.9408L5.92855 14.0704L7.05892 13.7343L7.24365 13.6733C7.66852 13.5174 8.05526 13.2708 8.37646 12.9498L15.3776 5.94865L14.0511 4.62215ZM18.75 3.43726C18.75 4.01742 18.5197 4.57403 18.1095 4.98429L9.26025 13.8336C8.74635 14.3472 8.11251 14.7248 7.41618 14.9322L5.17822 15.5987C4.95832 15.6642 4.72035 15.6039 4.55811 15.4417C4.39591 15.2794 4.33554 15.0414 4.40104 14.8215L5.06755 12.5844C5.2749 11.8879 5.65249 11.2535 6.16618 10.7395L15.0155 1.89103C15.4257 1.48082 15.9823 1.24976 16.5625 1.24976C17.1427 1.24976 17.6993 1.48001 18.1095 1.89022C18.5198 2.30044 18.7499 2.85711 18.75 3.43726Z"
                        fill="#777777" />
                    </svg>
                    <p class="mt-[1px] pl-[4px] pr-[5px] text-sm font-bold text-[#777777]">編集</p>
                    <svg width="11" height="11" viewBox="0 0 11 11" fill="none"
                      xmlns="http://www.w3.org/2000/svg">
                      <path d="M3.78125 2.0625L7.21875 5.5L3.78125 8.9375" stroke="#777777" stroke-width="1.1"
                        stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                  </button>
                  <button class="flex items-center" type="button" onclick="event.stopPropagation();"
                    x-on:click.prevent.stop="$dispatch('open-modal', 'manual-folder-delete-modal-{{ $folder->id }}')">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                      xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M12.2833 7.49995L11.995 14.9999M8.005 14.9999L7.71667 7.49995M16.0233 4.82495C16.3083 4.86828 16.5917 4.91411 16.875 4.96328M16.0233 4.82495L15.1333 16.3941C15.097 16.8651 14.8842 17.3051 14.5375 17.626C14.1908 17.9469 13.7358 18.1251 13.2633 18.1249H6.73667C6.26425 18.1251 5.80919 17.9469 5.46248 17.626C5.11578 17.3051 4.90299 16.8651 4.86667 16.3941L3.97667 4.82495M16.0233 4.82495C15.0616 4.67954 14.0948 4.56919 13.125 4.49411M3.97667 4.82495C3.69167 4.86745 3.40833 4.91328 3.125 4.96245M3.97667 4.82495C4.93844 4.67955 5.9052 4.56919 6.875 4.49411M13.125 4.49411V3.73078C13.125 2.74745 12.3667 1.92745 11.3833 1.89661C10.4613 1.86714 9.53865 1.86714 8.61667 1.89661C7.63333 1.92745 6.875 2.74828 6.875 3.73078V4.49411M13.125 4.49411C11.0448 4.33334 8.95523 4.33334 6.875 4.49411"
                        stroke="#F76E80" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p class="mt-[1px] pl-[4px] pr-[5px] text-sm font-bold text-[#F76E80]">削除</p>
                    <svg width="11" height="11" viewBox="0 0 11 11" fill="none"
                      xmlns="http://www.w3.org/2000/svg">
                      <path d="M3.78125 2.0625L7.21875 5.5L3.78125 8.9375" stroke="#F76E80" stroke-width="1.1"
                        stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                  </button>
                </div>
              </div>
              <div>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <path d="M8.25 4.5L15.75 12L8.25 19.5" stroke="#AAB0B6" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
              </div>
            </a>

            <livewire:manual::admin.folder.edit-modal :folder="$folder" wire:key="edit-desktop-{{ $folder->id }}" />
            <livewire:manual::admin.folder.delete-modal :folder="$folder"
              wire:key="delete-desktop-{{ $folder->id }}" />
          @endforeach
        </div>
      @else
        <div
          class="mt-[30px] flex h-[calc(var(--vh)*100-190px)] flex-col items-center justify-center rounded-xl border">
          <svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g opacity="0.1">
              <path
                d="M46.875 18.8875C40.3463 14.7057 32.7532 12.4886 25 12.5C20.3875 12.4953 15.8079 13.2774 11.4583 14.8125C10.8491 15.0279 10.3217 15.4269 9.94858 15.9544C9.57548 16.482 9.37509 17.1122 9.375 17.7584V77.1334C9.37507 77.6333 9.49507 78.1259 9.72492 78.5698C9.95478 79.0137 10.2878 79.396 10.696 79.6846C11.1042 79.9732 11.5756 80.1597 12.0708 80.2283C12.5659 80.297 13.0704 80.2458 13.5417 80.0792C17.2222 78.7811 21.0972 78.1202 25 78.125C33.3125 78.125 40.9292 81.0709 46.875 85.9834V18.8875ZM53.125 85.9834C59.2767 80.8923 67.0149 78.1124 75 78.125C79.025 78.125 82.875 78.8167 86.4583 80.0834C86.93 80.2501 87.4348 80.3012 87.9302 80.2323C88.4257 80.1635 88.8975 79.9766 89.3057 79.6876C89.714 79.3985 90.0469 79.0157 90.2765 78.5712C90.5061 78.1267 90.6256 77.6336 90.625 77.1334V17.7584C90.6249 17.1122 90.4245 16.482 90.0514 15.9544C89.6783 15.4269 89.1509 15.0279 88.5417 14.8125C84.1921 13.2774 79.6125 12.4953 75 12.5C67.2468 12.4886 59.6537 14.7057 53.125 18.8875V85.9834Z"
                fill="#070707" />
            </g>
          </svg>
          <div class="mt-5 text-[20px] font-bold text-[#222222] text-opacity-10">マニュアルがありません</div>
        </div>
      @endif
      {{ $folders->links('vendor.pagination.tailwind') }}
    </x-dashboard.container>
  </x-dashboard.index>
</x-dashboard-layout>
