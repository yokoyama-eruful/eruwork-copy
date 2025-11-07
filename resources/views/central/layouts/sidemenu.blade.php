<div class="h-full w-1/6">
  <div class="flex h-full w-full flex-col justify-between bg-slate-500">
    <div class="flex flex-col space-y-4">
      <div class="flex h-16 w-full items-center justify-center bg-slate-600 text-2xl font-bold text-white">
        <h1>Console</h1>
      </div>
      <a class="m-2 flex flex-row items-center justify-center space-x-3 p-3 text-white hover:bg-slate-600"
        href="{{ route('central.home') }}">
        <i class="fa-solid fa-house"></i>
        <p>ホーム</p>
      </a>
      <a class="m-2 flex flex-row items-center justify-center space-x-3 p-3 text-white hover:bg-slate-600"
        href="{{ route('central.create') }}">
        <i class="fa-regular fa-square-plus"></i>
        <p>作　成</p>
      </a>
      <a class="m-2 flex flex-row items-center justify-center space-x-3 p-3 text-white hover:bg-slate-600"
        href="{{ route('central.trash.index') }}">
        <i class="fa-regular fa-trash-can"></i>
        <p>ゴミ箱</p>
      </a>
    </div>

    <form class="m-2" action="{{ route('central.logout') }}" method="POST">
      @csrf
      <button class="flex w-full flex-row items-center justify-center space-x-3 p-3 text-white hover:bg-slate-600">
        <i class="fa-solid fa-arrow-right-from-bracket"></i>
        <p>ログアウト</p>
      </button>
    </form>
  </div>
</div>
