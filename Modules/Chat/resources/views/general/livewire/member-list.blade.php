<div class="mb-10 mt-[50px] sm:mb-0">
  <div class="mb-6 text-[11px] font-bold sm:mb-[7px]">グループ一覧</div>
  @foreach ($this->groups->where('is_dm', false) as $group)
    <a href="{{ route('chat.show', ['group' => $group]) }}" @class([
        'grid grid-cols-[30px,auto,30px] sm:py-2 py-[20px] rounded gap-1 my-1 sm:border-none border-b sm:-mx-0 -mx-[15px] sm:px-0 px-[20px]',
        'bg-[#3289FA1A] bg-opacity-10 border border-[#3289FA]' =>
            $selectGroup->id == $group->id,
    ]) @click="mobileTalkArea=true">
      <div class="flex items-center justify-center">
        @if ($group->IconImage)
          <img class="h-[25px] w-[25px] rounded-full border bg-white" src="{{ $group->IconImage }}" alt="アイコン">
        @else
          <div class="flex h-[25px] w-[25px] items-center justify-center rounded-full border bg-white"><i
              class="fa-solid fa-image"></i>
          </div>
        @endif
      </div>
      <div class="truncate text-[15px] font-semibold">{{ $group->name }}</div>
      <div class="flex items-center justify-center">
        @if ($group->group_notification_count)
          <div
            class="flex h-[18px] w-[18px] items-center justify-center rounded-full bg-[#FF4A62] text-[9px] font-bold text-white">
            {{ $group->group_notification_count }}
          </div>
        @endif
      </div>
    </a>
  @endforeach

  <div class="mb-6 mt-[60px] text-[11px] font-bold sm:mb-[7px]">メンバー</div>
  @foreach ($this->groups->where('is_dm', true) as $group)
    <a href="{{ route('chat.show', ['group' => $group]) }}" a @class([
        'grid grid-cols-[30px,auto,30px] sm:py-2 py-[20px] rounded gap-1 my-1 sm:border-none border-b sm:-mx-0 -mx-[15px] sm:px-0 px-[20px]',
        'bg-[#3289FA1A] bg-opacity-10 border border-[#3289FA]' =>
            $selectGroup->id == $group->id,
    ]) @click="mobileTalkArea=true">
      <div class="flex items-center justify-center">
        @if ($group->IconImage)
          <img class="h-[25px] w-[25px] rounded-full border bg-white" src="{{ $group->IconImage }}" alt="アイコン">
        @else
          <div class="flex h-[25px] w-[25px] items-center justify-center rounded-full border bg-white"><i
              class="fa-solid fa-image"></i>
          </div>
        @endif
      </div>
      <div class="truncate text-[15px] font-semibold">{{ $group->NameLabel }}</div>
      <div class="flex items-center justify-center">
        @if ($group->group_notification_count)
          <div
            class="flex h-[18px] w-[18px] items-center justify-center rounded-full bg-[#FF4A62] text-[9px] font-bold text-white">
            {{ $group->group_notification_count }}
          </div>
        @endif
      </div>
    </a>
  @endforeach
</div>
