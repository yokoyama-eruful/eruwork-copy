<x-app-layout>
  <x-main.index>
    <x-main.top>
    </x-main.top>
    <x-main.container>
      <h5 class="hidden text-xl font-bold sm:block">プロフィール設定</h5>
      <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" x-data="{ iconPreview: null }">
        @csrf

        <div class="my-3 flex w-full flex-col space-y-5 xl:flex-row xl:space-x-5 xl:space-y-0">
          <div class="flex flex-col px-5 xl:w-[20%]">
            <div class="aspect-square w-full bg-ao-sub" x-show="iconPreview">
              <div class="flex items-center justify-center">
                <img class="h-full w-full" alt="Icon Preview" :src="iconPreview" />
              </div>
            </div>

            @if (Auth::user()->icon)
              <div class="flex aspect-square w-full bg-ao-sub" x-show="!iconPreview">
                <div class="flex items-center justify-center">
                  <img class="h-full w-full" src="{{ Auth::user()->icon }}" alt="Default Icon" />
                </div>
              </div>
            @else
              <div class="flex aspect-square w-full items-center justify-center bg-ao-sub" x-show="!iconPreview">
                <div class="text-9xl"><i class="fa-solid fa-image scale-50"></i></div>
              </div>
            @endif

            <label class="w-full cursor-pointer bg-ao-main px-4 py-2 text-white hover:bg-sky-700">
              <i class="fa-solid fa-plus"></i>アイコンを変更する
              <input class="hidden" name="icon" type="file"
                @change="iconPreview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
            </label>
          </div>

          <div class="flex h-full w-full flex-1 flex-col space-y-5 bg-ao-sub p-2 xl:p-10">
            <div class="h-2/3">
              <h1 class="mb-2 text-lg font-semibold xl:text-xl">パスワード変更</h1>

              <div class="flex flex-col space-y-2">
                <label class="flex flex-col items-start xl:flex-row">
                  <span class="px-2 xl:w-[15%] xl:min-w-40">現在のパスワード</span>
                  <input class="mr-10 w-full border py-3" name="current_password" type="password">
                </label>
                <label class="flex flex-col items-start xl:flex-row">
                  <span class="px-2 xl:w-[15%] xl:min-w-40">新しいパスワード</span>
                  <input class="mr-10 w-full border py-3" name="new_password" type="password">
                </label>
                <label class="flex flex-col items-start xl:flex-row">
                  <span class="px-2 xl:w-[15%] xl:min-w-40">新しいパスワード<br>(確認用)</span>
                  <input class="mr-10 w-full border py-3" name="new_password_confirmation" type="password">
                </label>
              </div>
              @if ($errors->has('new_password'))
                <div class="text-red-500">
                  {{ $errors->first('new_password') }}
                </div>
              @endif
            </div>

            <div class="h-1/3">
              <h1 class="mb-2 text-lg font-semibold xl:text-xl">通知設定変更</h1>

              <div class="flex flex-col space-y-2 sm:flex-row sm:space-x-2 sm:space-y-0">


                
                <button class="w-full border bg-ao-main px-2 py-2 hover:bg-sky-700 sm:w-auto xl:px-10 xl:py-4"
                  id="enable-push" type="button">
                  <i class="fa-solid fa-bell"></i>　通知オン
                </button>
                <button class="w-full border bg-ao-main px-2 py-2 hover:bg-sky-700 sm:w-auto xl:px-10 xl:py-4"
                  id="disable-push" type="button"><i class="fa-solid fa-bell-slash"></i>　通知オフ</button>
              </div>
            </div>
          </div>
        </div>

        <div class="flex h-20 flex-row items-center justify-center space-x-2 text-white">
          <button class="w-full rounded-md bg-ao-main py-3 hover:bg-sky-700 xl:w-1/6" type="submit">更新</button>
          <a class="w-full rounded-md border border-ao-main bg-white py-3 text-center text-ao-main hover:bg-sky-700 hover:text-white xl:w-1/6"
            href="{{ route('home.index') }}">キャンセル</a>
        </div>
      </form>
    </x-main.container>
  </x-main.index>
</x-app-layout>
