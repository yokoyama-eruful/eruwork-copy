<div class="side-menu">
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
</div>
