<x-modal name="create-modal-{{ $date->format('Y-m-d') }}" title="公休日登録">
  <form class="p-4" method="post" wire:submit="add">
    @csrf

    <div class="text-xl font-bold"> {{ $date->format('Y年m月d日') }}</div>

    <div class="mt-4">
      <x-input-label for="name" value="公休日名" />

      <x-text-input class="mt-1 block w-full" id="name" name="name" type="text" wire:model="form.name"
        placeholder="公休日名" required />

      @error('form.name')
        <div class="font-normal text-red-500">{{ $message }}</div>
      @enderror
    </div>

    <x-slot:footer>
      <x-secondary-button x-on:click="$dispatch('close')">
        {{ __('Cancel') }}
      </x-secondary-button>

      <x-primary-button class="ms-3">
        登録
      </x-primary-button>
    </x-slot:footer>
  </form>
</x-modal>
