<x-modal name="profile" title="プロフィール設定" maxWidth="440">
  <form class="px-[30px] py-5" id="update-profile" wire:submit="update" enctype="multipart/form-data">
    @if ($errors->any())
      <div class="mb-4 rounded border border-red-300 bg-red-50 p-3 text-xs text-red-600">
        <ul class="list-disc pl-5">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <div class="grid grid-cols-[30%,70%] items-center">
      <button
        class="relative flex h-[70px] w-[70px] items-center justify-center rounded-full bg-[#000000] bg-opacity-30 hover:opacity-50"
        type="button" onclick="document.getElementById('iconInput').click()">
        @if ($form->icon)
          <!-- 選択中のファイルをプレビュー -->
          <img class="h-full w-full rounded-full object-cover" src="{{ $form->icon->temporaryUrl() }}">
        @elseif (Auth::user()->icon)
          <!-- 既存のアイコン -->
          <img class="h-full w-full rounded-full object-cover"
            src="{{ global_asset('tenants/' . tenant()->id . '/app/' . Auth::user()->icon) }}">
        @else
        @endif
        <div class="absolute">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M2.25 15.75L7.409 10.591C7.61793 10.3821 7.86597 10.2163 8.13896 10.1033C8.41194 9.99018 8.70452 9.93198 9 9.93198C9.29548 9.93198 9.58806 9.99018 9.86104 10.1033C10.134 10.2163 10.3821 10.3821 10.591 10.591L15.75 15.75M14.25 14.25L15.659 12.841C15.8679 12.6321 16.116 12.4663 16.389 12.3533C16.6619 12.2402 16.9545 12.182 17.25 12.182C17.5455 12.182 17.8381 12.2402 18.111 12.3533C18.384 12.4663 18.6321 12.6321 18.841 12.841L21.75 15.75M3.75 19.5H20.25C20.6478 19.5 21.0294 19.342 21.3107 19.0607C21.592 18.7794 21.75 18.3978 21.75 18V6C21.75 5.60218 21.592 5.22064 21.3107 4.93934C21.0294 4.65804 20.6478 4.5 20.25 4.5H3.75C3.35218 4.5 2.97064 4.65804 2.68934 4.93934C2.40804 5.22064 2.25 5.60218 2.25 6V18C2.25 18.3978 2.40804 18.7794 2.68934 19.0607C2.97064 19.342 3.35218 19.5 3.75 19.5ZM14.25 8.25H14.258V8.258H14.25V8.25ZM14.625 8.25C14.625 8.34946 14.5855 8.44484 14.5152 8.51517C14.4448 8.58549 14.3495 8.625 14.25 8.625C14.1505 8.625 14.0552 8.58549 13.9848 8.51517C13.9145 8.44484 13.875 8.34946 13.875 8.25C13.875 8.15054 13.9145 8.05516 13.9848 7.98484C14.0552 7.91451 14.1505 7.875 14.25 7.875C14.3495 7.875 14.4448 7.91451 14.5152 7.98484C14.5855 8.05516 14.625 8.15054 14.625 8.25Z"
              stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </div>
      </button>

      <input id="iconInput" type="file" wire:model="form.icon" accept="image/*" hidden />

      <div class="break-words font-bold text-[#777777]">
        {{ Auth::user()->name }}
      </div>
    </div>

    <!-- 現在のパスワード -->
    <div class="relative mt-[10px] grid grid-cols-[30%,70%] items-center">
      <x-input-label name="current_password">現在のパスワード</x-input-label>
      <div class="relative w-full">
        <x-text-input class="pr-10" id="current_password" name="current_password" type="password"
          autocomplete="current-password" wire:model="form.currentPassword" />
        <button class="absolute right-3 top-1/2 -translate-y-1/2" id="current_togglePassword" type="button">
          <svg id="current_icon-hide" width="18" height="18" viewBox="0 0 18 18" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path
              d="M1.5271 9.2415C1.47534 9.08594 1.47534 8.91781 1.5271 8.76225C2.56735 5.6325 5.5201 3.375 9.0001 3.375C12.4786 3.375 15.4298 5.63025 16.4723 8.7585C16.5248 8.91375 16.5248 9.08175 16.4723 9.23775C15.4328 12.3675 12.4801 14.625 9.0001 14.625C5.5216 14.625 2.5696 12.3697 1.5271 9.2415Z"
              stroke="#3289FA" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
            <path
              d="M11.25 9C11.25 9.59674 11.0129 10.169 10.591 10.591C10.169 11.0129 9.59674 11.25 9 11.25C8.40326 11.25 7.83097 11.0129 7.40901 10.591C6.98705 10.169 6.75 9.59674 6.75 9C6.75 8.40326 6.98705 7.83097 7.40901 7.40901C7.83097 6.98705 8.40326 6.75 9 6.75C9.59674 6.75 10.169 6.98705 10.591 7.40901C11.0129 7.83097 11.25 8.40326 11.25 9Z"
              stroke="#3289FA" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          <svg class="hidden" id="current_icon-show" width="18" height="18" viewBox="0 0 18 18" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path
              d="M2.98494 6.16725C2.28328 6.99538 1.7608 7.9599 1.45044 9C2.41944 12.2535 5.43294 14.625 8.99994 14.625C9.74469 14.625 10.4647 14.5215 11.1472 14.3287M4.67094 4.671C5.95542 3.8234 7.461 3.37266 8.99994 3.375C12.5669 3.375 15.5797 5.7465 16.5487 8.9985C16.0177 10.7755 14.8777 12.3087 13.3289 13.329M4.67094 4.671L2.24994 2.25M4.67094 4.671L7.40844 7.4085M13.3289 13.329L15.7499 15.75M13.3289 13.329L10.5914 10.5915C10.8004 10.3826 10.9661 10.1345 11.0792 9.86149C11.1923 9.58848 11.2505 9.29587 11.2505 9.00037C11.2505 8.70488 11.1923 8.41227 11.0792 8.13926C10.9661 7.86626 10.8004 7.6182 10.5914 7.40925C10.3825 7.2003 10.1344 7.03455 9.86143 6.92147C9.58842 6.80839 9.29581 6.75018 9.00032 6.75018C8.70482 6.75018 8.41221 6.80839 8.1392 6.92147C7.8662 7.03455 7.61814 7.2003 7.40919 7.40925M10.5907 10.5908L7.40994 7.41"
              stroke="#3289FA" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </button>
      </div>
    </div>

    <!-- 新しいパスワード -->
    <div class="relative mt-[10px] grid grid-cols-[30%,70%] items-center">
      <x-input-label name="new_password">新しいパスワード</x-input-label>
      <div class="relative w-full">
        <x-text-input class="pr-10" id="new_password" name="new_password" type="password" autocomplete="new-password"
          wire:model="form.newPassword" />
        <button class="absolute right-3 top-1/2 -translate-y-1/2" id="new_togglePassword" type="button">
          <svg id="new_icon-hide" width="18" height="18" viewBox="0 0 18 18" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path
              d="M1.5271 9.2415C1.47534 9.08594 1.47534 8.91781 1.5271 8.76225C2.56735 5.6325 5.5201 3.375 9.0001 3.375C12.4786 3.375 15.4298 5.63025 16.4723 8.7585C16.5248 8.91375 16.5248 9.08175 16.4723 9.23775C15.4328 12.3675 12.4801 14.625 9.0001 14.625C5.5216 14.625 2.5696 12.3697 1.5271 9.2415Z"
              stroke="#3289FA" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
            <path
              d="M11.25 9C11.25 9.59674 11.0129 10.169 10.591 10.591C10.169 11.0129 9.59674 11.25 9 11.25C8.40326 11.25 7.83097 11.0129 7.40901 10.591C6.98705 10.169 6.75 9.59674 6.75 9C6.75 8.40326 6.98705 7.83097 7.40901 7.40901C7.83097 6.98705 8.40326 6.75 9 6.75C9.59674 6.75 10.169 6.98705 10.591 7.40901C11.0129 7.83097 11.25 8.40326 11.25 9Z"
              stroke="#3289FA" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          <svg class="hidden" id="new_icon-show" width="18" height="18" viewBox="0 0 18 18" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path
              d="M2.98494 6.16725C2.28328 6.99538 1.7608 7.9599 1.45044 9C2.41944 12.2535 5.43294 14.625 8.99994 14.625C9.74469 14.625 10.4647 14.5215 11.1472 14.3287M4.67094 4.671C5.95542 3.8234 7.461 3.37266 8.99994 3.375C12.5669 3.375 15.5797 5.7465 16.5487 8.9985C16.0177 10.7755 14.8777 12.3087 13.3289 13.329M4.67094 4.671L2.24994 2.25M4.67094 4.671L7.40844 7.4085M13.3289 13.329L15.7499 15.75M13.3289 13.329L10.5914 10.5915C10.8004 10.3826 10.9661 10.1345 11.0792 9.86149C11.1923 9.58848 11.2505 9.29587 11.2505 9.00037C11.2505 8.70488 11.1923 8.41227 11.0792 8.13926C10.9661 7.86626 10.8004 7.6182 10.5914 7.40925C10.3825 7.2003 10.1344 7.03455 9.86143 6.92147C9.58842 6.80839 9.29581 6.75018 9.00032 6.75018C8.70482 6.75018 8.41221 6.80839 8.1392 6.92147C7.8662 7.03455 7.61814 7.2003 7.40919 7.40925M10.5907 10.5908L7.40994 7.41"
              stroke="#3289FA" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </button>
      </div>
    </div>

    <!-- 確認用パスワード -->
    <div class="relative mt-[10px] grid grid-cols-[30%,70%] items-center">
      <x-input-label name="new_password_confirmation">新しいパスワード<br>
        <p class="text-[11px] text-[#6F6C6C]">※確認用</p>
      </x-input-label>
      <div class="relative w-full">
        <x-text-input class="pr-10" id="new_password_confirmation" name="new_password_confirmation" type="password"
          autocomplete="new-password" wire:model="form.newPasswordConfirmation" />
        <button class="absolute right-3 top-1/2 -translate-y-1/2" id="confirm_togglePassword" type="button">
          <svg id="confirm_icon-hide" width="18" height="18" viewBox="0 0 18 18" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path
              d="M1.5271 9.2415C1.47534 9.08594 1.47534 8.91781 1.5271 8.76225C2.56735 5.6325 5.5201 3.375 9.0001 3.375C12.4786 3.375 15.4298 5.63025 16.4723 8.7585C16.5248 8.91375 16.5248 9.08175 16.4723 9.23775C15.4328 12.3675 12.4801 14.625 9.0001 14.625C5.5216 14.625 2.5696 12.3697 1.5271 9.2415Z"
              stroke="#3289FA" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
            <path
              d="M11.25 9C11.25 9.59674 11.0129 10.169 10.591 10.591C10.169 11.0129 9.59674 11.25 9 11.25C8.40326 11.25 7.83097 11.0129 7.40901 10.591C6.98705 10.169 6.75 9.59674 6.75 9C6.75 8.40326 6.98705 7.83097 7.40901 7.40901C7.83097 6.98705 8.40326 6.75 9 6.75C9.59674 6.75 10.169 6.98705 10.591 7.40901C11.0129 7.83097 11.25 8.40326 11.25 9Z"
              stroke="#3289FA" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          <svg class="hidden" id="confirm_icon-show" width="18" height="18" viewBox="0 0 18 18"
            fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M2.98494 6.16725C2.28328 6.99538 1.7608 7.9599 1.45044 9C2.41944 12.2535 5.43294 14.625 8.99994 14.625C9.74469 14.625 10.4647 14.5215 11.1472 14.3287M4.67094 4.671C5.95542 3.8234 7.461 3.37266 8.99994 3.375C12.5669 3.375 15.5797 5.7465 16.5487 8.9985C16.0177 10.7755 14.8777 12.3087 13.3289 13.329M4.67094 4.671L2.24994 2.25M4.67094 4.671L7.40844 7.4085M13.3289 13.329L15.7499 15.75M13.3289 13.329L10.5914 10.5915C10.8004 10.3826 10.9661 10.1345 11.0792 9.86149C11.1923 9.58848 11.2505 9.29587 11.2505 9.00037C11.2505 8.70488 11.1923 8.41227 11.0792 8.13926C10.9661 7.86626 10.8004 7.6182 10.5914 7.40925C10.3825 7.2003 10.1344 7.03455 9.86143 6.92147C9.58842 6.80839 9.29581 6.75018 9.00032 6.75018C8.70482 6.75018 8.41221 6.80839 8.1392 6.92147C7.8662 7.03455 7.61814 7.2003 7.40919 7.40925M10.5907 10.5908L7.40994 7.41"
              stroke="#3289FA" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </button>
      </div>
    </div>

    <div class="mt-[24px] grid grid-cols-[30%,70%] items-center">
      <x-input-label name="new_password">通知</x-input-label>
      <div class="flex items-center space-x-[30px] text-xs">
        <div class="flex items-center space-x-2">
          <input id="allow" name="notification" type="radio" value="1" wire:model="form.notifyMessage"
            @if ($form->notifyMessage == true) checked @endif />
          <label for="allow">通知を許可</label>
        </div>
        <div class="flex items-center space-x-2">
          <input id="deny" name="notification" type="radio" value="0" wire:model="form.notifyMessage"
            @if ($form->notifyMessage == false) checked @endif />
          <label for="deny">通知を許可しない</label>
        </div>
      </div>
    </div>

    <script>
      function setupPasswordToggle(inputId, toggleBtnId, iconHideId, iconShowId) {
        const input = document.getElementById(inputId);
        const btn = document.getElementById(toggleBtnId);
        const iconHide = document.getElementById(iconHideId);
        const iconShow = document.getElementById(iconShowId);

        btn.addEventListener('click', () => {
          const isHidden = input.type === 'password';
          input.type = isHidden ? 'text' : 'password';
          iconHide.classList.toggle('hidden', !isHidden); // 非表示アイコンは非表示の時だけ見せる
          iconShow.classList.toggle('hidden', isHidden); // 表示アイコンは表示の時だけ見せる
        });
      }

      // 設定
      setupPasswordToggle('current_password', 'current_togglePassword', 'current_icon-hide', 'current_icon-show');
      setupPasswordToggle('new_password', 'new_togglePassword', 'new_icon-hide', 'new_icon-show');
      setupPasswordToggle('new_password_confirmation', 'confirm_togglePassword', 'confirm_icon-hide', 'confirm_icon-show');
    </script>

    <x-slot:footer>
      <x-secondary-button x-on:click="$dispatch('close')">
        {{ __('Cancel') }}
      </x-secondary-button>

      <x-primary-button class="ms-3" form="update-profile">
        更新する
      </x-primary-button>
    </x-slot:footer>
  </form>
</x-modal>
