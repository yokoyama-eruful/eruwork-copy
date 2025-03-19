<x-app-layout>
  <form class="flex h-full flex-col rounded-lg border bg-white p-4 shadow" action="#" method="POST"
    enctype="multipart/form-data" x-data="{ iconPreview: null }">
    @csrf
    <div class="h-10">
      <h1 class="border-l-4 border-ao-main pl-2 text-2xl font-bold">ユーザー設定</h1>
    </div>

    <div class="my-3 flex w-full flex-1 flex-row space-x-5">
      <div class="flex w-[20%] flex-col px-5">

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
            <div class="text-9xl">👤</div>
          </div>
        @endif

        <label class="w-full cursor-pointer bg-ao-main px-4 py-2 text-white hover:bg-sky-700">
          <i class="fa-solid fa-plus"></i>アイコンを変更する
          <input class="hidden" name="icon" type="file"
            @change="iconPreview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
        </label>
      </div>

      <div class="flex h-full w-full flex-1 flex-col space-y-5 bg-ao-sub p-10">
        <div class="h-2/3">
          <h1 class="h-2/12 mb-2 text-2xl">パスワード変更</h1>

          <div class="h-8/12 flex flex-col space-y-2">
            <label class="flex h-1/3 flex-row items-center">
              <p class="w-[15%] min-w-40 px-2">現在のパスワード</p>
              <input class="mr-10 w-full border py-3" name="current_password" type="password">
            </label>
            <label class="flex h-1/3 flex-row items-center">
              <p class="w-[15%] min-w-40 px-2">新しいパスワード</p>
              <input class="mr-10 w-full border py-3" name="new_password" type="password">
            </label>
            <label class="flex h-1/3 flex-row items-center">
              <p class="w-[15%] min-w-40 px-2">新しいパスワード<br>(確認用)</p>
              <input class="mr-10 w-full border py-3" name="new_password_confirmation" type="password">
            </label>
          </div>
        </div>

        <div class="h-1/3">
          <h1 class="h-2/12 mb-2 text-2xl">通知設定変更</h1>

          <div class="h-8/12 mt-10">
            @vite('resources/js/notification.js')
            <div class="flex flex-row text-white">
              <button class="border bg-ao-main px-10 py-4 hover:bg-sky-700" id="enable-push" type="button">
                <i class="fa-solid fa-bell"></i>　通知オン
              </button>
              <button class="border bg-ao-main px-10 py-4 hover:bg-sky-700" id="disable-push" type="button"><i
                  class="fa-solid fa-bell-slash"></i>　通知オフ</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="flex h-20 flex-row items-center justify-center space-x-10 text-white">
      <button class="w-1/6 rounded-md bg-ao-main py-3 hover:bg-sky-700" type="submit">更新</button>
      <a class="w-1/6 rounded-md border border-ao-main bg-white py-3 text-center text-ao-main hover:bg-sky-700 hover:text-white"
        href="{{ route('home') }}">キャンセル</a>
    </div>
  </form>
</x-app-layout>
