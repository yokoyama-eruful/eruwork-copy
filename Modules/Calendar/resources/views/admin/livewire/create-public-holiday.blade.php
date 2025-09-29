<x-modal name="create-modal-{{ $date->format('Y-m-d') }}" title="公休日登録">
  <form class="p-4" method="post" wire:submit="add">
    @csrf

    @if ($errors->any())
      <div class="mb-4 rounded border border-red-300 bg-red-50 p-3 text-xs text-red-600">
        <ul class="list-disc pl-5">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="text-xl font-bold"> {{ $date->format('Y年m月d日') }}</div>

    <div class="mt-4">
      <x-input-label for="name" value="公休日名" />

      <x-text-input class="mt-1 block w-full" id="name" name="name" type="text" wire:model="form.name"
        placeholder="公休日名" required />
    </div>

    <div class="-mx-4 -mb-4 mt-4 flex items-center justify-center rounded-b bg-white py-4">
      <x-secondary-button x-on:click="$dispatch('close')">
        {{ __('Cancel') }}
      </x-secondary-button>

      <x-primary-button class="ms-3">
        登録
      </x-primary-button>
    </div>
  </form>
</x-modal>
