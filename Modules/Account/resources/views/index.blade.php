<x-dashboard-layout>
  <x-widget>
    <div class="flex flex-wrap items-center justify-between pb-2">
      <div class="flex flex-row items-center space-x-2 py-1">
        <div class="h-auto self-stretch border-l-4 border-hai-main"></div>
        <div class="text-lg font-bold">アカウント一覧</div>
      </div>
      <a class="flex cursor-pointer items-center space-x-1 rounded border border-hai-main px-6 py-1 text-base font-medium hover:bg-gray-200"
        href="{{ route('account.create') }}">
        <span>アカウントを追加する</span>
        <i class="fa-solid fa-plus rounded-full bg-ao-sub p-1 text-hai-main"></i>
      </a>
    </div>
    <table class="min-w-full bg-white">
      <thead>
        <tr class="border-t-ao-dash border-t-4 bg-ao-sub text-left">
          <th class="px-4 py-2 text-left text-gray-600">名前</th>
          <th class="px-4 py-2 text-left text-gray-600">ログインID</th>
          <th class="px-4 py-2 text-left text-gray-600">契約区分</th>
          <th class="px-4 py-2 text-left text-gray-600">作成日</th>
          <th class="px-4 py-2 text-left text-gray-600">更新日</th>
          <th class="px-4 py-2 text-left text-gray-600">最終ログイン日</th>
          <th class="px-4 py-2 text-left text-gray-600"></th>
          <th class="px-4 py-2 text-left text-gray-600"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
          <tr class="border-b border-gray-200">
            <td class="px-5 py-3">{{ $user->profile?->name }}</td>
            <td class="px-5 py-3">{{ $user->login_id }}</td>
            <td class="px-5 py-3">{{ $user->profile?->contract_type }}</td>
            <td class="px-4 py-3">{{ $user->created_at->isoFormat('YYYY/MM/DD') }}</td>
            <td class="px-4 py-3">{{ $user->updated_at->isoFormat('YYYY/MM/DD') }}</td>
            <td class="px-4 py-3">{{ $user->last_login_at }}</td>
            <td class="px-4 py-3 text-right">
              <a class="inline-block rounded px-2 py-2 font-semibold text-hai-main hover:bg-green-600 hover:text-white"
                href="{{ route('account.edit', ['account' => $user->login_id]) }}">
                <div class="flex items-center space-x-1">
                  <div>編集</div>
                  <i class="fa-solid fa-pen-to-square"></i>
                </div>
              </a>
            </td>
            <td class="px-4 py-3 text-right">
              <form method="POST" action="{{ route('account.destroy', ['account' => $user->login_id]) }}">
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
