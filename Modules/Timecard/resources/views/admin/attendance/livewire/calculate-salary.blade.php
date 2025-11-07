<div>
  <div class="mx-5 flex items-center space-x-[8px] lg:mx-0 lg:space-x-[10px]">
    {{-- <div class="flex h-10 w-[170px] items-center justify-center space-x-1 rounded bg-[#F7F7F7]">
      <p class="text-[11px]">端数処理方法：</p>
      <p class="text-sm font-semibold">{{ $fraction ?? '--' }}</p>
    </div>
    <div class="flex h-10 w-[170px] items-center justify-center space-x-1 rounded bg-[#F7F7F7]">
      <p class="text-[11px]">時給発生の単位：</p>
      <p class="text-sm font-semibold">{{ $payUnit ? $payUnit . '分' : '--分' }}</p>
    </div> --}}
    <div class="flex h-10 w-1/2 items-center justify-center space-x-1 rounded bg-[#F7F7F7] lg:w-[170px]">
      <p class="text-[11px]">深夜割増料金：</p>
      <p class="text-sm font-semibold">{{ $nightRate ? $nightRate . '%割増' : '--%割増' }}</p>
    </div>
    <div class="flex h-10 w-1/2 items-center justify-center space-x-1 rounded bg-[#F7F7F7] lg:w-[170px]">
      <p class="text-[11px]">残業料金：</p>
      <p class="text-sm font-semibold">{{ $overtimeRate ? $overtimeRate . '%割増' : '--%割増' }}</p>
    </div>
  </div>
  <x-modal name="wage-premium-modal" title="給与計算設定">
    <form method="POST" wire:submit.prevent>
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

      <div class="grid grid-cols-[40%,20%,40%] items-center">
        <x-input-label for="nightRate" value="深夜割増料金" />

        <x-text-input class="w-[55px]" wire:model="form.nightRate" />

        <div class="text-sm">%割増</div>
      </div>

      <div class="grid grid-cols-[40%,20%,40%] items-center pt-5">
        <div class="flex flex-col">
          <x-input-label for="overtimeRate" value="残業料金設定" />
          <div class="text-[10px] text-[#000000] text-opacity-30">※勤務8時間超で適用</div>
        </div>

        <x-text-input class="w-[55px]" wire:model="form.overtimeRate" />

        <div class="text-sm">%割増</div>
      </div>

      <div class="-mx-4 -mb-[30px] mt-[30px] flex items-center justify-center rounded-b bg-white py-4">
        <x-secondary-button x-on:click="$dispatch('close')">
          {{ __('Cancel') }}
        </x-secondary-button>

        <x-primary-button class="ms-3" wire:click="create">
          登録
        </x-primary-button>
      </div>

    </form>
  </x-modal>
</div>
