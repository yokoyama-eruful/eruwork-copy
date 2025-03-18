<x-app-layout>
  <x-widget>
    <div class="flex space-x-3 pb-2">
      <div class="text-lg font-bold">掲示板編集画面</div>
    </div>

    @vite(['Modules/Board/resources/js/tiptap.js', 'resources/css/tiptap.css'])

    @livewire('board::edit-editor', ['postId' => $post->id])
  </x-widget>
</x-app-layout>
