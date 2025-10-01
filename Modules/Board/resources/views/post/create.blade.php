<x-app-layout :url="route('board.index')">
  @vite(['Modules/Board/resources/js/tiptap.js', 'resources/css/tiptap.css'])
  @livewire('board::create-editor')
</x-app-layout>
