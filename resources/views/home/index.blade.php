<x-app-layout>
  {{-- top.cssの読み込み --}}
  @vite(['resources/css/top.css'])
  <div class="sidebar">
    {{-- タイムカードの読み込み（Modules/Timecard/resources/views/general/livewire/stamp.blade.php） --}}
    <livewire:timecard::general.stamp />
    <hr class="border-line" />
    {{-- 掲示板の読み込み（Modules/Board/resources/views/livewire/widget.blade.php） --}}
    <livewire:board::widget />
  </div>

  <x-main.index class="hidden sm:block">
    <x-main.top>
      <button class="add-schedule" type="button" x-on:click="$dispatch('open-modal')">
        <img src="img/icon/add-schedule.png" />
        予定を追加する
      </button>
      <div class="flex items-center">
        <button class="calender-move" wire:click="clickDate('')">
          <i class="fa-solid fa-angle-left"></i>
          前月
        </button>
        <select class="select-y top-calender-menu-select" wire:model.live="year" wire:change="updateCalendar">
          @for ($year = 2020; $year <= 2050; $year++)
            <option value="{{ $year }}">{{ $year }}年</option>
          @endfor
        </select>
        <select class="select-m top-calender-menu-select" wire:model.live="month" wire:change="updateCalendar">
          @for ($month = 1; $month <= 12; $month++)
            <option value="{{ $month }}">{{ $month }}月</option>
          @endfor
        </select>
        <button class="calender-move" wire:click="clickDate('')">
          翌月
          <i class="fa-solid fa-angle-right"></i>
        </button>
        <button class="today-btn" wire:click="clickDate('')">今日</button>
        {{-- シフト通知の読み込み --}}
        <livewire:shift::general.widget />
      </div>
    </x-main.top>
    <x-main.container>
      {{-- カレンダーの読み込み --}}
      {{-- <livewire:calendar::general.widget /> --}}
      <div class="calendar-body">
        <!-- 左：月（固定）＋ 時間軸（固定） -->
        <div class="calendar-left">
          <div class="month-label">9月</div>
          <div class="calender-time-column">
            <div class="time-cell"><span class="tick-label">午前 8時</span></div>
            <div class="time-cell"><span class="tick-label current-time">午前 9時</span></div>
            <div class="time-cell"><span class="tick-label">午前 10時</span></div>
            <div class="time-cell"><span class="tick-label">午前 11時</span></div>
            <div class="time-cell"><span class="tick-label">午前 12時</span></div>
            <div class="time-cell"><span class="tick-label">午後 1時</span></div>
            <div class="time-cell"><span class="tick-label">午後 2時</span></div>
            <div class="time-cell"><span class="tick-label">午後 3時</span></div>
            <div class="time-cell"><span class="tick-label">午後 4時</span></div>
            <div class="time-cell"><span class="tick-label">午後 5時</span></div>
            <div class="time-cell"><span class="tick-label">午後 6時</span></div>
            <div class="time-cell"><span class="tick-label">午後 7時</span></div>
            <div class="time-cell"><span class="tick-label">午後 8時</span></div>
            <div class="time-cell"><span class="tick-label">午後 9時</span></div>
            <div class="time-cell"><span class="tick-label">午後 10時</span></div>
            <div class="time-cell"><span class="tick-label">午後 11時</span></div>
            <div class="time-cell"><span class="tick-label">午後 12時</span></div>
            <div class="time-cell"><span class="tick-label">午前 1時</span></div>
            <div class="time-cell"><span class="tick-label">午前 2時</span></div>
            <div class="time-cell"><span class="tick-label">午前 3時</span></div>
            <div class="time-cell"><span class="tick-label">午前 4時</span></div>
            <div class="time-cell"><span class="tick-label">午前 5時</span></div>
            <div class="time-cell"><span class="tick-label">午前 6時</span></div>
            <div class="time-cell"><span class="tick-label">午前 7時</span></div>
          </div>
        </div>

        <!-- 右：ヘッダー（日付）＋ スケジュール（同じ横スクロール） -->
        <div class="schedule-scroll">
          <!-- ヘッダー（日付） -->
          <div class="top-calender-day-area">
            <div class="top-calender-day calender-today-color">
              <span class="otherday">月</span>
              <p>23</p>
            </div>
            <div class="top-calender-day">
              <span class="otherday">火</span>
              <p>24</p>
            </div>
            <div class="top-calender-day">
              <span class="otherday">水</span>
              <p>25</p>
            </div>
            <div class="top-calender-day">
              <span class="otherday">木</span>
              <p>26</p>
            </div>
            <div class="top-calender-day">
              <span class="otherday">金</span>
              <p>27</p>
            </div>
            <div class="top-calender-day">
              <span class="saturday">土</span>
              <p>28</p>
            </div>
            <div class="top-calender-day">
              <span class="sunday">日</span>
              <p>29</p>
            </div>
          </div>

          <!-- スケジュール本体 -->
          <div class="calender-schedule-grid">
            <div class="schedule-day">
              <div class="deck" aria-label="カードスタック（横重なり）">
                <article class="card card--stack event-card01" role="button" aria-selected="false" tabindex="0"
                  style="--i: 0">
                  <p class="title">全体朝礼</p>
                  <span class="card-time">午前9時～10時</span>
                </article>

                <article class="card card--stack event-card02" role="button" aria-selected="true" tabindex="0"
                  style="--i: 1">
                  <p class="title">リーダー会議</p>
                  <span class="card-time">
                    午前9時～10時
                    <br />
                    これは長いやつ とりあえずテキストで長くしてる
                  </span>
                </article>

                <article class="card card--stack event-card03" role="button" aria-selected="false" tabindex="0"
                  style="--i: 2">
                  <p class="title">全体掃除</p>
                  <span class="card-time">午前9時～10時</span>
                </article>
              </div>
            </div>

            <div class="schedule-day"></div>
            <div class="schedule-day"></div>
            <div class="schedule-day">
              <div class="deck" aria-label="カードスタック（横重なり）">
                <article class="card card--stack event-card01" role="button" aria-selected="false" tabindex="0"
                  style="--i: 0">
                  <p class="title">全体朝礼</p>
                  <span class="card-time">午前9時～10時</span>
                </article>

                <article class="card card--stack event-card02" role="button" aria-selected="true" tabindex="0"
                  style="--i: 1">
                  <p class="title">リーダー会議</p>
                  <span class="card-time">
                    午前9時～10時
                    <br />
                    これは長いやつ とりあえずテキストで長くしてる
                  </span>
                </article>
              </div>
            </div>

            <div class="schedule-day"></div>
            <div class="schedule-day"></div>
            <div class="schedule-day"></div>
          </div>
        </div>
      </div>
    </x-main.container>
  </x-main.index>

  <!-- モーダル（HTML標準のdialog要素） -->
  <dialog id="cardModal" aria-modal="true">
    <div class="modal">
      <div class="modal-header">
        <div class="modal-title" id="modalTitle">タイトル</div>
        <button class="modal-close" id="modalClose" aria-label="閉じる">×</button>
      </div>
      <div class="modal-body" id="modalBody">本文</div>
    </div>
  </dialog>

  {{-- 以下モバイル --}}
  <div class="overlay"></div>
  <div class="sp">
    <div class="slider">
      <div class="slides-wrapper">
        <a href="">
          <div class="bulletin-board-area slide">
            <div class="bulletin-board-box">
              <div class="new-ribbon">NEW</div>
              <div class="board-title">
                <span>2025.08.01</span>
                <img src="images/icon/attached-icon.png" />
              </div>
              <div class="board-text">
                <h4 class="ellipsis">館内設備について日時変更がありましたのでお知らせします</h4>
                <p>サンプル 太郎</p>
              </div>
            </div>
          </div>
        </a>
        <a href="">
          <div class="bulletin-board-area slide">
            <div class="bulletin-board-box">
              <div class="new-ribbon">NEW</div>
              <div class="board-title">
                <span>2025.08.01</span>
                <img src="images/icon/attached-icon.png" />
              </div>
              <div class="board-text">
                <h4 class="ellipsis">館内設備について日時変更がありましたのでお知らせします</h4>
                <p>サンプル 太郎</p>
              </div>
            </div>
          </div>
        </a>
        <a href="">
          <div class="bulletin-board-area slide">
            <div class="bulletin-board-box">
              <div class="new-ribbon">NEW</div>
              <div class="board-title">
                <span>2025.08.01</span>
                <img src="images/icon/attached-icon.png" />
              </div>
              <div class="board-text">
                <h4 class="ellipsis">館内設備について日時変更がありましたのでお知らせします</h4>
                <p>サンプル 太郎</p>
              </div>
            </div>
          </div>
        </a>
      </div>
      <div class="pagination">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    {{-- タイムカードの読み込み（Modules/Timecard/resources/views/general/livewire/stamp.blade.php） --}}
    <livewire:timecard::general.stamp />

    <div class="calender-area-sp">
      <h3 class="calender-sp-title">シフト</h3>
      <div class="calendar-sp-month-day">
        <h4>9月</h4>
        <div class="calendar-sp-day">
          <ul>
            <li class="current calendar-sp-day-box">
              <a href="">
                <span>月</span>
                23
              </a>
            </li>
            <li class="calendar-sp-day-box">
              <a href="">
                <span>火</span>
                24
              </a>
            </li>
            <li class="calendar-sp-day-box">
              <a href="">
                <span>水</span>
                25
              </a>
            </li>
            <li class="calendar-sp-day-box">
              <a href="">
                <span>木</span>
                26
              </a>
            </li>
            <li class="calendar-sp-day-box">
              <a href="">
                <span>金</span>
                27
              </a>
            </li>
            <li class="calendar-sp-day-box">
              <a href="">
                <span>土</span>
                28
              </a>
            </li>
            <li class="calendar-sp-day-box">
              <a href="">
                <span>日</span>
                29
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="schedule-box-area">
        <h4>9月23日の予定</h4>
        <div class="schedule-detail-box">
          <p>予定は入っていません</p>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
