<div class="flex min-w-[1300px] items-center justify-between">
  <div class="flex items-center">
    {{ $slot }}
  </div>
  @vite(['resources/css/account.css'])
  <button class="account-area">
    <img class="account-img" src="img/icon/yokoyama.png" />
    <p>横山 廉</p>
    <img class="account-arrow-down" src="img/icon/arrow-down.png" />
  </button>
  <div class="account-modal-box" id="accountModal" style="display: none">
    <div class="modal-content">
      <a class="account-setting" href="">
        <img src="img/icon/account-modal-icon.png" />
        アカウント
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
          <path fill-rule="evenodd"
            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
            clip-rule="evenodd" />
        </svg>
      </a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="account-logout" type="submit">
          <img src="img/icon/logout.png" />
          ログアウト
          <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#f76e80">
            <path fill-rule="evenodd"
              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
              clip-rule="evenodd" />
          </svg>
        </button>
      </form>
    </div>
  </div>
  <script>
    const accountBtn = document.querySelector(".account-area");
    const accountModal = document.getElementById("accountModal");
    // トグル表示
    accountBtn.addEventListener("click", (e) => {
      e.stopPropagation(); // 外クリック判定を防ぐ
      const isVisible = accountModal.style.display === "block";
      accountModal.style.display = isVisible ? "none" : "block";
    });

    // モーダル外をクリックしたら閉じる
    document.addEventListener("click", (e) => {
      if (!accountModal.contains(e.target) && !accountBtn.contains(e.target)) {
        accountModal.style.display = "none";
      }
    });
  </script>
</div>
