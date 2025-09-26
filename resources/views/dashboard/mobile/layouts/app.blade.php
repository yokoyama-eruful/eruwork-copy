<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
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

<body class="m-0 grid h-screen w-screen grid-rows-[50px,1fr] p-0" x-data="{ sideMenu: false }" x-cloak>
  @include('dashboard.mobile.layouts.sidemenu')
  <main class="overflow-y-auto">
    {{ $slot }}
  </main>
  @livewireScripts
</body>

</html>
