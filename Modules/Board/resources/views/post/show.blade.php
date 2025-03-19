<x-app-layout>
  <x-widget>
    <div>
      @if ($post->status == '下書き')
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

            <div class="m-2" x-ref="element" readonly>{!! $post->contents !!}</div>
          </div>
        </div>
        <div>
          <livewire:board::download :post="$post" :canBeDeleted="false" />
          @error('file')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
          @enderror
        </div>
        <livewire:board::like :postId="$post->id" />

        <div class="row mt-10 flex justify-center space-x-5">
          @if ($post->canEdit())
            <a class="inline-flex items-center rounded-md border border-transparent bg-ao-main px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
              name="action" type="submit" href="{{ route('board.edit', ['id' => $post->id]) }}" value="post">
              編集する
            </a>
          @endif

          @if ($post->status == '掲載')
            <a class="inline-flex items-center rounded-md border px-4 py-2 text-xs font-semibold uppercase tracking-widest transition duration-150 ease-in-out hover:bg-gray-700 hover:bg-sky-700 hover:text-white focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
              href="{{ route('board.index') }}">
              戻る
            </a>
          @endif

          @if ($post->status == '下書き')
            <a class="inline-flex items-center rounded-md border px-4 py-2 text-xs font-semibold uppercase tracking-widest transition duration-150 ease-in-out hover:bg-gray-700 hover:bg-sky-700 hover:text-white focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
              href="{{ route('draft.index') }}">
              戻る
            </a>
          @endif

          @if ($post->canEdit())
            <form
              class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 active:bg-red-700"
              action="{{ route('board.destroy', ['id' => $post->id]) }}" method="POST"
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
  </x-widget>
</x-app-layout>
