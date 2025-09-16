<div class="side-menu">
  <div class="sm:hidden">
    @if ($url)
      <a href="{{ $url }}">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
            d="M7.71984 12.5308C7.57939 12.3902 7.50051 12.1996 7.50051 12.0008C7.50051 11.8021 7.57939 11.6114 7.71984 11.4708L15.2198 3.97082C15.362 3.83834 15.5501 3.76622 15.7444 3.76965C15.9387 3.77308 16.1241 3.85179 16.2615 3.9892C16.3989 4.12661 16.4776 4.312 16.481 4.5063C16.4844 4.7006 16.4123 4.88865 16.2798 5.03082L9.30985 12.0008L16.2798 18.9708C16.3535 19.0395 16.4126 19.1223 16.4536 19.2143C16.4946 19.3063 16.5167 19.4056 16.5184 19.5063C16.5202 19.607 16.5017 19.707 16.464 19.8004C16.4262 19.8938 16.3701 19.9786 16.2989 20.0499C16.2277 20.1211 16.1428 20.1772 16.0494 20.2149C15.9561 20.2527 15.856 20.2712 15.7553 20.2694C15.6546 20.2676 15.5553 20.2456 15.4633 20.2046C15.3713 20.1636 15.2885 20.1045 15.2198 20.0308L7.71984 12.5308Z"
            fill="white" />
        </svg>
      </a>
    @else
      <button class="account-area sp">
        <img src="{{ global_asset('img/icon/yokoyama.png') }}" />
      </button>
    @endif
  </div>

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
            <li class="acc">
              <button class="acc-btn" aria-expanded="false" aria-controls="admin-acc-panel">
                <div @class([
                    'menuicon_bg',
                    'menuicon_acbg' => request()->routeIs('shiftManager.*'),
                ])>
                  <img src="{{ global_asset('img/icon/setting.png') }}" />
                </div>
                管理者<br class="pc" />設定
                <span class="caret" aria-hidden="true"></span>
              </button>
              <ul class="acc-panel" id="admin-acc-panel" hidden>
                <li class="acc-title">管理者設定</li>
                <li class="sub-title">メニュー</li>
                <li><a href="{{ route('shiftManager.index') }}" @class([
                    'bg-blue-500 rounded' => request()->routeIs('shiftManager.*'),
                ])>シフト管理</a></li>
                <li><a href="{{ route('timecardManager.index') }}" @class([
                    'bg-blue-500 rounded' => request()->routeIs('timecardManager.*'),
                ])>タイムカード管理</a></li>
                <li><a href="{{ route('account.index') }}" @class([
                    'bg-blue-500 rounded' => request()->routeIs('account.*'),
                ])>アカウント管理</a></li>
                <li><a href="{{ route('public_holiday.index') }}" @class([
                    'bg-blue-500 rounded' => request()->routeIs('public_holiday.*'),
                ])>公休日登録</a></li>
                <li><a href="{{ route('hourlyRate.index') }}" @class([
                    'bg-blue-500 rounded' => request()->routeIs('hourlyRate.*'),
                ])>時給管理</a></li>
                <li><a href="{{ route('attendanceManager.index') }}" @class([
                    'bg-blue-500 rounded' => request()->routeIs('attendanceManager.*'),
                ])>勤怠管理</a></li>
                <li><a href="{{ route('chatManager.index') }}" @class([
                    'bg-blue-500 rounded' => request()->routeIs('chatManager.*'),
                ])>チャット管理</a></li>
                <li><a href="{{ route('manualFolderManager.index') }}" @class([
                    'bg-blue-500 rounded' =>
                        request()->routeIs('manualFolderManager.*') ||
                        request()->routeIs('manualFileManager.*'),
                ])>マニュアル管理</a></li>
              </ul>
            </li>
            <li>
              <a href="{{ route('manualFolder.index') }}">
                <div @class([
                    'menuicon_bg',
                    'menuicon_acbg' =>
                        request()->routeIs('manualFolder.*') ||
                        request()->routeIs('manualFile.*'),
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
</div>
