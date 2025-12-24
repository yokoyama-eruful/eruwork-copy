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
      <div class="flex items-center justify-center pb-[30px] pt-10">
        <div>
          <img class="w-[68px] fill-current text-gray-500" src="{{ url('images/logo/eruwork_blue_logo.png') }}"
            alt="eruworkロゴ">
        </div>
      </div>

      <div class="text-center font-bold">パプリック打刻専用ログイン</div>

      <div class="pb-[56px]">
        @error('pin')
          <p class="pt-5 text-center text-red-500">{{ $message }}</p>
        @enderror
      </div>

      <form method="POST" action="{{ route('public-timecard.login.post') }}">
        @csrf

        <div class="mx-[30px] grid grid-cols-[20%,80%] items-center pb-[58px]">
          <label class="text-xs font-bold">PINCODE</label>
          <input class="rounded border border-[#DDDDDD] text-sm" name="pin" type="password" maxlength="4"
            placeholder="PIN CODEを入力してください" inputmode="numeric" required>
        </div>

        <div class="flex items-center justify-center">
          <button class="h-[50px] w-[230px] rounded bg-[#3289FA] font-bold text-white hover:opacity-40" type="submit">
            打刻画面へ
          </button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>
