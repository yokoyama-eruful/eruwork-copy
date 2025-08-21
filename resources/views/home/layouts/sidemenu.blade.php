@vite(['resources/css/sidemenu.css'])
<div class="side-menu">
  <!-- アイコンとリンク -->
  <img class="side-menu-logo" src="img/eruwork_white_logo.png" />
  <ul>
    <li>
      <a href="{{ route('home') }}">
        <div @class(['menuicon_bg', 'menuicon_acbg' => request()->routeIs('home')])>
          <img src="img/icon/home.png" />
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
          <img src="img/icon/timecard.png" />
        </div>
        <p>タイム
          <br />
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
          <img src="img/icon/calendar.png" />
        </div>
        <p>カレンダー</p>
      </a>
    </li>
    <li>
      <a href="{{ route('shift.index') }}">
        <div @class([
            'menuicon_bg',
            'menuicon_acbg' => request()->routeIs('shift.*'),
        ])>
          <img src="img/icon/shift.png" />
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
          <img src="img/icon/chatpng.png" />
        </div>
        <p>チャット</p>
      </a>
    </li>
    <li>
      <a href="{{ route('board.index') }}">
        <div @class([
            'menuicon_bg',
            'menuicon_acbg' => request()->routeIs('board.*'),
        ])>
          <img src="img/icon/keiji.png" />
        </div>
        <p>掲示板</p>
      </a>
    </li>
    <li>
      <a href="{{ route('dashboard') }}">
        <div @class([
            'menuicon_bg',
            'menuicon_acbg' => request()->routeIs('dashboard.*'),
        ])>
          <img src="img/icon/setting.png" />
        </div>
        <p>管理者
          <br />
          設定
        </p>
      </a>
    </li>
    <li>
      <a href="{{ route('manual.index') }}">
        <div @class([
            'menuicon_bg',
            'menuicon_acbg' => request()->routeIs('manual.*'),
        ])>
          <img src="img/icon/manual.png" />
        </div>
        <p>マニュアル</p>
      </a>
    </li>
  </ul>
</div>
