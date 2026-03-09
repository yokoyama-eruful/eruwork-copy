<header class="flex items-center bg-[#363b46] px-5 text-white lg:hidden" x-data="{ accountModal: false }">
  <div class="flex w-[30px] items-center justify-start">
    @if ($url)
      <a class="flex h-[30px] w-[30px] items-center justify-center" href="{{ $url }}"><img class="h-6 w-6"
          src="{{ asset('img/icon/arrow-l-w.png') }}" /></a>
    @else
      <div class="h-[30px] w-[30px] overflow-hidden rounded-full border bg-white">
        @if (Auth::user()->icon)
          <img class="h-full w-full object-cover" src="{{ route('profile.icon', ['id' => Auth::id()]) }}"
            x-on:click="accountModal=!accountModal" />
        @else
          <img class="h-full w-full object-cover" src="{{ asset('img/icon/user.png') }}"
            x-on:click="accountModal=!accountModal" />
        @endif
      </div>
    @endif
  </div>

  <a class="mx-auto h-[28px] w-[35px] shrink-0" href="{{ route('home.index') }}">
    <img src="{{ asset('img/eruwork_white_logo.png') }}" />
  </a>

  <div class="flex w-[30px] items-center justify-end">
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
  </div>

  <div class="lg:account-modal-box account-mobile-modal-box absolute" style="padding: 10px 5px 10px 10px;" id="accountModal" x-show="accountModal"
    x-on:click.away="accountModal=false">
    <div class="modal-content">
      <button class="flex w-full items-center gap-[1px] leading-none text-[0.8125rem] text-[#777777] hover:opacity-40" type="button"
        x-on:click="$dispatch('open-modal','profile'); accountModal=false">
        <img class="mr-0 h-[20px] w-[20px] shrink-0" src="{{ asset('img/icon/account-modal-icon.png') }}" />
        アカウント
        <svg class="ml-auto h-[20px] w-[20px] shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none">
          <path d="M8 6L12 10L8 14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
            stroke-linejoin="round" />
        </svg>
      </button>
      <div>
        <button class="flex w-full items-center gap-[1px] leading-none text-[0.8125rem] text-[#F76E80] hover:opacity-40" type="button"
          x-on:click="$dispatch('open-modal','logout')">
          <img class="mr-0 h-[20px] w-[20px] shrink-0" src="{{ asset('img/icon/logout.png') }}" />
          ログアウト
          <svg class="ml-auto h-[20px] w-[20px] shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none">
            <path d="M8 6L12 10L8 14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
              stroke-linejoin="round" />
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
      <img class="h-6 w-6" src="{{ asset('img/icon/home.png') }}" />
    </div>
    <div class="text-[0.9375rem] font-bold text-white">ホーム</div>
  </a>

  <a class="flex h-10 items-center space-x-[10px]" href="{{ route('timecard.index') }}">
    <div @class([
        'h-[35px] w-[35px] rounded-lg flex items-center justify-center',
        'bg-[#3289FA]' => request()->routeIs('timecard.*'),
    ])>
      <img class="h-6 w-6" src="{{ asset('img/icon/timecard.png') }}" />
    </div>
    <div class="text-[0.9375rem] font-bold text-white">タイムカード</div>
  </a>

  <a class="flex h-10 items-center space-x-[10px]" href="{{ route('calendar.index') }}">
    <div @class([
        'h-[35px] w-[35px] rounded-lg flex items-center justify-center',
        'bg-[#3289FA]' => request()->routeIs('calendar.*'),
    ])>
      <img class="h-6 w-6" src="{{ asset('img/icon/calendar.png') }}" />
    </div>
    <div class="text-[0.9375rem] font-bold text-white">カレンダー</div>
  </a>

  <a class="flex h-10 items-center space-x-[10px]" href="{{ route('shift.schedule', ['category' => 'week']) }}">
    <div @class([
        'h-[35px] w-[35px] rounded-lg flex items-center justify-center',
        'bg-[#3289FA]' => request()->routeIs('shift.*'),
    ])>
      <img class="h-6 w-6" src="{{ asset('img/icon/shift.png') }}" />
    </div>
    <div class="text-[0.9375rem] font-bold text-white">シフト表</div>
  </a>

  <a class="flex h-10 items-center space-x-[10px]" href="{{ route('chat.index') }}">
    <div @class([
        'h-[35px] w-[35px] rounded-lg flex items-center justify-center',
        'bg-[#3289FA]' => request()->routeIs('chat.*'),
    ])>
      <img class="h-6 w-6" src="{{ asset('img/icon/chat.png') }}" />
    </div>
    <div class="text-[0.9375rem] font-bold text-white">チャット</div>
  </a>

  <a class="flex h-10 items-center space-x-[10px]" href="{{ route('board.index') }}">
    <div @class([
        'h-[35px] w-[35px] rounded-lg flex items-center justify-center',
        'bg-[#3289FA]' =>
            request()->routeIs('board.*') | request()->routeIs('draft.*'),
    ])>
      <img class="h-6 w-6" src="{{ asset('img/icon/keiji.png') }}" />
    </div>
    <div class="text-[0.9375rem] font-bold text-white">掲示板</div>
  </a>

  <a class="flex h-10 items-center space-x-[10px]" href="{{ route('manualFolder.index') }}">
    <div @class([
        'h-[35px] w-[35px] rounded-lg flex items-center justify-center',
        'bg-[#3289FA]' =>
            request()->routeIs('manualFolder.*') |
            request()->routeIs('manualFile.*'),
    ])>
      <img class="h-6 w-6" src="{{ asset('img/icon/manual.png') }}" />
    </div>
    <div class="text-[0.9375rem] font-bold text-white">マニュアル</div>
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
                request()->routeIs('manualFileManager.*') |
                request()->routeIs('setting.*'),
        ])>
          <img class="h-6 w-6" src="{{ asset('img/icon/setting.png') }}" />
        </div>
        <div class="text-[0.9375rem] font-bold text-white">管理者設定</div>
      </div>
      <img class="h-6 w-6" src="{{ asset('img/icon/arrow-down.png') }}" />
    </button>

    <div
      class="-ml-[30px] -mr-[18px] flex flex-col space-y-[10px] overflow-hidden bg-[#3D475D] pl-[75px] text-[0.9375rem] transition-all duration-300"
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

      <a href="{{ route('setting.index') }}" @class([
          'p-[10px] text-white',
          'bg-[#3289FA] rounded-lg' => request()->routeIs('setting.*'),
      ])>各種設定</a>
    </div>
  @endcan

</div>
