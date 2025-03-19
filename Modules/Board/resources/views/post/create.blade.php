<x-app-layout>
  <x-widget>
    <div class="flex flex-wrap items-center justify-between pb-2">
      <div class="flex flex-row items-center space-x-2">
        <div class="h-auto self-stretch border-l-4 border-ao-main"></div>
        <div class="text-lg font-bold">掲示板投稿画面</div>
      </div>
    </div>
    @vite(['Modules/Board/resources/js/tiptap.js', 'resources/css/tiptap.css'])
    @livewire('board::create-editor')
  </x-widget>
</x-app-layout>
