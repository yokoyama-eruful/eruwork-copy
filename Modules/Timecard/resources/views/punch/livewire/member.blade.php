<a href="{{ route('punch.index', ['user' => $user->id]) }}" @class([
    'grid grid-cols-[70%,30%] rounded-s-[20px] p-[10px]',
    'bg-white' => $user->id === $selectUser?->id,
])>
  <div class="flex items-center space-x-[10px]">
    <div @class([
        'relative flex max-h-[56px] min-h-[56px] min-w-[56px] max-w-[56px] items-center justify-center rounded-full border-[2px] ',
        'border-[#48CBFF]' => in_array('in', $buttonStatus, true) === false,
        'border-[#B7B7B7]' => in_array('out', $buttonStatus, true) === false,
    ])>
      @if ($user->icon)
        <img class="h-[50px] w-[50px] rounded-full object-cover" src="{{ route('profile.icon', ['id' => $user->id]) }}">
      @else
        <div class="flex h-[50px] w-[50px] items-center justify-center rounded-full border bg-white"><i
            class="fa-solid fa-image"></i>
        </div>
      @endif
    </div>
    <div @class([
        'truncate font-bold',
        'text-black' => $user->id === $selectUser?->id,
        'text-white' => $user->id !== $selectUser?->id,
    ])>{{ $user->name }}</div>
  </div>
  @if (in_array('in', $buttonStatus, true) === false)
    <div class="flex items-center justify-center text-[15px] font-bold text-[#48CBFF]">出勤</div>
  @elseif(in_array('out', $buttonStatus, true) === false)
    <div class="flex items-center justify-center text-[15px] font-bold text-[#B7B7B7]">未出勤</div>
  @else
    <div class="flex items-center justify-center text-[15px] text-[#B7B7B7]">未出勤</div>
  @endif
</a>
