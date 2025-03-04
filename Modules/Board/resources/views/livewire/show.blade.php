<div>
  <div class="overflow-hidden rounded-lg bg-white">
    <div class="flex flex-col items-center py-2 xl:flex-row xl:justify-between">
      <div class="flex w-full flex-row items-center space-x-5 pb-2 xl:w-auto xl:pb-0">
        <a class="inline-block rounded border border-transparent bg-ao-main px-2 py-1 text-white transition duration-300 ease-in-out hover:bg-sky-600 hover:text-gray-100"
          href="{{ route('board.create') }}">
          <div class="flex flex-row items-center justify-center space-x-3">
            <i class="fa-solid fa-plus"></i>
            <p>新規投稿</p>
          </div>
        </a>
        <a class="inline-block rounded border border-transparent bg-ao-main px-2 py-1 text-white transition duration-300 ease-in-out hover:bg-sky-600 hover:text-gray-100"
          href="{{ route('draft.index') }}">
          <div class="flex flex-row items-center justify-center space-x-3">
            <i class="fa-solid fa-check"></i>
            <p>下書き一覧</p>
          </div>
        </a>
      </div>
      <div class="w-full xl:w-auto">
        <div class="relative">
          <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
            <i class="fa-solid fa-magnifying-glass h-4 w-4 text-gray-500"></i>
          </div>
          <input
            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
            type="search" wire:model.live="search" placeholder="表題検索..." required />
        </div>
      </div>
    </div>

    @if ($posts->isEmpty())
      <p>投稿はありません</p>
    @else
      <table class="min-w-full table-auto rounded-lg bg-white shadow-lg">
        <thead>
          <tr class="border-t-4 border-t-ao-main bg-ao-sub text-left">
            <th class="py-2 text-left font-medium text-gray-600"></th>
            <th class="py-2 pr-4 text-left font-medium text-gray-600">表題</th>
            <th class="px-4 py-2 text-left font-medium text-gray-600">作成者</th>
            <th class="px-4 py-2 text-left font-medium text-gray-600">作成日</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($posts as $post)
            <tr class='cursor-pointer hover:bg-gray-100'
              onclick="window.location.href='{{ route('board.show', ['board' => $post->id]) }}'">
              <td class="w-7 border-b border-ao-main py-2 text-center">
                @if ($post->attachments->isNotEmpty())
                  <i class="fas fa-paperclip mx-1 text-blue-700"></i>
                @endif
              </td>
              <td @class([
                  'max-w-xs truncate border-b border-ao-main py-2 pr-4 text-blue-500 underline',
                  'text-gray-400' => $post->ReadStatus != null,
              ])>
                {!! nl2br(e($post->title)) !!}
              </td>
              <td class="border-b border-ao-main px-4 py-2">{{ $post->user->profile->name ?? 'UnknownUser' }}</td>
              <td class="border-b border-ao-main px-4 py-2">{{ $post->updated_at?->format('Y/m/d H:i') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>
  <div class="mt-4">
    {{ $posts->links() }}
  </div>
</div>
