<x-app-layout>
  <x-widget>
    <div class="flex space-x-3 py-2">
      <div class="text-lg font-bold">掲示板投稿画面</div>
    </div>
    @vite(['Modules/Board/resources/js/tiptap.js', 'resources/css/tiptap.css'])
    @livewire('board::create-editor')
  </x-widget>
</x-app-layout>
