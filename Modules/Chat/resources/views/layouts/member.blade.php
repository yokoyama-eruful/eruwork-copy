<div class="max-h-[calc(50%-2rem)] overflow-y-auto">
  @foreach ($groups as $group)
    @if (!$group->is_dm)
      <a href="{{ route('chat.show', ['group' => $group]) }}" @class([
          'flex cursor-pointer items-center border px-2 py-1 hover:bg-gray-100',
          'bg-gray-100' => $selectGroup->id == $group->id,
      ])>
        <div class="mr-2 w-1/6">
          @if ($group->IconImage)
            <img class="h-8 w-8 rounded-full border bg-white" src="{{ $group->IconImage }}" alt="アイコン">
          @else
            <div class="flex h-8 w-8 items-center justify-center rounded-full border bg-white"><i
                class="fa-solid fa-image"></i>
            </div>
          @endif
        </div>
        <div class="min-w-0 flex-1">
          <div class="truncate font-semibold">{{ $group->name }}</div>
          <div class="truncate text-sm text-gray-500">{{ strip_tags($group->lastMessage->message ?? '　　　') }}</div>
        </div>
        <div class="flex w-1/6 flex-col items-center">
          <div class="text-xs text-gray-500">{{ $group->lastMessage?->created_at->format('m/d') }}</div>
          <div class="inline-block h-4 w-4 rounded-full bg-red-500 text-center text-xs text-white">1</div>
        </div>
      </a>
    @endif
  @endforeach
</div>

<div class="flex h-8 w-full items-center bg-ao-main px-2 text-white">メンバー</div>

<div class="max-h-[calc(50%-2rem)] overflow-y-auto">
  @foreach ($groups as $group)
    @if ($group->is_dm)
      <a href="{{ route('chat.show', ['group' => $group]) }}" @class([
          'flex cursor-pointer items-center border px-2 py-1 hover:bg-gray-100',
          'bg-gray-100' => $selectGroup->id == $group->id,
      ])>
        <div class="mr-2 w-1/6">
          <img class="h-8 w-8 rounded-full border" src="{{ $group->IconImage }}" src="icon.png">
        </div>
        <div class="min-w-0 flex-1">
          <div class="truncate font-semibold">{{ $group->name }}</div>
          <div class="truncate text-sm text-gray-500">{{ strip_tags($group->lastMessage->message ?? '　　　') }}</div>
        </div>
        <div class="flex w-1/6 flex-col items-center">
          <div class="text-xs text-gray-500">{{ $group->lastMessage?->created_at->format('m/d') }}</div>
          <div class="inline-block h-4 w-4 rounded-full bg-red-500 text-center text-xs text-white">1</div>
        </div>
      </a>
    @endif
  @endforeach
</div>
