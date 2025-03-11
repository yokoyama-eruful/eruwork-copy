<form action="{{ route('auth.logout') }}" method="POST">
  @csrf
  <button class="group relative h-auto w-full overflow-hidden rounded-2xl bg-slate-100 p-4 text-left">
    <span
      class="absolute inset-y-0 left-0 w-0 rounded-r-2xl bg-sky-200 transition-all duration-700 ease-in-out group-hover:w-full"></span>
    <i class="fa-solid fa-right-from-bracket relative z-10"></i><span class="relative z-10">ログアウト</span>
  </button>
</form>
