@extends('central.layouts.app', ['title' => '作成'])

@section('body')
  <div class="flex h-full w-5/6 flex-col">
    <main class="flex-1 p-2">
      <h1 class="mt-3 text-center text-xl font-bold">{{ $tenant->name }}の編集</h1>
      <form class="m-5 flex flex-col space-y-5" action="{{ route('central.update', ['id' => $tenant->id]) }}" method="POST">
        @csrf
        <div>
          <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="facility-icon">施設名</label>
          <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5">
              <i class="fa-solid fa-store"></i>
            </div>
            <input
              class="@error('name') border-red-500 @else border-gray-300 @enderror block w-full rounded-lg border bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
              id="facility-icon" name="name" type="text" value="{{ old('name', $tenant->name) }}"
              placeholder="えるふる">
          </div>
          @error('name')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>
        <div>
          <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="phone-icon">電話番号</label>
          <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5">
              <i class="fa-solid fa-phone"></i>
            </div>
            <input
              class="@error('phone_number') border-red-500 @else border-gray-300 @enderror block w-full rounded-lg border bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
              id="phone-icon" name="phone_number" type="text" value="{{ old('phone_number', $tenant->phone_number) }}"
              placeholder="00000000000">
          </div>
          @error('phone_number')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>
        <div>
          <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="facility-icon">メールアドレス</label>
          <div class="relative">
            <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5">
              <i class="fa-regular fa-envelope"></i>
            </div>
            <input
              class="@error('email') border-red-500 @else border-gray-300 @enderror block w-full rounded-lg border bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
              id="facility-icon" name="email" type="text" value="{{ old('email', $tenant->email) }}"
              placeholder="sample@sample.com">
          </div>
          @error('email')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <button class="mx-auto rounded bg-blue-500 px-4 py-2 hover:bg-blue-600" type="submit">更新</button>
      </form>
    </main>
  </div>
@endsection
