@extends('central.layouts.app', ['title' => 'ホーム'])

@section('body')
  <div class="flex h-full w-5/6 flex-col" x-data="{ confirmDelete: false }">
    <main class="flex-1 p-10">
      @error('delete_tenant_id')
        <div class="rounded bg-red-500 p-4 text-white">{{ $message }}</div>
      @enderror

      <div class="mb-3 flex flex-row items-center justify-between">
        <div class="pl-5 text-2xl font-bold">
          {{ $tenant->name }}の詳細
        </div>
        <button class="rounded-md border-2 border-red-900 bg-red-600 p-2 hover:bg-red-700" type="button"
          @click="confirmDelete = true">削除</button>
      </div>

      <div class="fixed inset-0 z-50 flex items-center justify-center bg-black opacity-50" x-show="confirmDelete"></div>

      <div class="fixed inset-0 z-50 flex items-center justify-center" x-show="confirmDelete">
        <div
          class="flex h-72 w-96 flex-col items-center justify-center rounded-xl border border-gray-200 bg-white dark:border-white dark:bg-gray-700">
          <div class="mb-5 text-lg">本当に削除しますか？</div>
          <div class="mb-1 px-5 text-center">
            <div class="text-2xl font-bold">{{ $tenant->id }}</div>
            <div class="text-sm">下記に上記文字列を入力して削除ボタンを押すと削除されます。</div>
          </div>
          <form class="mt-5 flex w-full flex-col items-center justify-center"
            action="{{ route('central.delete', ['id' => $tenant->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <input class="rounded border p-2 dark:bg-gray-800" name="delete_tenant_id" placeholder="入力してください">
            <input name="tenant_id" value="{{ $tenant->id }}" hidden>
            <div class="mt-5 flex w-full flex-row space-x-5 px-5">
              <button class="w-1/2 rounded-md border-2 border-gray-900 bg-gray-600 p-2 text-center hover:bg-gray-700"
                type="button" @click="confirmDelete = false">キャンセル</button>

              <button class="w-1/2 rounded-md border-2 border-red-900 bg-red-600 p-2 text-center hover:bg-red-700"
                type="submit">削除</button>
          </form>
        </div>
      </div>
  </div>

  <div class="m-5 flex flex-col space-y-5">
    <div>
      <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="facility-icon">施設名</label>
      <div class="relative">
        <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5">
          <i class="fa-solid fa-store"></i>
        </div>
        <div
          class="block w-full p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
          id="facility-icon">
          {{ $tenant->name }}
        </div>
      </div>
    </div>

    <div>
      <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="facility-icon">電話番号</label>
      <div class="relative">
        <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5">
          <i class="fa-solid fa-phone"></i>
        </div>
        <div
          class="block w-full p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
          id="facility-icon">
          {{ $tenant->phone_number ?? 'null' }}
        </div>
      </div>
    </div>

    <div>
      <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="facility-icon">メールアドレス</label>
      <div class="relative">
        <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5">
          <i class="fa-regular fa-envelope"></i>
        </div>
        <div
          class="block w-full p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
          id="facility-icon">
          {{ $tenant->email ?? 'null' }}
        </div>
      </div>
    </div>

    <div>
      <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="facility-icon">ユーザー数</label>
      <div class="relative">
        <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5">
          <i class="fa-solid fa-users"></i>
        </div>
        <div
          class="block w-full p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
          id="facility-icon">
          {{ $userCount }}人
        </div>
      </div>
    </div>

    <a class="mx-auto cursor-pointer rounded bg-blue-500 px-4 py-2 hover:bg-blue-600"
      href="{{ route('central.edit', ['id' => $tenant->id]) }}">編集</a>
  </div>
  </main>
  </div>
@endsection
