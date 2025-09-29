<x-modal name="edit-modal-{{ $publicHoliday->id }}" title="公休日編集">
  <div class="flex items-center justify-between px-4 pt-4">
    <div class="text-xl font-bold"> {{ $form->date }}</div>
    <form wire:submit="delete">
      @csrf
      @method('delete')
      <x-danger-button>削除</x-danger-button>
    </form>
  </div>
  <form class="px-4 pb-4" wire:submit="update">

    <div class="mt-4">
      <x-input-label for="name" value="公休日名" />

      <x-text-input class="mt-1 block w-full" id="name" name="name" type="text" wire:model="form.name"
        placeholder="公休日名" required />

      <x-input-error class="mt-2" :messages="$errors->userDeletion->get('name')" />
    </div>

    <div class="-mx-4 -mb-4 mt-4 flex items-center justify-center rounded-b bg-white py-4">
      <x-secondary-button x-on:click="$dispatch('close')">
        {{ __('Cancel') }}
      </x-secondary-button>

      <x-primary-button class="ms-3">
        更新
      </x-primary-button>
    </div>
  </form>
</x-modal>
