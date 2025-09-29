<div>
  <button
    class='flex h-[35px] items-center rounded-[5px] bg-[#3289fa] px-5 py-2 text-sm font-bold text-[#fff] hover:bg-[#3289fa4d]'
    type="button" x-on:click="$dispatch('open-modal','manual-folder-create-modal')">
    <img class="mr-[5px] h-[15px] w-[15px]" src="{{ global_asset('img/icon/add-schedule.png') }}" />
    新規作成
  </button>
  <x-modal name="manual-folder-create-modal" title="マニュアルフォルダー作成">
    <form class="p-4" wire:submit="create">
      <div class="mb-[46px] mt-[30px] grid grid-cols-[20%,80%] items-center">
        <x-input-label for="title" value="表題" />
        <x-text-input name="title" type="text" wire:model="form.title" />
      </div>

      <div class="-mx-4 -mb-4 mt-4 flex items-center justify-center rounded-b bg-white py-4">
        <x-secondary-button x-on:click="$dispatch('close')">
          {{ __('Cancel') }}
        </x-secondary-button>

        <x-primary-button class="ms-3">
          登 録
        </x-primary-button>
      </div>
    </form>
  </x-modal>
</div>
