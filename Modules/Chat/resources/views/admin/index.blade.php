<x-dashboard-layout>
  <x-widget>
    <div class="flex flex-wrap items-center justify-between pb-2">
      <div class="flex flex-row items-center space-x-2 py-1">
        <div class="h-auto self-stretch border-l-4 border-hai-main"></div>
        <div class="text-lg font-bold">チャット管理</div>
      </div>
      <a class="flex cursor-pointer items-center space-x-1 rounded border border-hai-main px-6 py-1 text-base font-medium hover:bg-gray-200"
        href="{{ route('chatManager.create') }}">
        <span>グループを追加する</span>
        <i class="fa-solid fa-plus rounded-full bg-ao-sub p-1 text-hai-main"></i>
      </a>
    </div>
    <table class="min-w-full bg-white">
      <thead>
        <tr class="border-t-ao-dash border-t-4 bg-ao-sub text-left">
          <th class="px-4 py-3 text-left">アイコン</th>
          <th class="min-w-[150px] px-4 py-3 text-left">グループ名</th>
          <th class="min-w-[200px] px-4 py-3 text-left">メンバー</th>
          <th class="min-w-[150px] px-4 py-3 text-right">作成時</th>
          <th class="min-w-[150px] px-4 py-3 text-right">更新日</th>
          <th class="max-w-[100px] px-4 py-2 text-left text-gray-600"></th>
          <th class="max-w-[100px] px-4 py-2 text-left text-gray-600"></th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200">
        @foreach ($groups as $group)
          <tr class="transition-colors duration-200 hover:bg-gray-50">
            <td class="px-4 py-3 text-xl text-gray-700">
              <div
                class="flex h-12 w-12 items-center justify-center overflow-hidden rounded-full bg-gray-200 text-3xl text-gray-800">
                @if ($group->icon)
                  <img class="h-full w-full object-cover" src="{{ $group->icon }}">
                @else
                  <div class="flex h-8 w-8 items-center justify-center rounded-full border bg-white"><i
                      class="fa-solid fa-image"></i>
                  </div>
                @endif
              </div>
            </td>
            <td class="px-4 py-3 text-gray-700">{{ $group->name }}</td>
            <td class="px-4 py-3 text-gray-700">{{ $group->users->implode('name', '、') }}</td>
            <td class="px-4 py-3 text-right text-gray-700">
              {{ $group->created_at->format('Y年') }}<br>
              {{ $group->created_at->format('n月d日') }}
            </td>
            <td class="px-4 py-3 text-right text-gray-700">
              {{ $group->updated_at->format('Y年') }}<br>
              {{ $group->updated_at->format('n月d日') }}
            </td>
            <td class="px-4 py-3 text-right">
              <a class="inline-block rounded px-2 py-2 font-semibold text-hai-main hover:bg-green-600 hover:text-white"
                href="{{ route('chatManager.edit', ['group' => $group]) }}">
                <div class="flex items-center space-x-1">
                  <div>編集</div>
                  <i class="fa-solid fa-pen-to-square"></i>
                </div>
              </a>
            </td>
            <td class="px-4 py-3 text-right">
              <form method="POST" action="{{ route('chatManager.destroy', ['group' => $group]) }}">
                @csrf
                @method('delete')
                <button
                  class="inline-block rounded px-2 py-2 font-semibold text-hai-main hover:bg-red-600 hover:text-white"
                  type="submit" onclick='return confirm("本当に削除しますか")'>
                  削除
                  <i class="fa-solid fa-trash me-1"></i>
                </button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </x-widget>
</x-dashboard-layout>
