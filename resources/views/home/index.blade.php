<x-app-layout>
  {{-- top.cssの読み込み --}}
  @vite(['resources/css/top.css'])
  {{--
    <livewire:shift::general.widget />
    <livewire:calendar::general.widget />
    <livewire:timecard::general.stamp />
    <livewire:board::widget />
  --}}
  <div class="sidebar">
    {{-- タイムカードの読み込み（Modules/Timecard/resources/views/general/livewire/stamp.blade.php） --}}
    <livewire:timecard::general.stamp />
    <hr class="border-line" />
    {{-- 掲示板の読み込み（Modules/Board/resources/views/livewire/widget.blade.php） --}}
    <livewire:board::widget />
  </div>

  <x-main.index>
    <!-- ヘッダー、カレンダー、打刻など -->
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
        <div class="speach-news">
          <img src="img/icon/news-bell.png" />
          <div class="speech-bubble">
            <p>シフト申請：</p>
            <a href="">2件受信済み</a>
            <img src="img/icon/close.png" />
          </div>
        </div>
      </div>
    </x-main.top>
    <x-main.container>
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

  <script>
    (() => {
      // ===== 設定 =====
      const GAP_FIXED = 15; // “ずらし”の上限(px)
      const SAFE = 1; // 右端の安全余白(px)
      const MIN_W = 140; // カード最小幅(px)

      // ===== モーダル（共通） =====
      const modal = document.getElementById("cardModal");
      const modalTitle = document.getElementById("modalTitle");
      const modalBody = document.getElementById("modalBody");
      const modalClose = document.getElementById("modalClose");

      function openModalFromCard(card) {
        const titleEl = card.querySelector(".title");
        const bodyEl = card.querySelector(".body");
        modalTitle.textContent = titleEl ? titleEl.textContent : "詳細";
        modalBody.textContent = bodyEl ? bodyEl.textContent : "内容がありません。";
        if (typeof modal.showModal === "function") modal.showModal();
        else modal.setAttribute("open", "");
        modalClose?.focus({
          preventScroll: true
        });
      }

      function closeModal() {
        if (modal.hasAttribute("open")) modal.close?.();
        modal.removeAttribute("open");
      }
      modal?.addEventListener("click", (e) => {
        const r = modal.getBoundingClientRect();
        const inside = e.clientX >= r.left && e.clientX <= r.right && e.clientY >= r.top && e.clientY <= r.bottom;
        if (!inside) closeModal();
      });
      modalClose?.addEventListener("click", closeModal);
      window.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && modal.hasAttribute("open")) closeModal();
      });

      // ===== レイアウト（単一デッキ） =====
      function layoutDeck(deckEl) {
        const cards = Array.from(deckEl.querySelectorAll(".card"));
        const n = cards.length;
        if (!n) return;

        deckEl.style.removeProperty("width");
        const deckW = deckEl.clientWidth;

        // 狭いときは gap を自動縮小
        let gapMax = n > 1 ? (deckW - SAFE - MIN_W) / (n - 1) : 0;
        gapMax = Math.max(0, gapMax);
        const gap = Math.min(GAP_FIXED, gapMax);

        const cardW = Math.max(MIN_W, deckW - gap * (n - 1) - SAFE);

        cards.forEach((c, i) => {
          if (!c.hasAttribute("tabindex")) c.setAttribute("tabindex", "0");
          if (!c.hasAttribute("role")) c.setAttribute("role", "button");
          if (!c.hasAttribute("aria-selected")) c.setAttribute("aria-selected", "false");

          c.style.position = "absolute";
          c.style.left = "0";
          c.style.width = cardW + "px";
          c.style.transform = `translateX(${i * gap}px)`;
          c.style.zIndex = String(i + 1); // 右に行くほど前面
        });
      }

      function layoutAllDecks() {
        document.querySelectorAll(".deck").forEach(layoutDeck);
      }

      // ===== 右端へ移動（クリック動作） =====
      function isRightmost(card) {
        const deckEl = card.closest(".deck");
        if (!deckEl) return false;
        const last = Array.from(deckEl.querySelectorAll(".card")).pop();
        return last === card;
      }

      function moveToRight(card) {
        const deckEl = card.closest(".deck");
        if (!deckEl) return;
        // 1) 選択状態をリセット
        deckEl.querySelectorAll(".card").forEach((c) => c.setAttribute("aria-selected", "false"));
        // 2) 末尾へ移動（DOM順を変える）
        deckEl.appendChild(card);
        // 3) レイアウト更新
        layoutDeck(deckEl);
        // 4) このカードを選択状態に
        card.setAttribute("aria-selected", "true");
        card.focus({
          preventScroll: true
        });
      }

      // ===== イベント委譲（全デッキ共通） =====
      document.addEventListener("click", (e) => {
        const card = e.target.closest(".deck .card");
        if (!card) return;

        if (isRightmost(card)) {
          // すでに右端＝選択中 → モーダル
          openModalFromCard(card);
        } else {
          moveToRight(card);
        }
      });

      document.addEventListener("keydown", (e) => {
        if (e.key !== "Enter" && e.key !== " ") return;
        const card = e.target.closest?.(".deck .card");
        if (!card) return;
        e.preventDefault();

        if (isRightmost(card)) openModalFromCard(card);
        else moveToRight(card);
      });

      // ===== 初期化 =====
      if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", () => {
          layoutAllDecks();
          observeDecks();
        });
      } else {
        layoutAllDecks();
        observeDecks();
      }

      // ===== リサイズ追従 =====
      function observeDecks() {
        const ro = new ResizeObserver(() => layoutAllDecks());
        document.querySelectorAll(".deck").forEach((el) => ro.observe(el));
        window.addEventListener("resize", layoutAllDecks);
      }
    })();
  </script>
</x-app-layout>
