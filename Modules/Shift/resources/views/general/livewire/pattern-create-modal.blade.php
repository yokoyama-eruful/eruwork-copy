<div class="flex items-center">
  <button class="text-xs text-[#3289FA] hover:opacity-40" type="button" wire:click="setPattern"
    x-on:click="$dispatch('open-modal','pattern-create-modal')">パターンを登録する</button>
  <x-modal name="pattern-create-modal" title="シフトパターン登録">
    <form wire:submit="save">

      @if ($errors->any())
        <div class="mb-4 rounded border border-red-300 bg-red-50 p-3 text-xs text-red-600">
          <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="flex items-center justify-between">
        <div class="text-sm font-medium">最大3つまでパターンを登録できます。</div>
        <button class="text-sm font-bold text-[#3289FA] hover:opacity-40" type="button"
          wire:click="settingReset">設定をリセット</button>
      </div>

      <div class="mt-5">
        <x-input-label for="title" value="パターン1" />
        <div class="flex w-full items-center space-x-[10px]">
          <x-text-input class="w-1/2" type="time" placeholder="0:00" wire:model="startTime1" />
          <div>〜</div>
          <x-text-input class="w-1/2" type="time" placeholder="0:00" wire:model="endTime1" />
        </div>
      </div>

      <div class="mt-5">
        <x-input-label for="title" value="パターン2" />
        <div class="flex w-full items-center space-x-[10px]">
          <x-text-input class="w-1/2" type="time" placeholder="0:00" wire:model="startTime2" />
          <div>〜</div>
          <x-text-input class="w-1/2" type="time" placeholder="0:00" wire:model="endTime2" />
        </div>
      </div>

      <div class="mt-5">
        <x-input-label for="title" value="パターン3" />
        <div class="flex w-full items-center space-x-[10px]">
          <x-text-input class="w-1/2" type="time" placeholder="0:00" wire:model="startTime3" />
          <div>〜</div>
          <x-text-input class="w-1/2" type="time" placeholder="0:00" wire:model="endTime3" />
        </div>
      </div>

      <div class="-mx-4 -mb-[30px] mt-[30px] flex items-center justify-center rounded-b bg-white py-4">
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
