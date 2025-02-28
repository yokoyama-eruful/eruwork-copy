<x-app-layout>
  <x-widget>
    <div x-data="{ isEditable: false }">
      <div x-data="editor('{{ addslashes(old('contents', $post->contents ?? '')) }}')">
        @if ($post->status == false)
          <p class="flex justify-center font-bold">下書き</p>
        @endif

        <div>
          <div class="flex flex-row space-x-5">
            <div>
              <label class="block text-sm font-medium text-gray-700">作成者</label>
              <div class="mb-2 block w-full border-b text-gray-900">
                {{ $post->user->name ?? 'UnknownUser' }}
              </div>
            </div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700" for="title">タイトル</label>
            <div
              class="block w-full border border-gray-300 bg-gray-50 p-2.5 text-lg text-gray-900 focus:border-blue-500 focus:ring-blue-500">
              {{ $post->title }}
            </div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700" for="contents">本文</label>
            <div class="border border-gray-300 bg-gray-50 p-1">
              <div class="m-2" x-ref="element" readonly></div>
            </div>
          </div>
          <div>
            <livewire:board::download, post={{ $post }} canBeDeleted = "false" />
            {{-- @livewire('Board.FileDownloader', ['post' => $post, 'canBeDeleted' => false]) --}}
            @error('file')
              <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>
          {{-- @livewire('Board.LikeButton', ['postID' => $post->id]) --}}
          <div class="mx-52 mt-10 flex flex-row justify-center space-x-5">
            @if ($post->canEdit())
              <a class="flex-grow rounded bg-ao-main px-4 py-2 text-center text-white hover:bg-sky-700" name="action"
                type="submit" href="{{ route('board.edit', ['board' => $post->id]) }}" value="post">
                編集する
              </a>
            @endif

            <a class="flex-grow rounded border px-4 py-2 text-center hover:bg-sky-500 hover:text-white"
              href="{{ route('board.index') }}">
              戻る
            </a>

            @if ($post->canEdit())
              <form class="flex-grow rounded border px-4 py-2 text-center hover:bg-red-500 hover:text-white"
                action="{{ route('board.destroy', ['board' => $post->id]) }}" method="POST"
                onsubmit="return confirm('本当に削除しますか？');">
                @csrf
                @method('DELETE')
                <button class="h-full w-full" type="submit">
                  削除する
                </button>
              </form>
            @endif
          </div>
        </div>
      </div>
    </div>
  </x-widget>
</x-app-layout>
