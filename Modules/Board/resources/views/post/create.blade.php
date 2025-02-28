<x-app-layout>
  <x-widget>
    @vite(['Modules/Board/resources/js/tiptap.js', 'resources/css/tiptap.css'])
    {{-- <x-widget.general title="掲示板-投稿画面" url="" actionName="" x-data="{ isEditable: true }"> --}}
    <form action="{{ route('board.store') }}" method="POST" enctype="multipart/form-data" x-data="editor('{{ addslashes(old('contents')) }}')">
      @csrf
      <div>
        <label class="block text-sm font-medium text-gray-700" for="title">タイトル</label>
        <input
          class="block w-full border border-gray-300 bg-gray-50 p-2.5 text-lg text-gray-900 focus:border-blue-500 focus:ring-blue-500"
          id="title" name="title" type="text" value="{{ old('title') }}">
        @error('title')
          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700" for="contents">本文</label>
        @include('board::layouts.tiptap')
        @error('contents')
          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
      </div>
      <div class="py-2">
        <label class="block text-sm font-medium text-gray-700" for="file">ファイル添付</label>
        <input class="mt-1 block" id="files" name="files[]" type="file" multiple>
        @error('file')
          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
      </div>
      <div class="row mx-52 mt-10 flex justify-center space-x-5">
        <button class="flex-grow rounded bg-ao-main px-4 py-2 text-white hover:bg-sky-700" name="action" type="submit"
          value="post" @click="submitFormPost">
          投稿
        </button>
        <button class="flex-grow rounded border px-4 py-2 hover:bg-sky-500 hover:text-white" name="action"
          type="submit" value="save" @click="submitFormSave">
          下書きとして保存
        </button>

        <input name="action" type="hidden" x-ref="actionInput">

        <a class="flex-grow rounded border px-4 py-2 text-center hover:bg-red-500 hover:text-white"
          href="{{ route('board.index') }}">
          削除
        </a>
      </div>
    </form>
  </x-widget>
</x-app-layout>
