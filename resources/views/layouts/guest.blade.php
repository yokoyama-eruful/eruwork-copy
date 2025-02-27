<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>
  @laravelPWA
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
  <div
    class="flex min-h-screen flex-col items-center bg-gradient-to-b from-sky-400 via-sky-200 to-sky-50 pt-6 sm:justify-center sm:pt-0">

    <div class="mt-6 w-80 overflow-hidden rounded-lg bg-white px-6 py-4 shadow-md sm:max-w-md">
      <div class="flex items-center justify-center pb-20 pt-10">
        <a href="/">
          <x-application-logo class="h-20 w-20 fill-current text-gray-500" />
        </a>
      </div>
      {{ $slot }}
    </div>
  </div>
</body>

</html>
