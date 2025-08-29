<div class="flex min-h-[30px] w-full items-center justify-between pt-[30px] sm:max-h-[30px] sm:min-w-[1300px] sm:pt-0">
  <div class="flex w-full items-center justify-between px-[20px] sm:w-auto sm:justify-normal sm:px-0">
    {{ $slot }}
  </div>
  @vite(['resources/js/account.js'])
  <button class="account-area hidden sm:flex">
    <img class="account-img" src="{{ global_asset('img/icon/yokoyama.png') }}" />
    <p>{{ Auth::user()->name }}</p>
    <img class="account-arrow-down" src="{{ global_asset('img/icon/arrow-down.png') }}" />
  </button>
  <div class="account-modal-box" id="accountModal" style="display: none">
    <div class="modal-content">
      <a class="account-setting" href="{{ route('profile.edit') }}">
        <img src="{{ global_asset('img/icon/account-modal-icon.png') }}" />
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
          <img src="{{ global_asset('img/icon/logout.png') }}" />
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
</div>
