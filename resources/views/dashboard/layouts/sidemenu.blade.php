{{-- <div class="h-full rounded-r bg-white p-4 shadow-sm">
  <div class="mb-3">
    <div class="flex items-center">
      <div class="mr-2 h-6 w-1 bg-hai-main"></div>
      <h2 class="text-xl font-semibold">メニュー</h2>
    </div>
  </div>
  <nav class="mb-4">
    <ul class="grid grid-cols-4 gap-2 sm:grid-cols-6 xl:grid-cols-2">
      <li class="mb-2">
        <a class="mb-2 flex h-20 w-20 flex-col rounded border bg-ao-sub shadow hover:bg-sky-200"
          href="{{ route('dashboard') }}">
          <svg class="p-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path
              d="M256.7,17.8l245.9,175.7v299.9h-185.2v-165.9h-121.3v165.9H10.8V193.4L256.7,17.8M256.7,9.3L3.9,189.9v310.3h199.1v-165.9h107.4v165.9h199.1V189.9L256.7,9.3h0Z"
              fill="#6f8184" stroke="#6f8184" stroke-miterlimit="10" stroke-width="8" />
          </svg>
          <div class="rounded-b bg-hai-main">
            <span class="flex items-center justify-center text-xs text-white">ホーム</span>
          </div>
        </a>
      </li>
      <li class="mb-2">
        @include('account::icon')
      </li>
      <li class="mb-2">
        @include('calendar::admin.icon')
      </li>
      <li class="mb-2">
        @include('shift::admin.icon')
      </li>
      <li class="mb-2">
        @include('chat::admin.icon')
      </li>
      <li class="mb-2">
        @include('hourlyrate::icon')
      </li>
      <li class="mb-2">
        @include('timecard::admin.icon')
      </li>
      <li class="mb-2">
        @include('timecard::general.icon')
      </li>
    </ul>
  </nav>

  <div class="mb-3">
    <div class="flex items-center">
      <div class="mr-2 h-6 w-1 bg-ao-main"></div>
      <h2 class="text-xl font-semibold">一般</h2>
    </div>
  </div>
  <nav>
    <ul class="grid grid-cols-4 gap-2 sm:grid-cols-6 xl:grid-cols-2">
      <li class="mb-2">
        <a class="mb-2 flex h-20 w-20 flex-col rounded border bg-ao-sub shadow hover:bg-sky-200"
          href="{{ route('home') }}">
          <svg class="p-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path
              d="M256.7,17.8l245.9,175.7v299.9h-185.2v-165.9h-121.3v165.9H10.8V193.4L256.7,17.8M256.7,9.3L3.9,189.9v310.3h199.1v-165.9h107.4v165.9h199.1V189.9L256.7,9.3h0Z"
              fill="#6f8184" stroke="#6f8184" stroke-miterlimit="10" stroke-width="8" />
          </svg>
          <div class="rounded-b bg-ao-main">
            <span class="flex items-center justify-center text-xs text-white">一般</span>
          </div>
        </a>
      </li>
    </ul>
  </nav>
</div> --}}

<div class="side-menu-d-board">
  <button class="account-area sp">
    <img src="{{ global_asset('img/icon/yokoyama.png') }}" />
  </button>

  <!-- アイコンとリンク -->
  <img class="side-menu-logo side-menu-center" src="{{ global_asset('img/eruwork_white_logo.png') }}" />

  <div class="right-wrap">
    <img class="side-menu-icon sp" src="{{ global_asset('img/icon/news-bell-sp.png') }}" />
    <div class="hamburger">
      <p class="btn-gNav">
        <span></span>
        <span></span>
        <span></span>
      </p>
      <div class="gNav">
        <nav>
          <ul class="gNav-menu">
            <li>
              <a href="{{ route('home') }}">
                <div @class(['menuicon_bg', 'menuicon_acbg' => request()->routeIs('home')])>
                  <img src="{{ global_asset('img/icon/home.png') }}" />
                </div>
                <p>ホーム</p>
              </a>
            </li>
            <li>
              <a href="{{ route('timecard.index') }}">
                <div @class([
                    'menuicon_bg',
                    'menuicon_acbg' => request()->routeIs('timecard.*'),
                ])>
                  <img src="{{ global_asset('img/icon/timecard.png') }}" />
                </div>
                <p>タイム
                  <br class="pc" />
                  カード
                </p>
              </a>
            </li>
            <li>
              <a href="{{ route('calendar.index') }}">
                <div @class([
                    'menuicon_bg',
                    'menuicon_acbg' => request()->routeIs('calendar.*'),
                ])>
                  <img src="{{ global_asset('img/icon/calendar.png') }}" />
                </div>
                <p>カレンダー</p>
              </a>
            </li>
            <li>
              <a href="{{ route('shift.schedule', ['category' => 'week']) }}">
                <div @class([
                    'menuicon_bg',
                    'menuicon_acbg' => request()->routeIs('shift.*'),
                ])>
                  <img src="{{ global_asset('img/icon/shift.png') }}" />
                </div>
                <p>シフト表</p>
              </a>
            </li>
            <li>
              <a href="{{ route('chat.index') }}">
                <div @class([
                    'menuicon_bg',
                    'menuicon_acbg' => request()->routeIs('chat.*'),
                ])>
                  <img src="{{ global_asset('img/icon/chat.png') }}" />
                </div>
                <p>チャット</p>
              </a>
            </li>
            <li>
              <a href="{{ route('board.index') }}">
                <div @class([
                    'menuicon_bg',
                    'menuicon_acbg' =>
                        request()->routeIs('board.*') | request()->routeIs('draft.*'),
                ])>
                  <img src="{{ global_asset('img/icon/keiji.png') }}" />
                </div>
                <p>掲示板</p>
              </a>
            </li>
            <li class="acc is-open pc" data-pinned>
              <button class="acc-btn" aria-expanded="true" aria-controls="admin-acc-panel">
                <div @class([
                    'menuicon_bg',
                    'menuicon_acbg' => request()->routeIs('shiftManager.*'),
                ])>
                  <img src="{{ global_asset('img/icon/setting.png') }}" />
                </div>
                管理者<br class="pc" />設定
                <span class="caret" aria-hidden="true"></span>
              </button>
              <ul class="acc-panel is-open" id="admin-acc-panel">
                <li class="acc-title">管理者設定</li>
                <li class="sub-title">メニュー</li>
                <li><a href="{{ route('shiftManager.index') }}">シフト管理</a></li>
                <li><a href="#">タイムカード管理</a></li>
                <li><a href="#">アカウント管理</a></li>
                <li><a href="#">公休日登録</a></li>
                <li><a href="#">勤怠管理</a></li>
                <li><a href="#">チャット管理</a></li>
                <li><a href="#">マニュアル管理</a></li>
              </ul>
            </li>
            <li>
              <a href="{{ route('manual.index') }}">
                <div @class([
                    'menuicon_bg',
                    'menuicon_acbg' => request()->routeIs('manual.*'),
                ])>
                  <img src="{{ global_asset('img/icon/manual.png') }}" />
                </div>
                <p>マニュアル</p>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>

  <div class="d-board-menu">
    <ul>
      <li class="acc-title">管理者設定</li>
      <li class="sub-title">メニュー</li>
      <li><a href="{{ route('shiftManager.index') }}">シフト管理</a></li>
      <li><a href="#">タイムカード管理</a></li>
      <li><a href="#">アカウント管理</a></li>
      <li><a href="#">公休日登録</a></li>
      <li><a href="#">勤怠管理</a></li>
      <li><a href="#">チャット管理</a></li>
      <li><a href="#">マニュアル管理</a></li>
    </ul>
  </div>
</div>
