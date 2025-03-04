<x-app-layout>
  <x-widget>
    <div class="flex space-x-3 py-2">
      <div class="text-lg font-bold">掲示板編集画面</div>
    </div>

    @vite(['Modules/Board/resources/js/tiptap.js', 'resources/css/tiptap.css'])

    @livewire('board::edit-editor', ['postId' => $post->id])

    {{-- <livewire:board::edit-editor :postId="{{ $post->id }}" /> --}}

    {{-- <form action="{{ route('board.update', ['board' => $post->id ?? 0]) }}" method="POST" enctype="multipart/form-data"
      x-data="editor('{{ addslashes(old('contents', $post->contents ?? '')) }}')">
      @csrf
      <div>
        <label class="block text-sm font-medium text-gray-700" for="title">タイトル</label>
        <input
          class="block w-full border border-gray-300 bg-gray-50 p-2.5 text-lg text-gray-900 focus:border-blue-500 focus:ring-blue-500"
          id="title" name="title" type="text" value="{{ old('title', $post->title ?? '') }}">
        @error('title')
          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700" for="contents">本文</label>

        @error('contents')
          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
      </div>
      <div class="py-2">
        <livewire:board::download, post={{ $post }} canBeDeleted = "false" />
        <label class="block text-sm font-medium text-gray-700" for="file">ファイル添付</label>
        <input class="mt-1 block" id="files" name="files[]" type="file" multiple>
        @error('file')
          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
      </div>
      <div class="row mx-52 mt-10 flex justify-center space-x-5">
        <button class="flex-grow rounded bg-ao-main px-4 py-2 text-white hover:bg-sky-700" name="action" type="button"
          value="save" @click="submitFormSave">
          更新
        </button>
        @if ($post->status == false)
          <button class="flex-grow rounded bg-ao-main px-4 py-2 text-white hover:bg-sky-700" name="action"
            type="button" value="post" @click="submitFormPost">
            投稿する
          </button>
        @endif
        <a class="flex-grow rounded border px-4 py-2 text-center hover:bg-sky-500 hover:text-white"
          href="{{ route('board.index') }}">
          戻る
        </a>
        <input name="action" type="hidden" x-ref="actionInput">
      </div>
    </form> --}}
  </x-widget>
</x-app-layout>
