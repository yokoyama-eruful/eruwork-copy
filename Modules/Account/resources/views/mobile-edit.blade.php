<x-dashboard-layout :url="route('account.index')">
  <x-dashboard.index>
    <x-dashboard.top>
      <div class="flex w-full items-center justify-between sm:hidden">
        <div class="flex items-center space-x-1 text-xs">
          <div class="text-[#AAB0B6]">最終更新日：</div>
          <div>{{ $user->updated_at?->format('Y.m.d') }}</div>
        </div>
        <div class="flex items-center space-x-1 text-xs">
          <div class="text-[#AAB0B6]">最終ログイン日：</div>
          <div>{{ $user->last_login_at?->format('Y.m.d') }}</div>
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
      <form class="flex flex-col p-6" action="{{ route('account.update', ['account' => $user->login_id]) }}"
        method="POST">
        @csrf
        @method('PUT')
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
              <div class="relative block cursor-pointer" x-data="">
                <div>
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
                </div>
              </div>
            </div>
          </div>

          @if ($errors->any())
            <div class="mb-4 rounded border border-red-300 bg-red-50 p-3 text-xs text-red-600">
              <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <input name="id" type="hidden" value="{{ $user->id }}">

          {{-- モバイル --}}
          <div class="mt-10 flex flex-col gap-[50px] pb-[50px] sm:hidden">
            <div class="grid grid-cols-[30%,70%]">
              <div class="flex items-center text-[11px] font-bold">名前</div>
              <div class="flex items-center"><input
                  class="w-full rounded-lg border border-slate-300 px-3 py-2 font-normal" name="name" type="text"
                  value="{{ old('name', $user->profile?->name) }}" required></div>
            </div>
            <div class="grid grid-cols-[30%,70%]">
              <div class="flex items-center text-[11px] font-bold">フリガナ</div>
              <div class="flex items-center"><input
                  class="w-full rounded-lg border border-slate-300 px-3 py-2 font-normal" name="name_kana"
                  type="text" value="{{ old('name_kana', $user->profile?->name_kana) }}"></div>
            </div>
            <div class="grid grid-cols-[30%,70%]">
              <div class="flex items-center text-[11px] font-bold">ログインID</div>
              <div class="flex items-center"><input
                  class="w-full rounded-lg border border-slate-300 px-3 py-2 font-normal" name="login_id" type="text"
                  value="{{ old('login_id', $user->login_id) }}" required></div>
            </div>
            <div class="grid grid-cols-[30%,70%]">
              <div class="flex items-center text-[11px] font-bold">契約区分</div>
              <div class="flex items-center">
                <div class="ms-4 mt-1 grid grid-cols-2">
                  <label class="flex items-center">
                    <input class="form-radio text-indigo-600" name="contract_type" type="radio" value="正社員"
                      {{ old('contract_type', $user->profile?->contract_type) == '正社員' ? 'checked' : '' }}>
                    <span class="ml-1">正社員</span>
                  </label>
                  <label class="flex items-center">
                    <input class="form-radio text-indigo-600" name="contract_type" type="radio" value="契約社員"
                      {{ old('contract_type', $user->profile?->contract_type) == '契約社員' ? 'checked' : '' }}>
                    <span class="ml-1">契約社員</span>
                  </label>
                  <label class="flex items-center">
                    <input class="form-radio text-indigo-600" name="contract_type" type="radio" value="パート"
                      {{ old('contract_type', $user->profile?->contract_type) == 'パート' ? 'checked' : '' }}>
                    <span class="ml-1">パート</span>
                  </label>
                  <label class="flex items-center">
                    <input class="form-radio text-indigo-600" name="contract_type" type="radio" value="アルバイト"
                      {{ old('contract_type', $user->profile?->contract_type) == 'アルバイト' ? 'checked' : '' }}>
                    <span class="ml-1">アルバイト</span>
                  </label>
                </div>
              </div>
            </div>
            <div class="grid grid-cols-[30%,70%] border-b pb-[40px]">
              <div class="flex items-center text-[11px] font-bold">管理者権限</div>
              <div class="flex items-center">
                <div class="ms-4 mt-1 flex items-center space-x-[50px]">
                  <label class="flex items-center">
                    <input class="form-radio text-indigo-600" name="role" type="radio" value="1"
                      {{ old('role', optional($user?->roles->first())->id) == '1' ? 'checked' : '' }}>
                    <span class="ml-1">管理者</span>
                  </label>
                  <label class="flex items-center">
                    <input class="form-radio text-indigo-600" name="role" type="radio" value="2"
                      {{ old('role', optional($user?->roles->first())->id) == '2' ? 'checked' : '' }}>
                    <span class="ml-1">一般</span>
                  </label>
                </div>
              </div>
            </div>

            <div class="grid grid-cols-[30%,70%]">
              <div class="flex items-center text-[11px] font-bold">住所</div>
              <div class="flex items-center"> <input
                  class="w-full rounded-lg border border-slate-300 px-3 py-2 font-normal" name="address"
                  type="text" value="{{ old('address', $user->profile?->address) }}"></div>
            </div>
            <div class="grid grid-cols-[30%,70%]">
              <div class="flex items-center text-[11px] font-bold">電話番号</div>
              <div class="flex items-center"><input
                  class="w-full rounded-lg border border-slate-300 px-3 py-2 font-normal" name="phone_number"
                  type="text" value="{{ old('phone_number', $user->profile?->phone_number) }}"></div>
            </div>
            <div class="grid grid-cols-[30%,70%]">
              <div class="flex items-center text-[11px] font-bold">緊急連絡先</div>
              <div class="flex items-center"><input
                  class="w-full rounded-lg border border-slate-300 px-3 py-2 font-normal"
                  name="emergency_phone_number" type="text"
                  value="{{ old('emergency_phone_number', $user->profile?->emergency_phone_number) }}"></div>
            </div>
          </div>

          <div class="mb-10 flex items-center justify-center space-x-[10px]">
            <a class="flex h-[45px] w-[150px] items-center justify-center rounded border hover:opacity-40"
              href="{{ route('account.index') }}">キャンセル</a>
            <button
              class="flex h-[45px] w-[150px] items-center justify-center rounded bg-[#3289FA] font-bold text-white hover:opacity-40"
              type="submit">更新する</button>
          </div>
      </form>

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
    </x-dashboard.container>
  </x-dashboard.index>
</x-dashboard-layout>
