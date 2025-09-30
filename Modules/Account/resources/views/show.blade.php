<x-dashboard-layout :url="route('account.index')">
  <x-dashboard.index>
    <x-dashboard.top>
      <div class="flex w-full items-center justify-between sm:hidden">
        <div class="flex items-center space-x-1 text-xs">
          <div class="text-[#AAB0B6]">最終更新日：</div>
          <div>{{ $user->updated_at?->format('Y年m月d日') }}</div>
        </div>
        <div class="flex items-center space-x-1 text-xs">
          <div class="text-[#AAB0B6]">最終ログイン日：</div>
          <div>{{ $user->last_login_at?->format('Y年m月d日') }}</div>
        </div>
      </div>
      <a class="hidden items-center text-sm font-bold text-[#3289FA] hover:opacity-40 sm:flex"
        href="{{ route('account.index') }}">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
            d="M5.78964 9.39738C5.6843 9.29192 5.62514 9.14895 5.62514 8.99988C5.62514 8.85082 5.6843 8.70785 5.78964 8.60238L11.4146 2.97738C11.5213 2.87802 11.6623 2.82393 11.808 2.8265C11.9538 2.82907 12.0928 2.88811 12.1959 2.99117C12.2989 3.09423 12.358 3.23327 12.3605 3.37899C12.3631 3.52472 12.309 3.66575 12.2096 3.77238L6.98214 8.99988L12.2096 14.2274C12.2649 14.2789 12.3092 14.341 12.34 14.41C12.3707 14.479 12.3873 14.5535 12.3886 14.629C12.3899 14.7045 12.376 14.7795 12.3477 14.8496C12.3194 14.9196 12.2773 14.9832 12.2239 15.0367C12.1705 15.0901 12.1069 15.1322 12.0368 15.1605C11.9668 15.1888 11.8918 15.2027 11.8162 15.2013C11.7407 15.2 11.6662 15.1835 11.5972 15.1527C11.5282 15.122 11.4661 15.0777 11.4146 15.0224L5.78964 9.39738Z"
            fill="#3289FA" />
        </svg>
        一覧画面に戻る
      </a>
    </x-dashboard.top>
    <x-dashboard.container>
      <h5 class="hidden text-xl font-bold sm:block">アカウント管理</h5>
      <div class="rounded-lg border-[#DDDDDD] px-[25px] sm:mt-[30px] sm:border sm:py-[30px]">
        <div class="flex items-center justify-between border-b pb-5">
          <div class="flex items-center space-x-5">
            <div
              class="flex h-[35px] w-[35px] items-center justify-center overflow-hidden rounded-full bg-gray-200 text-3xl text-gray-800 sm:h-[45px] sm:w-[45px]">
              @if ($user->icon)
                <img class="h-full w-full object-cover" src="{{ route('profile.icon', ['id' => $user->id]) }}">
              @else
                <div class="flex h-full w-full items-center justify-center rounded-full border bg-white"><i
                    class="fa-solid fa-image"></i>
                </div>
              @endif
            </div>
            <div class="font-bold">{{ $user->name }}</div>
          </div>

          <div class="flex items-center space-x-10">
            <div class="hidden items-center space-x-1 sm:flex">
              <div class="text-xs text-[#AAB0B6]">最終ログイン日：</div>
              <div class="text-[15px]">{{ $user->last_login_at?->format('Y年m月d日') }}</div>
            </div>
            <div class="hidden items-center space-x-1 sm:flex">
              <div class="text-xs text-[#AAB0B6]">最終更新日：</div>
              <div class="text-[15px]">{{ $user->updated_at?->format('Y年m月d日') }}</div>
            </div>
            <div class="relative block cursor-pointer" x-data="{ openDialog{{ $user->id }}: false }">
              <div onclick="event.stopPropagation();"
                @click="openDialog{{ $user->id }} = !openDialog{{ $user->id }};">…</div>
              <div
                class="absolute -left-20 top-7 z-10 flex flex-col space-y-[10px] rounded-xl bg-white px-3 py-[10px] shadow-[0_4px_13px_0_#5D5F6240]"
                @click.away="openDialog{{ $user->id }} = false" x-show="openDialog{{ $user->id }}===true"
                x-cloak>
                <a class="flex items-center" href="{{ route('account.edit', ['account' => $user->login_id]) }}">
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M1.875 15.6248V6.87476C1.87505 6.21179 2.13863 5.57597 2.60742 5.10718C3.07625 4.6384 3.71201 4.37476 4.375 4.37476H8.33333C8.67844 4.37476 8.95822 4.65467 8.95833 4.99976C8.95833 5.34493 8.67851 5.62476 8.33333 5.62476H4.375C4.04353 5.62476 3.72562 5.75661 3.49121 5.99097C3.25684 6.22534 3.12505 6.54331 3.125 6.87476V15.6248C3.125 15.9562 3.25686 16.2741 3.49121 16.5085C3.72563 16.743 4.04348 16.8748 4.375 16.8748H13.125C13.4565 16.8748 13.7744 16.743 14.0088 16.5085C14.2431 16.2741 14.375 15.9562 14.375 15.6248V11.6664C14.3751 11.3213 14.6549 11.0414 15 11.0414C15.3451 11.0414 15.6249 11.3213 15.625 11.6664V15.6248C15.625 16.2877 15.3614 16.9235 14.8926 17.3923C14.4237 17.8612 13.788 18.1248 13.125 18.1248H4.375C3.71196 18.1248 3.07626 17.8612 2.60742 17.3923C2.13865 16.9235 1.875 16.2877 1.875 15.6248ZM17.5 3.43726C17.4999 3.18864 17.4016 2.94981 17.2257 2.77401C17.0499 2.59822 16.8111 2.49976 16.5625 2.49976C16.3139 2.49976 16.0751 2.59822 15.8993 2.77401L14.9349 3.73836L16.2614 5.06486L17.2257 4.1005C17.4015 3.92466 17.5 3.6859 17.5 3.43726ZM14.0511 4.62215L7.05078 11.6233C6.72977 11.9445 6.48236 12.3312 6.3265 12.7561L6.26546 12.9408L5.92855 14.0704L7.05892 13.7343L7.24365 13.6733C7.66852 13.5174 8.05526 13.2708 8.37646 12.9498L15.3776 5.94865L14.0511 4.62215ZM18.75 3.43726C18.75 4.01742 18.5197 4.57403 18.1095 4.98429L9.26025 13.8336C8.74635 14.3472 8.11251 14.7248 7.41618 14.9322L5.17822 15.5987C4.95832 15.6642 4.72035 15.6039 4.55811 15.4417C4.39591 15.2794 4.33554 15.0414 4.40104 14.8215L5.06755 12.5844C5.2749 11.8879 5.65249 11.2535 6.16618 10.7395L15.0155 1.89103C15.4257 1.48082 15.9823 1.24976 16.5625 1.24976C17.1427 1.24976 17.6993 1.48001 18.1095 1.89022C18.5198 2.30044 18.7499 2.85711 18.75 3.43726Z"
                      fill="#777777" />
                  </svg>
                  <p class="mt-[1px] pl-[4px] pr-[5px] text-sm font-bold text-[#777777]">編集</p>
                  <svg width="14" height="14" viewBox="0 0 11 11" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.78125 2.0625L7.21875 5.5L3.78125 8.9375" stroke="#777777" stroke-width="1.1"
                      stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </a>
                <button class="flex items-center" type="button" onclick="event.stopPropagation();"
                  x-on:click="$dispatch('open-modal', 'delete-modal-{{ $user->id }}')">
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M12.2833 7.49995L11.995 14.9999M8.005 14.9999L7.71667 7.49995M16.0233 4.82495C16.3083 4.86828 16.5917 4.91411 16.875 4.96328M16.0233 4.82495L15.1333 16.3941C15.097 16.8651 14.8842 17.3051 14.5375 17.626C14.1908 17.9469 13.7358 18.1251 13.2633 18.1249H6.73667C6.26425 18.1251 5.80919 17.9469 5.46248 17.626C5.11578 17.3051 4.90299 16.8651 4.86667 16.3941L3.97667 4.82495M16.0233 4.82495C15.0616 4.67954 14.0948 4.56919 13.125 4.49411M3.97667 4.82495C3.69167 4.86745 3.40833 4.91328 3.125 4.96245M3.97667 4.82495C4.93844 4.67955 5.9052 4.56919 6.875 4.49411M13.125 4.49411V3.73078C13.125 2.74745 12.3667 1.92745 11.3833 1.89661C10.4613 1.86714 9.53865 1.86714 8.61667 1.89661C7.63333 1.92745 6.875 2.74828 6.875 3.73078V4.49411M13.125 4.49411C11.0448 4.33334 8.95523 4.33334 6.875 4.49411"
                      stroke="#F76E80" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  <p class="mt-[1px] pl-[4px] pr-[5px] text-sm font-bold text-[#F76E80]">削除</p>
                  <svg width="14" height="14" viewBox="0 0 11 11" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.78125 2.0625L7.21875 5.5L3.78125 8.9375" stroke="#F76E80" stroke-width="1.1"
                      stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </button>

                <x-modal-alert name="delete-modal-{{ $user->id }}" title="削除" maxWidth="sm">
                  <form method="POST" action="{{ route('account.destroy', ['account' => $user->login_id]) }}">
                    @csrf
                    @method('delete')
                    <div class="flex flex-col items-center bg-[#F7F7F7] px-5 pb-8 pt-4 text-left">
                      <p class="text-xs">以下のユーザーを削除いたします</p>
                      <div class="pt-[13px] text-[15px] font-bold">{{ $user->name }}</div>
                    </div>
                    <div class="my-5 flex items-center justify-center space-x-[10px]">
                      <div class="flex h-11 w-[150px] cursor-pointer items-center justify-center rounded border-2"
                        @click="$dispatch('close-modal', 'delete-modal-{{ $user->id }}')">キャンセル</div>
                      <button
                        class="flex h-11 w-[150px] cursor-pointer items-center justify-center rounded bg-[#FF4A62] text-white"
                        type="submit">削除する</button>
                    </div>
                  </form>
                </x-modal-alert>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-10 hidden flex-col gap-[50px] border-b pb-[50px] sm:flex">
          <div class="grid grid-cols-[10%,40%,10%,40%]">
            <div class="flex items-center text-[11px] font-bold">名前</div>
            <div class="flex items-center">{{ $user->name }}</div>
            <div class="flex items-center text-[11px] font-bold">フリガナ</div>
            <div class="flex items-center">{{ $user->profile->name_kana ?? '-' }}</div>
          </div>

          <div class="grid grid-cols-[10%,90%]">
            <div class="flex items-center text-[11px] font-bold">ログインID</div>
            <div class="flex items-center">{{ $user->login_id }}</div>
          </div>

          <!-- 4行目: 1列 -->
          <div class="grid grid-cols-[10%,90%]">
            <div class="flex items-center text-[11px] font-bold">契約区分</div>
            <div class="flex items-center">{{ $user->profile->contract_type }}</div>
          </div>

          <div class="grid grid-cols-[10%,90%]">
            <div class="flex items-center text-[11px] font-bold">管理者権限</div>
            <div class="flex items-center">{{ $user->roles->first()->name == 'admin' ? '管理者' : '一般' }}</div>
          </div>
        </div>

        <div class="mt-10 hidden flex-col gap-[50px] pb-[50px] sm:flex">
          <div class="grid grid-cols-[10%,90%]">
            <div class="flex items-center text-[11px] font-bold">住所</div>
            <div class="flex items-center">{{ $user->profile->address ?? '-' }}</div>
          </div>

          <div class="grid grid-cols-[10%,90%]">
            <div class="flex items-center text-[11px] font-bold">電話番号</div>
            <div class="flex items-center">{{ $user->profile->phone_number ?? '-' }}</div>
          </div>

          <div class="grid grid-cols-[10%,90%]">
            <div class="flex items-center text-[11px] font-bold">緊急連絡先</div>
            <div class="flex items-center">{{ $user->profile->emergency_phone_number ?? '-' }}</div>
          </div>
        </div>

        {{-- モバイル --}}
        <div class="mt-10 flex flex-col gap-[50px] pb-[50px] sm:hidden">
          <div class="grid grid-cols-[30%,70%]">
            <div class="flex items-center text-[11px] font-bold">名前</div>
            <div class="flex items-center">{{ $user->name }}</div>
          </div>
          <div class="grid grid-cols-[30%,70%]">
            <div class="flex items-center text-[11px] font-bold">フリガナ</div>
            <div class="flex items-center">{{ $user->profile->name_kana ?? '-' }}</div>
          </div>
          <div class="grid grid-cols-[30%,70%]">
            <div class="flex items-center text-[11px] font-bold">ログインID</div>
            <div class="flex items-center">{{ $user->login_id }}</div>
          </div>
          <div class="grid grid-cols-[30%,70%]">
            <div class="flex items-center text-[11px] font-bold">契約区分</div>
            <div class="flex items-center">{{ $user->profile->contract_type }}</div>
          </div>
          <div class="grid grid-cols-[30%,70%] border-b pb-[40px]">
            <div class="flex items-center text-[11px] font-bold">管理者権限</div>
            <div class="flex items-center">{{ $user->roles->first()->name == 'admin' ? '管理者' : '一般' }}</div>
          </div>

          <div class="grid grid-cols-[30%,70%]">
            <div class="flex items-center text-[11px] font-bold">住所</div>
            <div class="flex items-center">{{ $user->profile->address ?? '-' }}</div>
          </div>
          <div class="grid grid-cols-[30%,70%]">
            <div class="flex items-center text-[11px] font-bold">電話番号</div>
            <div class="flex items-center">{{ $user->profile->phone_number ?? '-' }}</div>
          </div>
          <div class="grid grid-cols-[30%,70%]">
            <div class="flex items-center text-[11px] font-bold">緊急連絡先</div>
            <div class="flex items-center">{{ $user->profile->emergency_phone_number ?? '-' }}</div>
          </div>
        </div>

      </div>
    </x-dashboard.container>
  </x-dashboard.index>
</x-dashboard-layout>
