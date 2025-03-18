<x-widget>
  <div class="mt-5 overflow-y-auto">
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
              onclick="window.location.href='{{ route('board.show', ['id' => $post->id]) }}'">
              <td class="border-b border-ao-main py-2 text-center sm:w-7">
                @if ($post->attachments->isNotEmpty())
                  <i class="fas fa-paperclip mx-1 text-blue-700"></i>
                @endif
              </td>
              <td @class([
                  'sm:max-w-xs truncate border-b border-ao-main py-2 truncate max-w-20 sm:pr-4 text-blue-500 underline',
                  'text-gray-400' => $post->ReadStatus != null,
              ])>
                {!! nl2br(e($post->title)) !!}
              </td>
              <td class="border-b border-ao-main px-4 py-2">{{ $post->user->profile->name ?? 'UnknownUser' }}
              </td>
              <td class="border-b border-ao-main px-4 py-2">{{ $post->updated_at?->format('Y/m/d H:i') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>
</x-widget>
