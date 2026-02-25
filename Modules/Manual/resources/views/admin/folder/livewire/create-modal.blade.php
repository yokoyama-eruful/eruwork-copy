<div>
  <button
    class='flex h-[35px] items-center rounded-[5px] bg-[#3289fa] px-[8px] py-[4px] text-sm font-bold text-[#fff] hover:bg-[#3289fa4d] lg:px-5 lg:py-2'
    type="button" x-on:click="$dispatch('open-modal','manual-folder-create-modal')">
    <img class="mr-[5px] h-[15px] w-[15px]" src="{{ asset('img/icon/add-schedule.png') }}" />
    新規作成
  </button>
  <x-modal name="manual-folder-create-modal" title="マニュアルフォルダー作成">
    <form wire:submit="create">
      <div class="w-full">
        <x-input-label for="title" value="フォルダー名" />
        <x-text-input class="w-full" name="title" type="text" wire:model="form.title" />
      </div>

      <div class="-mx-4 -mb-[30px] mt-5 flex items-center justify-center space-x-[10px] rounded-b bg-white py-4 lg:mt-[30px]">
        <x-secondary-button x-on:click="$dispatch('close')">
          {{ __('Cancel') }}
        </x-secondary-button>

        <x-primary-button class="w-[150px]">
          登 録
        </x-primary-button>
      </div>
    </form>
  </x-modal>
</div>
