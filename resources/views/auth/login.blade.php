<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
  <div class="flex min-h-screen flex-col items-center justify-center bg-[#F7F7F7] pt-6 lg:pt-0">

    <div
      class="mt-6 w-[90%] overflow-hidden rounded-xl bg-white py-4 shadow-[0px_4px_13px_rgba(93,95,98,0.15)] lg:w-[400px] lg:max-w-md">
      <div class="flex items-center justify-center pb-12 pt-10">
        <a href="/login">
          <img class="w-[68px] fill-current text-gray-500" src="{{ url('images/logo/eruwork_blue_logo.png') }}"
            alt="eruworkロゴ">
        </a>
      </div>
      <form class="flex w-full flex-col items-center" method="POST" action="{{ route('login') }}">
        @csrf

        <div class="grid w-full grid-cols-[25%,75%] items-center px-[20px] lg:grid-cols-[22%,78%] lg:px-[30px]">
          <x-input-label for="login_id" :value="__('login_id')" />
          <x-text-input class="mt-1 block w-full placeholder:text-[14px]" id="login_id" name="login_id" type="text"
            :value="old('name')" placeholder="IDを入力してください" required />
          <x-input-error class="mt-2" :messages="$errors->get('login_id')" />
        </div>
        <div class="mt-5 grid w-full grid-cols-[25%,75%] items-center px-[20px] lg:grid-cols-[22%,78%] lg:px-[30px]">
          <x-input-label for="password" :value="__('Password')" />

          <x-text-input class="mt-1 block w-full placeholder:text-[14px]" id="password" name="password" type="password"
            required autocomplete="current-password" placeholder="パスワードを入力してください" />

          <x-input-error class="mt-2" :messages="$errors->get('password')" />
        </div>
        <button class="my-10 h-[45px] w-[230px] rounded bg-[#3289FA] font-bold text-white hover:opacity-40"
          type="submit">ログイン</button>
      </form>
    </div>
  </div>
</body>

</html>
