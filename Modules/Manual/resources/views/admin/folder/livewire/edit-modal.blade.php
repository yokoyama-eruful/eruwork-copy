<div>
  <x-modal name="manual-folder-edit-modal-{{ $folder->id }}" title="マニュアルフォルダー編集">
    <form wire:submit="edit">
      <div class="">
        <x-input-label for="title" value="表題" />
        <x-text-input class="w-full" type="text" wire:model="form.title" required />
      </div>

      <div class="-mx-4 -mb-[30px] mt-[30px] flex items-center justify-center rounded-b bg-white py-4">
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
