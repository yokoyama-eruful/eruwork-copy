<div>
  @foreach ($groups as $group)
    <a href="{{ route('chat.show', ['group' => $group]) }}" @class([
        'flex cursor-pointer items-center border px-2 py-1 hover:bg-gray-100',
        'bg-gray-100' => $selectGroup->id == $group->id,
    ])>
      <div class="mr-2 w-1/6">
        <img class="h-8 w-8 rounded-full border" src="{{ $group->IconImage }}" src="icon.png">
      </div>
      <div class="min-w-0 flex-1">
        <div class="truncate font-semibold">{{ $group->name }}</div>
        <div class="truncate text-sm text-gray-500">最終メッセージ</div>
      </div>
      <div class="flex w-1/6 flex-col items-center">
        <div class="text-xs text-gray-500">01/01</div>
        <div class="inline-block h-4 w-4 rounded-full bg-red-500 text-center text-xs text-white">1</div>
      </div>
    </a>
  @endforeach
</div>
