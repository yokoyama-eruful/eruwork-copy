<div class="flex min-h-[30px] w-full items-center justify-between pt-[30px] lg:max-h-[30px] lg:min-w-[1300px] lg:pt-0"
  x-data="{ accountModal: false }">
  <div class="flex w-full items-center justify-between px-[20px] lg:w-auto lg:justify-normal lg:px-0">
    {{ $slot }}
  </div>
  <button class="account-area hidden lg:flex" type="button" x-on:click="accountModal=!accountModal">
    @if (Auth::user()->icon)
      <img class="h-[30px] w-[30px] rounded-full" src="{{ route('profile.icon', ['id' => Auth::id()]) }}" />
    @else
      <div class="h-[30px] w-[30px] rounded-full border border-[#DDDDDD]"></div>
    @endif
    <p>{{ Auth::user()->name }}</p>
    <img class="account-arrow-down" src="{{ asset('img/icon/arrow-down.png') }}" />
  </button>
  <div class="account-modal-box" id="accountModal" x-show="accountModal" x-on:click.away="accountModal=false">
    <div class="modal-content">
      <button class="flex items-center text-xs hover:opacity-40" type="button"
        x-on:click="$dispatch('open-modal','profile'); accountModal=false">
        <img class="h-5 w-5" src="{{ asset('img/icon/account-modal-icon.png') }}" />
        アカウント
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
          <path fill-rule="evenodd"
            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
            clip-rule="evenodd" />
        </svg>
      </button>
      <div>
        <button class="flex items-center text-xs text-[#F76E80] hover:opacity-40" type="button"
          x-on:click="$dispatch('open-modal','logout')">
          <img class="h-5 w-5" src="{{ asset('img/icon/logout.png') }}" />
          ログアウト
          <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="#f76e80">
            <path fill-rule="evenodd"
              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
              clip-rule="evenodd" />
          </svg>
        </button>
      </div>
    </div>
  </div>
</div>
