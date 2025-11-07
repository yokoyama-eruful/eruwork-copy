@extends('central.layouts.app', ['title' => 'ホーム'])

@section('body')
  <div class="flex h-full w-5/6 flex-col" x-data="{ confirmDelete: false, restore: false }">
    <main class="flex-1 p-10">
      @error('delete_tenant_id')
        <div class="rounded bg-red-500 p-4 text-white">削除に失敗しました:{{ $message }}</div>
      @enderror

      <div class="mb-3 flex flex-row items-center justify-between">
        <div class="pl-5 text-2xl font-bold">
          ゴミ箱
        </div>
        <form class="my-1 flex justify-end" action="{{ route('central.trash.search') }}">
          <label class="sr-only mb-2 text-sm font-medium text-gray-900 dark:text-white" for="default-search">検索</label>
          <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
              <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <input
              class="block w-96 rounded-lg border border-gray-300 bg-gray-50 p-3 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
              id="default-search" name="word" type="search" placeholder="施設名" required />
            <button
              class="absolute bottom-2.5 end-2.5 rounded-lg bg-blue-700 px-4 py-1 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
              type="submit">検索</button>
          </div>
        </form>
      </div>
      <table class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
        <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th class="px-6 py-3" scope="col">
              ID
            </th>
            <th class="px-6 py-3" scope="col">
              <div class="flex items-center">
                施設名
              </div>
            </th>
            <th class="px-6 py-3" scope="col">
              <div class="flex items-center">
                電話番号
              </div>
            </th>
            <th class="px-6 py-3" scope="col">
              <div class="flex items-center">
                メールアドレス
              </div>
            </th>
            <th class="px-6 py-3" scope="col">
              <span class="sr-only">Edit</span>
            </th>
            <th class="px-6 py-3" scope="col">
              <span class="sr-only">Delete</span>
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach ($tenants as $tenant)
            <tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
              <th class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white" scope="row">
                {{ $tenant->id }}
              </th>
              <th class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white" scope="row">
                {{ $tenant->name }}
                </td>
              <td class="px-6 py-4">
                {{ $tenant->phone_number ?? 'null' }}
              </td>
              <td class="px-6 py-4">
                {{ $tenant->email ?? 'null' }}
              </td>
              <td class="px-4 py-2 text-right">
                <button class="rounded-md border-2 border-green-900 bg-green-600 p-2 hover:bg-green-700" type="button"
                  @click="restore = true">復元</button>

                <div class="fixed inset-0 z-50 flex items-center justify-center bg-black opacity-50" x-show="restore"
                  x-cloak></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center" x-show="restore" x-cloak>
                  <div
                    class="flex h-auto w-96 flex-col items-center justify-center rounded-md border border-gray-200 bg-white p-5 dark:border-white dark:bg-gray-700"
                    @click.away="restore = false">
                    <div class="text-lg"><i class="fa-solid fa-trash-arrow-up text-green"></i> 復元しますか？
                    </div>
                    <form class="mt-5 flex w-full flex-col items-center justify-center"
                      action="{{ route('central.trash.restore', ['id' => $tenant->id]) }}" method="POST">
                      @csrf
                      <div class="mt-5 flex w-full flex-row space-x-5 px-5">
                        <button
                          class="w-1/2 rounded-md border-2 border-gray-900 bg-gray-600 p-2 text-center hover:bg-gray-700"
                          type="button" @click="restore = false">キャンセル</button>

                        <button
                          class="w-1/2 rounded-md border-2 border-green-900 bg-green-600 p-2 text-center hover:bg-green-700"
                          type="submit">復元</button>
                    </form>
                  </div>
                </div>
              </td>
              <td class="px-4 py-2 text-right">
                <button class="rounded-md border-2 border-red-900 bg-red-600 p-2 hover:bg-red-700" type="button"
                  @click="confirmDelete = true">削除</button>

                <div class="fixed inset-0 z-50 flex items-center justify-center bg-black opacity-50"
                  x-show="confirmDelete" x-cloak></div>

                <div class="fixed inset-0 z-50 flex items-center justify-center" x-show="confirmDelete" x-cloak>
                  <div
                    class="flex h-auto w-96 flex-col items-center justify-center rounded-md border border-gray-200 bg-white p-5 dark:border-white dark:bg-gray-700"
                    @click.away="confirmDelete = false">
                    <div class="mb-5 text-lg"><i class="fa-solid fa-triangle-exclamation text-amber-600"></i> 本当に削除しますか？
                    </div>
                    <div class="mb-1 px-5 text-center">
                      <div class="text-2xl font-bold">{{ $tenant->id }}</div>
                      <div class="text-sm">下記に上記文字列を入力して削除ボタンを押すと削除されます。</div>
                    </div>
                    <form class="mt-5 flex w-full flex-col items-center justify-center"
                      action="{{ route('central.trash.delete', ['id' => $tenant->id]) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <input class="rounded border p-2 dark:bg-gray-800" name="delete_tenant_id" placeholder="入力してください">
                      <input name="tenant_id" value="{{ $tenant->id }}" hidden>
                      <div class="mt-5 flex w-full flex-row space-x-5 px-5">
                        <button
                          class="w-1/2 rounded-md border-2 border-gray-900 bg-gray-600 p-2 text-center hover:bg-gray-700"
                          type="button" @click="confirmDelete = false">キャンセル</button>

                        <button
                          class="w-1/2 rounded-md border-2 border-red-900 bg-red-600 p-2 text-center hover:bg-red-700"
                          type="submit">削除</button>
                    </form>
                  </div>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div class="flex h-10 items-center justify-center">{{ $tenants->links() }}</div>
    </main>
  </div>
@endsection
