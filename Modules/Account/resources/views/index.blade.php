<x-dashboard-layout>
  <x-widget>
    <div class="flex space-x-3 py-2">
      <div class="text-lg font-bold">アカウント一覧</div>
      <a class="flex cursor-pointer items-center space-x-1 rounded border border-hai-main px-6 py-1 text-base font-medium hover:bg-gray-200"
        href="{{ route('account.create') }}">
        <span>アカウントを追加する</span>
        <i class="fa-solid fa-plus rounded-full bg-ao-sub p-1 text-hai-main"></i>
      </a>
    </div>
    <table class="min-w-full bg-white">
      <thead>
        <tr class="border-t-ao-dash border-t-4 bg-ao-sub text-left">
          {{-- <th class="w-24 px-4 py-2 text-left text-gray-600">アイコン</th> --}}
          <th class="px-4 py-2 text-left text-gray-600">名前</th>
          <th class="px-4 py-2 text-left text-gray-600">ログインID</th>
          <th class="px-4 py-2 text-left text-gray-600">契約区分</th>
          <th class="px-4 py-2 text-left text-gray-600">作成日</th>
          <th class="px-4 py-2 text-left text-gray-600">更新日</th>
          <th class="px-4 py-2 text-left text-gray-600">最終ログイン日</th>
          <th class="max-w-24 px-4 py-2 text-left text-gray-600"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
          <tr class="border-b py-2">
            <td class="py-3 ps-5">{{ $user->profile?->name }}</td>
            <td class="py-3 ps-5">{{ $user->login_id }}</td>
            <td class="py-3 ps-5">{{ $user->profile?->contract_type }}</td>
            <td class="px-4 py-3">{{ $user->created_at->isoFormat('YYYY/MM/DD') }}</td>
            <td class="px-4 py-3">{{ $user->updated_at->isoFormat('YYYY/MM/DD') }}</td>
            <td class="px-4 py-3">{{ $user->last_login_at }}</td>
            <td class="flex justify-end px-4 py-3">
              <a class="flex items-center space-x-1 rounded px-2 py-2 font-semibold text-hai-main hover:bg-green-600 hover:text-white"
                href="{{ route('account.edit', ['account' => Auth::user()->login_id]) }}">
                <div>
                  編集
                </div>
                <i class="fa-solid fa-pen-to-square"></i>
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </x-widget>
</x-dashboard-layout>
