<x-app-layout :url="route('board.index')">
  @vite(['Modules/Board/resources/js/tiptap.js', 'resources/css/tiptap.css'])
  @livewire('board::edit-editor', ['postId' => $post->id])
</x-app-layout>
