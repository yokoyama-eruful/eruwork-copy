@extends('central.layouts.app', ['title' => 'ホーム'])

@section('body')
  <div class="flex h-full w-5/6 flex-col">
    <main class="flex-1 p-10">
      @if (session('success'))
        <div class="rounded bg-green-500 p-4 text-white">
          {{ session('success') }}
        </div>
      @endif

      @if (session('error'))
        <div class="rounded bg-red-500 p-4 text-white">
          {{ session('error') }}
        </div>
      @endif

      <div class="mb-3 flex flex-row items-center justify-between">
        <div class="pl-5 text-2xl font-bold">
          ホーム
        </div>
        <form class="my-1 flex justify-end" action="{{ route('central.search') }}">
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
              <td class="px-6 py-4 text-right">
                <a class="font-medium text-blue-600 hover:underline dark:text-blue-500"
                  href="{{ route('central.show', ['id' => $tenant->id]) }}">詳細</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div class="flex h-10 items-center justify-center">{{ $tenants->links() }}</div>
    </main>
  </div>
@endsection
