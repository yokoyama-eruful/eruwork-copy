<div class="h-full w-1/6 border-r border-gray-200">
  <div class="max-h-[calc(50%-2rem)] overflow-y-auto">
    @foreach ($this->groups->where('is_dm', false) as $group)
      <a href="{{ route('chat.show', ['group' => $group]) }}" @class([
          'flex cursor-pointer items-center border px-2 py-1 hover:bg-gray-100',
          'bg-gray-300' => $selectGroup->id == $group->id,
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
          <div class="truncate text-sm text-gray-500">{{ strip_tags($group->lastMessage?->ViewMessage) }}</div>
        </div>
        <div class="flex w-1/6 flex-col items-center">
          <div class="text-xs text-gray-500">{{ $group->lastMessage?->created_at->format('m/d') }}</div>
          @if ($group->group_notification_count)
            <div class="flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs text-white">
              {{ $group->group_notification_count }}
            </div>
          @endif
        </div>
      </a>
    @endforeach
  </div>

  <div class="flex h-8 w-full items-center bg-ao-main px-2 text-white">メンバー</div>

  <div class="max-h-[calc(50%-2rem)] overflow-y-auto">
    @foreach ($this->groups->where('is_dm', true) as $group)
      <a href="{{ route('chat.show', ['group' => $group]) }}" @class([
          'flex cursor-pointer items-center border px-2 py-1 hover:bg-gray-100',
          'bg-gray-300' => $selectGroup->id == $group->id,
      ])>
        <div class="mr-2 w-1/6">
          <img class="h-8 w-8 rounded-full border" src="{{ $group->IconImage }}" src="icon.png">
        </div>
        <div class="min-w-0 flex-1">
          <div class="truncate font-semibold">{{ $group->NameLabel }}</div>
          <div class="truncate text-sm text-gray-500">{{ strip_tags($group->lastMessage?->ViewMessage) }}</div>
        </div>
        <div class="flex w-1/6 flex-col items-center">
          <div class="text-xs text-gray-500">{{ $group->lastMessage?->created_at->format('m/d') }}</div>
          @if ($group->group_notification_count)
            <div class="flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs text-white">
              {{ $group->group_notification_count }}
            </div>
          @endif
        </div>
      </a>
    @endforeach
  </div>
</div>
