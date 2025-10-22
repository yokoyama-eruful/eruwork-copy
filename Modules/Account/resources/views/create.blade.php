<x-dashboard-layout :url="route('account.index')">
  <x-dashboard.index>
    <x-dashboard.top>
      <a class="hidden items-center text-sm font-bold text-[#3289FA] hover:opacity-40 lg:flex"
        href="{{ route('account.index') }}">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
            d="M5.78964 9.39738C5.6843 9.29192 5.62514 9.14895 5.62514 8.99988C5.62514 8.85082 5.6843 8.70785 5.78964 8.60238L11.4146 2.97738C11.5213 2.87802 11.6623 2.82393 11.808 2.8265C11.9538 2.82907 12.0928 2.88811 12.1959 2.99117C12.2989 3.09423 12.358 3.23327 12.3605 3.37899C12.3631 3.52472 12.309 3.66575 12.2096 3.77238L6.98214 8.99988L12.2096 14.2274C12.2649 14.2789 12.3092 14.341 12.34 14.41C12.3707 14.479 12.3873 14.5535 12.3886 14.629C12.3899 14.7045 12.376 14.7795 12.3477 14.8496C12.3194 14.9196 12.2773 14.9832 12.2239 15.0367C12.1705 15.0901 12.1069 15.1322 12.0368 15.1605C11.9668 15.1888 11.8918 15.2027 11.8162 15.2013C11.7407 15.2 11.6662 15.1835 11.5972 15.1527C11.5282 15.122 11.4661 15.0777 11.4146 15.0224L5.78964 9.39738Z"
            fill="#3289FA" />
        </svg>
        一覧画面に戻る
      </a>

      <h5 class="text-2xl font-bold lg:hidden">アカウント追加</h5>
    </x-dashboard.top>
    <x-dashboard.container>
      <form class="flex flex-col px-5 lg:p-6" action="{{ route('account.store') }}" method="POST">
        @csrf
        <h5 class="hidden text-xl font-bold lg:block">アカウント管理</h5>
        <div class="rounded-lg border-[#DDDDDD] sm:px-[25px] lg:mt-[30px] lg:border lg:py-[30px]">

          @if ($errors->any())
            <div class="mb-4 rounded border border-red-300 bg-red-50 p-3 text-xs text-red-600">
              <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div class="mt-10 flex flex-col gap-[30px] border-b pb-[50px] lg:gap-[50px]">
            <div class="grid grid-cols-[30%,70%] sm:grid-cols-[10%,40%,10%,40%]">
              <div class="flex items-center text-[11px] font-bold">名前</div>
              <div class="flex items-center lg:mr-10"><input
                  class="w-full rounded-lg border border-slate-300 px-3 py-2 font-normal" name="name" type="text"
                  value="{{ old('name') }}" required></div>
              <div class="mt-[30px] flex items-center text-[11px] font-bold lg:mt-0">フリガナ</div>
              <div class="mt-[30px] flex items-center lg:mr-10 lg:mt-0"><input
                  class="w-full rounded-lg border border-slate-300 px-3 py-2 font-normal" name="name_kana"
                  type="text" value="{{ old('name_kana') }}"></div>
            </div>

            <div class="grid grid-cols-[30%,70%] lg:grid-cols-[10%,90%]">
              <div class="flex items-center text-[11px] font-bold">ログインID</div>
              <div class="flex items-center lg:mr-10"><input
                  class="w-full rounded-lg border border-slate-300 px-3 py-2 font-normal" name="login_id" type="text"
                  value="{{ old('login_id') }}" required></div>
            </div>

            <div class="grid grid-cols-[30%,70%] lg:grid-cols-[10%,90%]">
              <div class="flex items-center text-[11px] font-bold">パスワード</div>
              <div class="flex items-center lg:mr-10"><input
                  class="w-full rounded-lg border border-slate-300 px-3 py-2 font-normal" name="password"
                  type="password" value="{{ old('password') }}" required></div>
            </div>

            <div class="grid grid-cols-[30%,70%] lg:grid-cols-[10%,90%]">
              <div class="flex items-center text-[11px] font-bold">パスワード確認</div>
              <div class="flex items-center lg:mr-10"><input
                  class="w-full rounded-lg border border-slate-300 px-3 py-2 font-normal" name="password_confirmation"
                  type="password" value="{{ old('password_confirmation') }}" required></div>
            </div>

            <!-- 4行目: 1列 -->
            <div class="grid grid-cols-[30%,70%] items-start lg:grid-cols-[10%,90%] lg:items-center">
              <div class="flex items-center text-[11px] font-bold">契約区分</div>
              <div class="flex items-center">
                <div class="flex flex-col lg:ms-4 lg:mt-1 lg:flex-row lg:items-center lg:space-x-[50px]">
                  <div class="flex items-center space-x-[50px]">
                    <label class="flex items-center">
                      <input class="form-radio text-indigo-600" name="contract_type" type="radio" value="正社員"
                        {{ old('contract_type') == '正社員' ? 'checked' : '' }}>
                      <span class="ml-1">正社員</span>
                    </label>
                    <label class="flex items-center">
                      <input class="form-radio text-indigo-600" name="contract_type" type="radio" value="契約社員"
                        {{ old('contract_type') == '契約社員' ? 'checked' : '' }}>
                      <span class="ml-1">契約社員</span>
                    </label>
                  </div>
                  <div class="mt-5 flex items-center space-x-[50px] lg:mt-0">
                    <label class="flex items-center">
                      <input class="form-radio text-indigo-600" name="contract_type" type="radio" value="パート"
                        {{ old('contract_type') == 'パート' ? 'checked' : '' }}>
                      <span class="ml-1">パート</span>
                    </label>
                    <label class="flex items-center">
                      <input class="form-radio text-indigo-600" name="contract_type" type="radio" value="アルバイト"
                        {{ old('contract_type') == 'アルバイト' ? 'checked' : '' }}>
                      <span class="ml-1">アルバイト</span>
                    </label>
                  </div>
                </div>
              </div>
            </div>

            <div class="grid grid-cols-[30%,70%] lg:grid-cols-[10%,90%]">
              <div class="flex items-center text-[11px] font-bold">管理者権限</div>
              <div class="flex items-center">
                <div class="flex items-center space-x-[50px] lg:ms-4 lg:mt-1">
                  <label class="flex items-center">
                    <input class="form-radio text-indigo-600" name="role" type="radio" value="1"
                      {{ old('role') == '1' ? 'checked' : '' }}>
                    <span class="ml-1">管理者</span>
                  </label>
                  <label class="flex items-center">
                    <input class="form-radio text-indigo-600" name="role" type="radio" value="2"
                      {{ old('role') == '2' ? 'checked' : '' }}>
                    <span class="ml-1">一般</span>
                  </label>
                </div>
                @error('role')
                  <div class="font-normal text-red-500">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="mt-10 flex flex-col gap-[50px] pb-[50px]">
            <div class="grid grid-cols-[30%,70%] lg:grid-cols-[10%,90%]">
              <div class="flex items-center text-[11px] font-bold">住所</div>
              <div class="flex items-center lg:mr-10"> <input
                  class="w-full rounded-lg border border-slate-300 px-3 py-2 font-normal" name="address"
                  type="text" value="{{ old('address') }}"></div>
            </div>

            <div class="grid grid-cols-[30%,70%] lg:grid-cols-[10%,90%]">
              <div class="flex items-center text-[11px] font-bold">電話番号</div>
              <div class="flex items-center lg:mr-10"><input
                  class="w-full rounded-lg border border-slate-300 px-3 py-2 font-normal" name="phone_number"
                  type="text" value="{{ old('phone_number') }}"></div>
            </div>

            <div class="grid grid-cols-[30%,70%] lg:grid-cols-[10%,90%]">
              <div class="flex items-center text-[11px] font-bold">緊急連絡先</div>
              <div class="flex items-center lg:mr-10"> <input
                  class="w-full rounded-lg border border-slate-300 px-3 py-2 font-normal"
                  name="emergency_phone_number" type="text" value="{{ old('emergency_phone_number') }}">
              </div>
            </div>
          </div>
        </div>

        <div class="mb-[60px] flex items-center justify-center space-x-[10px] lg:mb-0 lg:mt-10">
          <a class="flex h-[45px] w-[150px] items-center justify-center rounded border hover:opacity-40"
            href="{{ route('account.index') }}">キャンセル</a>
          <button
            class="flex h-[45px] w-[150px] items-center justify-center rounded bg-[#3289FA] font-bold text-white hover:opacity-40"
            type="submit">登録する</button>
        </div>

      </form>
    </x-dashboard.container>
  </x-dashboard.index>
</x-dashboard-layout>
