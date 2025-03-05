<!doctype html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>{{ $title }}</title>
</head>

<body class="flex h-screen w-full bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-white">
  @include('central.layouts.sidemenu')
  @yield('body')
</body>

</html>
