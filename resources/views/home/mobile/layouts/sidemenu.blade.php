<header class="flex items-center justify-between bg-[#363b46] px-5 text-white" x-data="{ accountModal: false }">
  @if ($url)
    <a href="{{ $url }}"><img class="h-6 w-6" src="{{ global_asset('img/icon/arrow-l-w.png') }}" /></a>
  @else
    <div class="h-[30px] w-[30px] overflow-hidden rounded-full border bg-white">
      @if (Auth::user()->icon)
        <img class="h-full w-full object-cover" src="{{ route('profile.icon', ['id' => Auth::id()]) }}"
          x-on:click="accountModal=!accountModal" />
      @else
        <img class="h-full w-full object-cover" src="{{ global_asset('img/icon/user.png') }}"
          x-on:click="accountModal=!accountModal" />
      @endif
    </div>
  @endif

  <a class="h-[28px] w-[35px]" href="{{ route('home.index') }}">
    <img src="{{ global_asset('img/eruwork_white_logo.png') }}" />
  </a>

  <button class="relative flex h-4 w-4 flex-col items-center justify-between" @click="sideMenu = !sideMenu">
    <!-- 上の線 -->
    <span class="block h-[2px] w-full origin-center transform rounded bg-white transition-all duration-300"
      :class="sideMenu ? 'rotate-45 translate-y-[7px]' : ''"></span>

    <!-- 真ん中の線 -->
    <span class="block h-[2px] w-full rounded bg-white transition-all duration-300"
      :class="sideMenu ? 'opacity-0' : 'opacity-100'"></span>

    <!-- 下の線 -->
    <span class="block h-[2px] w-full origin-center transform rounded bg-white transition-all duration-300"
      :class="sideMenu ? '-rotate-45 -translate-y-[7px]' : ''"></span>
  </button>

  <div class="lg:account-modal-box account-mobile-modal-box absolute" id="accountModal" x-show="accountModal"
    x-on:click.away="accountModal=false">
    <div class="modal-content">
      <button class="flex items-center text-[14px] text-[#777777] hover:opacity-40" type="button"
        x-on:click="$dispatch('open-modal','profile'); accountModal=false">
        <img class="h-6 w-6" src="{{ global_asset('img/icon/account-modal-icon.png') }}" />
        アカウント
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
          <path fill-rule="evenodd"
            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
            clip-rule="evenodd" />
        </svg>
      </button>
      <div>
        <button class="flex items-center text-[14px] text-[#F76E80] hover:opacity-40" type="button"
          x-on:click="$dispatch('open-modal','logout')">
          <img class="h-6 w-6" src="{{ global_asset('img/icon/logout.png') }}" />
          ログアウト
          <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#f76e80">
            <path fill-rule="evenodd h-[10px]"
              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
              clip-rule="evenodd" />
          </svg>
        </button>
      </div>
    </div>

</header>

<div
  class="duration-50 fixed top-[50px] z-10 h-[calc(var(--vh)*100-50px)] w-full bg-[#363B464D] bg-opacity-30 backdrop-blur-[6px] transition-opacity"
  :class="{ 'opacity-100': sideMenu, 'opacity-0 pointer-events-none': !sideMenu }"></div>
<div
  class="fixed right-0 top-[50px] z-20 h-[calc(var(--vh)*100-50px)] w-[85%] transform space-y-3 overflow-y-auto bg-[#363b46] py-[30px] pl-[30px] pr-[18px] transition-transform duration-300"
  x-data="{ adminMenu: false }" :class="{ 'translate-x-0': sideMenu, 'translate-x-full': !sideMenu }">

  <a class="flex h-10 items-center space-x-[10px]" href="{{ route('home.index') }}">
    <div @class([
        'h-[35px] w-[35px] rounded-lg flex items-center justify-center',
        'bg-[#3289FA]' => request()->routeIs('home'),
    ])>
      <img class="h-6 w-6" src="{{ global_asset('img/icon/home.png') }}" />
    </div>
    <div class="text-[15px] font-bold text-white">ホーム</div>
  </a>

  <a class="flex h-10 items-center space-x-[10px]" href="{{ route('timecard.index') }}">
    <div @class([
        'h-[35px] w-[35px] rounded-lg flex items-center justify-center',
        'bg-[#3289FA]' => request()->routeIs('timecard.*'),
    ])>
      <img class="h-6 w-6" src="{{ global_asset('img/icon/timecard.png') }}" />
    </div>
    <div class="text-[15px] font-bold text-white">タイムカード</div>
  </a>

  <a class="flex h-10 items-center space-x-[10px]" href="{{ route('calendar.index') }}">
    <div @class([
        'h-[35px] w-[35px] rounded-lg flex items-center justify-center',
        'bg-[#3289FA]' => request()->routeIs('calendar.*'),
    ])>
      <img class="h-6 w-6" src="{{ global_asset('img/icon/calendar.png') }}" />
    </div>
    <div class="text-[15px] font-bold text-white">カレンダー</div>
  </a>

  <a class="flex h-10 items-center space-x-[10px]" href="{{ route('shift.schedule', ['category' => 'week']) }}">
    <div @class([
        'h-[35px] w-[35px] rounded-lg flex items-center justify-center',
        'bg-[#3289FA]' => request()->routeIs('shift.*'),
    ])>
      <img class="h-6 w-6" src="{{ global_asset('img/icon/shift.png') }}" />
    </div>
    <div class="text-[15px] font-bold text-white">シフト表</div>
  </a>

  <a class="flex h-10 items-center space-x-[10px]" href="{{ route('chat.index') }}">
    <div @class([
        'h-[35px] w-[35px] rounded-lg flex items-center justify-center',
        'bg-[#3289FA]' => request()->routeIs('chat.*'),
    ])>
      <img class="h-6 w-6" src="{{ global_asset('img/icon/chat.png') }}" />
    </div>
    <div class="text-[15px] font-bold text-white">チャット</div>
  </a>

  <a class="flex h-10 items-center space-x-[10px]" href="{{ route('board.index') }}">
    <div @class([
        'h-[35px] w-[35px] rounded-lg flex items-center justify-center',
        'bg-[#3289FA]' =>
            request()->routeIs('board.*') | request()->routeIs('draft.*'),
    ])>
      <img class="h-6 w-6" src="{{ global_asset('img/icon/keiji.png') }}" />
    </div>
    <div class="text-[15px] font-bold text-white">掲示板</div>
  </a>

  <a class="flex h-10 items-center space-x-[10px]" href="{{ route('manualFolder.index') }}">
    <div @class([
        'h-[35px] w-[35px] rounded-lg flex items-center justify-center',
        'bg-[#3289FA]' =>
            request()->routeIs('manualFolder.*') |
            request()->routeIs('manualFile.*'),
    ])>
      <img class="h-6 w-6" src="{{ global_asset('img/icon/manual.png') }}" />
    </div>
    <div class="text-[15px] font-bold text-white">マニュアル</div>
  </a>

  @can('register')
    <button class="flex h-10 w-full items-center justify-between" @click="adminMenu=!adminMenu">
      <div class="flex items-center space-x-[10px]">
        <div @class([
            'h-[35px] w-[35px] rounded-lg flex items-center justify-center',
            'bg-[#3289FA]' =>
                request()->routeIs('shiftManager.*') |
                request()->routeIs('timecardManager.*') |
                request()->routeIs('account.*') |
                request()->routeIs('hourlyRate.*') |
                request()->routeIs('attendanceManager.*') |
                request()->routeIs('chatManager.*') |
                request()->routeIs('manualFolderManager.*') |
                request()->routeIs('manualFileManager.*'),
        ])>
          <img class="h-6 w-6" src="{{ global_asset('img/icon/setting.png') }}" />
        </div>
        <div class="text-[15px] font-bold text-white">管理者設定</div>
      </div>
      <img class="h-6 w-6" src="{{ global_asset('img/icon/arrow-down.png') }}" />
    </button>

    <div
      class="-ml-[30px] -mr-[18px] flex flex-col space-y-[10px] overflow-hidden bg-[#3D475D] pl-[75px] text-[15px] transition-all duration-300"
      :class="adminMenu ? 'max-h-[1000px] p-[10px]' : 'max-h-0 p-0'">
      <a href="{{ route('shiftManager.index') }}" @class([
          'p-[10px] text-white',
          'bg-[#3289FA] rounded-lg' => request()->routeIs('shiftManager.*'),
      ])>シフト管理</a>

      <a href="{{ route('timecardManager.index') }}" @class([
          'p-[10px] text-white',
          'bg-[#3289FA] rounded-lg' => request()->routeIs('timecardManager.*'),
      ])>タイムカード管理</a>

      <a href="{{ route('account.index') }}" @class([
          'p-[10px] text-white',
          'bg-[#3289FA] rounded-lg' => request()->routeIs('account.*'),
      ])>アカウント管理</a>

      <a href="{{ route('hourlyRate.index') }}" @class([
          'p-[10px] text-white',
          'bg-[#3289FA] rounded-lg' => request()->routeIs('hourlyRate.*'),
      ])>時給管理</a>

      <a href="{{ route('attendanceManager.index') }}" @class([
          'p-[10px] text-white',
          'bg-[#3289FA] rounded-lg' => request()->routeIs('attendanceManager.*'),
      ])>勤怠管理</a>

      <a href="{{ route('chatManager.index') }}" @class([
          'p-[10px] text-white',
          'bg-[#3289FA] rounded-lg' => request()->routeIs('chatManager.*'),
      ])>チャット管理</a>

      <a href="{{ route('manualFolderManager.index') }}" @class([
          'p-[10px] text-white',
          'bg-[#3289FA] rounded-lg' =>
              request()->routeIs('manualFolderManager.*') |
              request()->routeIs('manualFileManager.*'),
      ])>マニュアル管理</a>
    </div>
  @endcan

</div>
