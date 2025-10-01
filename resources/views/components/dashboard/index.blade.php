<main {{ $attributes->class('h-[calc(100vh-50px)] sm:h-screen flex-1 overflow-auto sm:bg-[#f4f4f4] bg-white sm:p-6') }}>
  <div
    class="fixed flex h-[45px] w-full flex-row items-center space-x-2 overflow-x-auto bg-[#3D475D] px-5 py-[5px] sm:hidden">
    <a href="{{ route('shiftManager.index') }}" @class([
        'flex h-full min-w-fit items-center justify-center rounded px-2 py-3 text-xs text-white',
        'bg-[#3289FA]' => request()->routeIs('shiftManager.*'),
        ' bg-[#FFFFFF1A] bg-opacity-10' => !request()->routeIs('shiftManager.*'),
    ])>
      シフト表管理</a>

    <a href="{{ route('timecardManager.index') }}" @class([
        'flex h-full min-w-fit items-center justify-center rounded px-2 py-3 text-xs text-white',
        'bg-[#3289FA]' => request()->routeIs('timecardManager.*'),
        ' bg-[#FFFFFF1A] bg-opacity-10' => !request()->routeIs('timecardManager.*'),
    ])>
      タイムカード管理</a>

    <a href="{{ route('account.index') }}" @class([
        'flex h-full min-w-fit items-center justify-center rounded px-2 py-3 text-xs text-white',
        'bg-[#3289FA]' => request()->routeIs('account.*'),
        ' bg-[#FFFFFF1A] bg-opacity-10' => !request()->routeIs('account.*'),
    ])>
      アカウント管理</a>

    <a href="{{ route('hourlyRate.index') }}" @class([
        'flex h-full min-w-fit items-center justify-center rounded px-2 py-3 text-xs text-white',
        'bg-[#3289FA]' => request()->routeIs('hourlyRate.*'),
        ' bg-[#FFFFFF1A] bg-opacity-10' => !request()->routeIs('hourlyRate.*'),
    ])>
      時給管理</a>

    <a href="{{ route('attendanceManager.index') }}" @class([
        'flex h-full min-w-fit items-center justify-center rounded px-2 py-3 text-xs text-white',
        'bg-[#3289FA]' => request()->routeIs('attendanceManager.*'),
        ' bg-[#FFFFFF1A] bg-opacity-10' => !request()->routeIs(
            'attendanceManager.*'),
    ])>
      勤怠管理</a>

    <a href="{{ route('chatManager.index') }}" @class([
        'flex h-full min-w-fit items-center justify-center rounded px-2 py-3 text-xs text-white',
        'bg-[#3289FA]' => request()->routeIs('chatManager.*'),
        ' bg-[#FFFFFF1A] bg-opacity-10' => !request()->routeIs('chatManager.*'),
    ])>
      チャット管理</a>

    <a href="{{ route('manualFolderManager.index') }}" @class([
        'flex h-full min-w-fit items-center justify-center rounded px-2 py-3 text-xs text-white',
        'bg-[#3289FA]' =>
            request()->routeIs('manualFolderManager.*') |
            request()->routeIs('manualFileManager.*'),
        ' bg-[#FFFFFF1A] bg-opacity-10' =>
            !request()->routeIs('manualFolderManager.*') &&
            !request()->routeIs('manualFileManager.*'),
    ])>
      マニュアル管理</a>

  </div>

  {{ $slot }}
</main>
