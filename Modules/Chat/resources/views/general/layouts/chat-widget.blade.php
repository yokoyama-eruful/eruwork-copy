<x-app-layout>
  <div class="flex h-full w-full flex-col rounded bg-white shadow-sm" x-data="{ viewGroupCreateDialog: false }">
    <div class="hidden h-8 w-full items-center rounded-t bg-ao-main text-white xl:flex">
      <div class="flex w-full flex-wrap justify-between px-2 sm:w-1/6">
        <div>グループ一覧</div>
        <button class="flex h-6 w-6 items-center justify-center rounded bg-white text-ao-main hover:bg-gray-200"
          x-on:click.prevent="$dispatch('open-modal', 'view-group-create-dialog')">
          <i class="fa-solid fa-plus"></i>
        </button>
      </div>
    </div>
    <div class="flex w-full flex-1 flex-row text-gray-900">

      <div class="hidden h-full w-1/6 border-r border-gray-200 xl:block">
        @livewire('chat::general.member-list', ['selectGroup' => $selectGroup ?? null])
      </div>

      <div class="h-full w-full xl:w-5/6">
        @yield('content')
      </div>
    </div>
    @livewire('chat::general.create-group')
  </div>
</x-app-layout>
