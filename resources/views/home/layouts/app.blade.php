<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link href="https://fonts.bunny.net" rel="preconnect">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex h-screen flex-col bg-gray-100">

  @include('home.layouts.navigation')

  <div class="flex flex-1">

    <aside class="hidden w-60 border py-4 pr-4 xl:block">
      @include('home.layouts.sidemenu')
    </aside>

    <main class="flex-1 xl:p-4">
      {{ $slot }}
    </main>

  </div>

</body>

</html>
