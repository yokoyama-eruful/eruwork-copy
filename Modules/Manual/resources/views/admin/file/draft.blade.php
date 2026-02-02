<x-dashboard-layout :url="route('manualFolderManager.index')">
  <x-dashboard.index>
    <x-dashboard.top>
      <a class="hidden items-center space-x-[2px] text-[#3289FA] hover:opacity-40 lg:flex"
        href="{{ route('manualFolderManager.index') }}">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
            d="M5.78964 9.39738C5.6843 9.29192 5.62514 9.14895 5.62514 8.99988C5.62514 8.85082 5.6843 8.70785 5.78964 8.60238L11.4146 2.97738C11.5213 2.87802 11.6623 2.82393 11.808 2.8265C11.9538 2.82907 12.0928 2.88811 12.1959 2.99117C12.2989 3.09423 12.358 3.23327 12.3605 3.37899C12.3631 3.52472 12.309 3.66575 12.2096 3.77238L6.98214 8.99988L12.2096 14.2274C12.2649 14.2789 12.3092 14.341 12.34 14.41C12.3707 14.479 12.3873 14.5535 12.3886 14.629C12.3899 14.7045 12.376 14.7795 12.3477 14.8496C12.3194 14.9196 12.2773 14.9832 12.2239 15.0367C12.1705 15.0901 12.1069 15.1322 12.0368 15.1605C11.9668 15.1888 11.8918 15.2027 11.8162 15.2013C11.7407 15.2 11.6662 15.1835 11.5972 15.1527C11.5282 15.122 11.4661 15.0777 11.4146 15.0224L5.78964 9.39738Z"
            fill="#3289FA" />
        </svg>
        <p class="text-sm font-bold">一覧画面に戻る</p>
      </a>
      <div class="mx-[30px] hidden h-[35px] border-r lg:block"></div>
      <h5 class="text-xl font-bold lg:hidden">マニュアル下書き</h5>
    </x-dashboard.top>
    <x-dashboard.container>
      <h5 class="hidden text-xl font-bold lg:block">マニュアル下書き</h5>
      {{-- <div class="mx-5 lg:hidden">
        <a class='flex h-[35px] w-fit items-center rounded-[5px] bg-[#3289fa] px-5 py-2 text-sm font-bold text-[#fff] hover:bg-[#3289fa4d]'
          href="{{ route('manualFileManager.create', ['folder_id' => $folder->id]) }}">
          <img class="mr-[5px] h-[15px] w-[15px]" src="{{ asset('img/icon/add-schedule.png') }}" />
          新規作成
        </a>
      </div> --}}
      @if ($files->isNotEmpty())
        <div class="mt-[30px] hidden grid-cols-[10%,5%,41%,21%,21%,2%] px-5 lg:grid">
          <div class="text-xs text-[#AAB0B6]">サムネイル</div>
          <div class="text-xs text-[#AAB0B6]"></div>
          <div class="text-xs text-[#AAB0B6]">表題</div>
          <div class="text-xs text-[#AAB0B6]">メンバー</div>
          <div class="text-xs text-[#AAB0B6]">更新日</div>
          <div class="text-xs text-[#AAB0B6]"></div>
        </div>
        <div class="mt-[30px] border-b lg:mt-[10px] lg:rounded-xl lg:border">
          @foreach ($files as $file)
            <div @class([
                'hidden lg:grid grid-cols-[10%,5%,41%,21%,21%,2%] py-[10px] text-[15px] items-center min-h-[100px] px-5 relative',
                'border-b' => !$loop->last,
            ])>
              @if ($file->status == '下書き')
                <div class="absolute left-0 top-0 h-11 w-11 overflow-hidden">
                  <div
                    class="flex h-full w-full items-start justify-center bg-[#00A1FF] pr-3 pt-2 text-[9px] font-bold text-white"
                    style="clip-path: polygon(0% 0%, 0% 100%, 100% 0%); border-top-left-radius: 4px;">
                    <span style="display:inline-block; transform: rotate(-45deg);">
                      下書き
                    </span>
                  </div>
                </div>
              @endif

              <img class="max-h-[80px] max-w-[145px] rounded"
                src="{{ route('manualFileManager.thumbnail', ['id' => $file->id]) }}" />

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

              <div>{{ $file->updated_at->format('Y/m/d') ?? '' }}</div>

              <div class="flex items-center justify-end">
                <div class="relative" x-data="{ openDialog{{ $file->manual__folder_id }}: false }">
                  <button class="flex items-center" type="button"
                    @click="openDialog{{ $file->manual__folder_id }} = !openDialog{{ $file->manual__folder_id }};">
                    <img class="h-6 w-6 hover:opacity-40" src="{{ asset('img/icon/dot_gray.png') }}" />
                  </button>
                  <div
                    class="absolute -left-20 top-7 z-10 flex flex-col space-y-[10px] rounded-xl bg-white px-3 py-[10px] shadow-[0_4px_13px_0_#5D5F6240]"
                    @click.away="openDialog{{ $file->manual__folder_id }} = false"
                    x-show="openDialog{{ $file->manual__folder_id }}===true" x-cloak>
                    <a class="flex items-center" type="button"
                      href="{{ route('manualFileManager.edit', ['folder_id' => $file->manual__folder_id, 'file_id' => $file->id]) }}">
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
                    </a>
                    <livewire:manual::admin.file.delete-modal :file="$file" :folderId="$file->manual__folder_id" />
                  </div>
                </div>
              </div>
            </div>

            <div @class([
                'grid grid-cols-[29%,61%,10%] items-center px-[20px] pb-[15px] lg:hidden',
                'border-b' => !$loop->last,
            ])>
              <img class="max-h-[45px] max-w-[100px] rounded"
                src="{{ route('manualFileManager.thumbnail', ['id' => $file->id]) }}" />

              <div>
                <div class="flex items-center space-x-1">
                  @if (str_contains($file->type, 'video'))
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                      xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M11.8125 7.875L15.3525 4.335C15.4312 4.25643 15.5313 4.20294 15.6404 4.18128C15.7494 4.15961 15.8625 4.17075 15.9652 4.21328C16.0679 4.25582 16.1557 4.32784 16.2175 4.42025C16.2794 4.51266 16.3124 4.62132 16.3125 4.7325V13.2675C16.3124 13.3787 16.2794 13.4873 16.2175 13.5797C16.1557 13.6722 16.0679 13.7442 15.9652 13.7867C15.8625 13.8292 15.7494 13.8404 15.6404 13.8187C15.5313 13.7971 15.4312 13.7436 15.3525 13.665L11.8125 10.125M3.375 14.0625H10.125C10.5726 14.0625 11.0018 13.8847 11.3182 13.5682C11.6347 13.2518 11.8125 12.8226 11.8125 12.375V5.625C11.8125 5.17745 11.6347 4.74823 11.3182 4.43176C11.0018 4.11529 10.5726 3.9375 10.125 3.9375H3.375C2.92745 3.9375 2.49822 4.11529 2.18176 4.43176C1.86529 4.74823 1.6875 5.17745 1.6875 5.625V12.375C1.6875 12.8226 1.86529 13.2518 2.18176 13.5682C2.49822 13.8847 2.92745 14.0625 3.375 14.0625Z"
                        stroke="#3289FA" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                  @endif
                  <div class="break-words text-[15px] font-bold">{{ $file->title }}</div>
                </div>
                <div class="text-xs">更新日：{{ $file->updated_at->format('Y/m/d') ?? '' }}</div>
              </div>
              <div class="flex items-center justify-end">
                <div class="relative" x-data="{ openDialog{{ $file->manual__folder_id }}: false }">
                  <button class="flex items-center" type="button"
                    @click="openDialog{{ $file->manual__folder_id }} = !openDialog{{ $file->manual__folder_id }};">
                    <img class="h-6 w-6 hover:opacity-40" src="{{ asset('img/icon/dot_gray.png') }}" />
                  </button>
                  <div
                    class="absolute -left-20 top-7 z-10 flex flex-col space-y-[10px] rounded-xl bg-white px-3 py-[10px] shadow-[0_4px_13px_0_#5D5F6240]"
                    @click.away="openDialog{{ $file->manual__folder_id }} = false"
                    x-show="openDialog{{ $file->manual__folder_id }}===true" x-cloak>
                    <a class="flex items-center" type="button"
                      href="{{ route('manualFileManager.edit', ['folder_id' => $file->manual__folder_id, 'file_id' => $file->id]) }}">
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
                    </a>
                    <livewire:manual::admin.file.delete-modal :file="$file" :folderId="$file->manual__folder_id" />
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <div
          class="mt-[30px] flex h-[calc(var(--vh)*100-190px)] flex-col items-center justify-center rounded-xl border">
          <svg width="100" height="100" viewBox="0 0 100 100" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <g opacity="0.1">
              <path
                d="M46.875 18.8875C40.3463 14.7057 32.7532 12.4886 25 12.5C20.3875 12.4953 15.8079 13.2774 11.4583 14.8125C10.8491 15.0279 10.3217 15.4269 9.94858 15.9544C9.57548 16.482 9.37509 17.1122 9.375 17.7584V77.1334C9.37507 77.6333 9.49507 78.1259 9.72492 78.5698C9.95478 79.0137 10.2878 79.396 10.696 79.6846C11.1042 79.9732 11.5756 80.1597 12.0708 80.2283C12.5659 80.297 13.0704 80.2458 13.5417 80.0792C17.2222 78.7811 21.0972 78.1202 25 78.125C33.3125 78.125 40.9292 81.0709 46.875 85.9834V18.8875ZM53.125 85.9834C59.2767 80.8923 67.0149 78.1124 75 78.125C79.025 78.125 82.875 78.8167 86.4583 80.0834C86.93 80.2501 87.4348 80.3012 87.9302 80.2323C88.4257 80.1635 88.8975 79.9766 89.3057 79.6876C89.714 79.3985 90.0469 79.0157 90.2765 78.5712C90.5061 78.1267 90.6256 77.6336 90.625 77.1334V17.7584C90.6249 17.1122 90.4245 16.482 90.0514 15.9544C89.6783 15.4269 89.1509 15.0279 88.5417 14.8125C84.1921 13.2774 79.6125 12.4953 75 12.5C67.2468 12.4886 59.6537 14.7057 53.125 18.8875V85.9834Z"
                fill="#070707" />
            </g>
          </svg>
          <div class="mt-5 text-[20px] font-bold text-[#222222] text-opacity-10">下書きがありません</div>
        </div>
      @endif
    </x-dashboard.container>
  </x-dashboard.index>
</x-dashboard-layout>
