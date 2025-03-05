<!doctype html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>コンソール</title>
</head>

<body class="flex h-screen w-full bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-white">
  <div class="mx-auto flex flex-col items-center justify-center p-6 sm:w-96">
    <a class="mb-6 flex items-center text-2xl font-semibold text-gray-900 dark:text-white" href="#">
      EruWork
    </a>
    <div class="w-full rounded-lg bg-white p-6 shadow-lg dark:border dark:border-gray-700 dark:bg-gray-800">
      <div class="space-y-4">
        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
          管理サインイン
        </h1>
        <form class="space-y-4" action="{{ route('central.login') }}" method="POST">
          @csrf
          <div>
            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="email">ID</label>
            <input
              class="@error('login_id') border-red-500 @else border-gray-300 @enderror focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
              id="login_id" name="login_id" type="text" placeholder="エルフル太郎" required>
          </div>
          @error('login_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror
          <div>
            <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white" for="password">パスワード</label>
            <input
              class="@error('password') border-red-500 @else border-gray-300 @enderror focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
              id="password" name="password" type="password" placeholder="••••••••" required>
          </div>
          @error('password')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror

          @error('error')
            <div class="relative rounded border border-red-400 bg-red-100 px-4 py-3 text-red-700" role="alert">
              {{ $message }}
            </div>
          @enderror

          <div class="flex justify-center">
            <button class="text-black hover:text-blue-300 dark:text-white">ログイン</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>
