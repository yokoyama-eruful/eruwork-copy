<x-app-layout>
  <div class="flex h-full w-full flex-col rounded bg-white shadow-sm" x-data="{ viewGroupCreateDialog: false }">
    <div class="flex h-8 w-full items-center rounded-t bg-ao-main text-white">
      <div class="flex w-1/6 flex-wrap justify-between px-2">
        <div>グループ一覧</div>
        <button class="flex h-6 w-6 items-center justify-center rounded bg-white text-ao-main hover:bg-gray-200"
          x-on:click.prevent="$dispatch('open-modal', 'view-group-create-dialog')">
          <i class="fa-solid fa-plus"></i>
        </button>
      </div>
    </div>
    <div class="flex w-full flex-1 flex-row text-gray-900">

      @livewire('chat::member-list', ['selectGroup' => $selectGroup])

      <div class="h-full w-5/6">
        @yield('content')
      </div>
    </div>
    @livewire('chat::create-group')
  </div>
</x-app-layout>
