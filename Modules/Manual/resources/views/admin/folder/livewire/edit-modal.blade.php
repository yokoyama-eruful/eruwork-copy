<div>
  <x-modal name="manual-folder-edit-modal-{{ $folder->id }}" title="マニュアルフォルダー作成">
    <form class="p-4" wire:submit="edit">
      <div class="my-[30px] grid grid-cols-[20%,80%] items-center">
        <x-input-label for="title" value="表題" />
        <x-text-input type="text" wire:model="form.title" required />
      </div>

      <div class="-mx-4 -mb-4 mt-4 flex items-center justify-center rounded-b bg-white py-4">
        <x-secondary-button x-on:click.stop="$dispatch('close')">
          {{ __('Cancel') }}
        </x-secondary-button>

        <x-primary-button class="ms-3" @click.stop>
          更新
        </x-primary-button>
      </div>
    </form>
  </x-modal>
</div>
