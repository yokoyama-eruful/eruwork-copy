<div>
  <div class="hidden items-center space-x-[10px] sm:flex">
    {{-- <div class="flex h-10 w-[170px] items-center justify-center space-x-1 rounded bg-[#F7F7F7]">
      <p class="text-[11px]">端数処理方法：</p>
      <p class="text-sm font-semibold">{{ $fraction ?? '--' }}</p>
    </div>
    <div class="flex h-10 w-[170px] items-center justify-center space-x-1 rounded bg-[#F7F7F7]">
      <p class="text-[11px]">時給発生の単位：</p>
      <p class="text-sm font-semibold">{{ $payUnit ? $payUnit . '分' : '--分' }}</p>
    </div> --}}
    <div class="flex h-10 w-[170px] items-center justify-center space-x-1 rounded bg-[#F7F7F7]">
      <p class="text-[11px]">深夜割増料金：</p>
      <p class="text-sm font-semibold">{{ $overtimeRate ? $overtimeRate . '%割増' : '--%割増' }}</p>
    </div>
    <div class="flex h-10 w-[170px] items-center justify-center space-x-1 rounded bg-[#F7F7F7]">
      <p class="text-[11px]">残業料金：</p>
      <p class="text-sm font-semibold">{{ $nightRate ? $nightRate . '%割増' : '--%割増' }}</p>
    </div>
    <button class="flex items-center space-x-1 hover:opacity-40" type="button"
      @click="$dispatch('open-modal','wage-premium-modal')">
      <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
          d="M6.75 5.625L9 9M9 9L11.25 5.625M9 9V12.9375M11.25 9H6.75M11.25 11.25H6.75M15.75 9C15.75 9.88642 15.5754 10.7642 15.2362 11.5831C14.897 12.4021 14.3998 13.1462 13.773 13.773C13.1462 14.3998 12.4021 14.897 11.5831 15.2362C10.7642 15.5754 9.88642 15.75 9 15.75C8.11358 15.75 7.23583 15.5754 6.41689 15.2362C5.59794 14.897 4.85382 14.3998 4.22703 13.773C3.60023 13.1462 3.10303 12.4021 2.76381 11.5831C2.42459 10.7642 2.25 9.88642 2.25 9C2.25 7.20979 2.96116 5.4929 4.22703 4.22703C5.4929 2.96116 7.20979 2.25 9 2.25C10.7902 2.25 12.5071 2.96116 13.773 4.22703C15.0388 5.4929 15.75 7.20979 15.75 9Z"
          stroke="#3289FA" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
      <p class="text-sm font-bold text-[#3289FA]">給与算出設定</p>
    </button>
  </div>
  <x-modal name="wage-premium-modal" title="給与計算設定" wire:submit="create">
    <form class="m-4" method="post" wire:submit="create">
      @csrf

      {{-- <div class="mt-[18px] grid grid-cols-[30%,70%] items-center">
        <x-input-label for="fraction" value="端数処理方法" />

        <div class="grid w-full grid-cols-3 items-center">
          <label class="flex items-center">
            <input class="form-radio text-indigo-600" type="radio" value="切り上げ" wire:model="fraction">
            <span class="ml-1 text-sm">切り上げ</span>
          </label>

          <label class="flex items-center">
            <input class="form-radio text-indigo-600" type="radio" value="切り捨て" wire:model="fraction">
            <span class="ml-1 text-sm">切り捨て</span>
          </label>

          <label class="flex items-center">
            <input class="form-radio text-indigo-600" type="radio" value="四捨五入" wire:model="fraction">
            <span class="ml-1 text-sm">四捨五入</span>
          </label>
        </div>
      </div>

      <div class="mt-[30px] grid grid-cols-[30%,70%] items-center">
        <x-input-label for="payUnit" value="時給発生の単位" />

        <div class="grid w-full grid-cols-3 items-center">
          <label class="flex items-center">
            <input type="radio" value="1" wire:model="payUnit">
            <span class="ml-1 text-sm">1分</span>
          </label>

          <label class="flex items-center">
            <input type="radio" value="15" wire:model="payUnit">
            <span class="ml-1 text-sm">15分</span>
          </label>

          <label class="flex items-center">
            <input type="radio" value="30" wire:model="payUnit">
            <span class="ml-1 text-sm">30分</span>
          </label>
        </div>
      </div> --}}

      <div class="grid grid-cols-[30%,15%,55%] items-center px-4 pt-[18px]">
        <div class="flex flex-col">
          <x-input-label for="overtimeRate" value="残業料金設定" />
          <div class="text-[10px] text-[#000000] text-opacity-30">※勤務8時間超で適用</div>
        </div>

        <x-text-input class="w-[55px]" wire:model="form.overtimeRate" />

        <div class="text-sm">%割増</div>
      </div>

      <div class="grid grid-cols-[30%,15%,55%] items-center px-4 pb-[30px] pt-[30px]">
        <x-input-label for="nightRate" value="深夜割増料金" />

        <x-text-input class="w-[55px]" wire:model="form.nightRate" />

        <div class="text-sm">%割増</div>
      </div>

      <div class="-mx-4 flex items-center justify-center rounded-b bg-white py-4">
        <x-secondary-button x-on:click="$dispatch('close')">
          {{ __('Cancel') }}
        </x-secondary-button>

        <x-primary-button class="ms-3">
          登録
        </x-primary-button>
      </div>

    </form>
  </x-modal>
</div>
