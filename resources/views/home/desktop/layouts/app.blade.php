<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>
  @laravelPWA
  <!-- Fonts -->
  <link href="https://fonts.bunny.net" rel="preconnect">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <link href="https://fonts.googleapis.com" rel="preconnect" />
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@200..900&display=swap" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/css/common.css', 'resources/js/app.js', 'resources/js/top.js', 'resources/js/notification.js'])
</head>

<body>
  @include('home.desktop.layouts.sidemenu')

  <livewire:profile />

  <x-modal-alert name="logout" title="ログアウト">
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <div class="flex flex-col items-center bg-[#F7F7F7] px-5 pb-8 pt-4 text-left">
        <div class="pt-[13px] text-[15px] font-bold">ログアウトしますか</div>
      </div>
      <div class="my-5 flex items-center justify-center space-x-[10px]">
        <div class="flex h-11 w-[150px] cursor-pointer items-center justify-center rounded border-2"
          @click="$dispatch('close-modal', 'logout')">キャンセル</div>
        <button class="flex h-11 w-[150px] items-center justify-center rounded bg-[#FF4A62] text-white" type="submit">
          ログアウト
        </button>

      </div>
    </form>
  </x-modal-alert>

  <div class="main-area">
    {{ $slot }}
  </div>
  @livewireScripts
</body>

</html>
