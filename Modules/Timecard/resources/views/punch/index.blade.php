<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
  @livewireStyles
</head>

<body class="flex h-full w-full flex-row bg-[#F7F7F7]">
  <div class="grid min-w-[300px] max-w-[300px] grid-rows-[20%,80%] bg-[#363B46]">
    <div class="flex flex-col items-center justify-center">
      <div class="flex min-w-[60px] max-w-[60px] items-center justify-center"><svg width="74" height="60"
          viewBox="0 0 74 60" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M14.8692 12.6679H25.1277V0H12.6791C5.70561 0 0 5.70058 0 12.6679V31.3244C0 38.2917 5.70561 43.9923 12.6791 43.9923H25.1277V31.785H14.8692C13.6589 31.785 12.6791 30.8061 12.6791 29.5969V29.1363C12.6791 27.9271 13.6589 26.9482 14.8692 26.9482H24.2056V17.5048H14.8692C13.6589 17.5048 12.6791 16.5259 12.6791 15.3167V14.856C12.6791 13.6468 13.6589 12.6679 14.8692 12.6679Z"
            fill="white" />
          <path
            d="M61.5509 0V30.5182C61.5509 31.5939 60.6679 32.476 59.5914 32.476C58.5148 32.476 57.6319 31.5939 57.6319 30.5182V0H44.4917V30.5182C44.4917 31.5939 43.6088 32.476 42.5322 32.476C41.4556 32.476 40.5727 31.5939 40.5727 30.5182V0H28.3546V33.6276C28.3546 40.215 33.749 45.6046 40.3422 45.6046C45.1095 45.6046 49.2498 42.7854 51.177 38.734C53.1043 42.7854 57.2446 45.6046 62.0119 45.6046C68.6051 45.6046 73.9995 40.215 73.9995 33.6276V0H61.5509Z"
            fill="white" />
          <path
            d="M38.6771 52.5142V57.4616C38.6771 57.6366 38.4926 57.7794 38.269 57.7794C38.0454 57.7794 37.861 57.6366 37.861 57.4616V52.5142H35.1269V57.4616C35.1269 57.6366 34.9425 57.7794 34.7189 57.7794C34.4952 57.7794 34.3108 57.6366 34.3108 57.4616V52.5142H31.7704V57.9637C31.7704 59.0324 32.8931 59.9053 34.2647 59.9053C35.256 59.9053 36.1182 59.4493 36.5193 58.7906C36.9204 59.447 37.7803 59.9053 38.7739 59.9053C40.1455 59.9053 41.2682 59.0324 41.2682 57.9637V52.5142H38.6794H38.6771Z"
            fill="white" />
          <path
            d="M49.1028 52.5142C47.0649 52.5142 45.4143 54.1633 45.4143 56.1994C45.4143 58.2355 47.0649 59.8846 49.1028 59.8846C51.1407 59.8846 52.7913 58.2355 52.7913 56.1994C52.7913 54.1633 51.1407 52.5142 49.1028 52.5142ZM49.0843 57.655C48.2752 57.655 47.6182 56.9986 47.6182 56.1902C47.6182 55.3817 48.2752 54.7253 49.0843 54.7253C49.8935 54.7253 50.5505 55.3817 50.5505 56.1902C50.5505 56.9986 49.8935 57.655 49.0843 57.655Z"
            fill="white" />
          <path
            d="M25.1266 52.5142V56.8144C25.1266 57.3234 24.7139 57.7357 24.2045 57.7357C23.695 57.7357 23.2823 57.3234 23.2823 56.8144V52.5142H21.2076V57.1207C21.2076 58.6408 22.4524 59.8846 23.9739 59.8846H24.435C25.9565 59.8846 27.2014 58.6408 27.2014 57.1207V52.5142H25.1266Z"
            fill="white" stroke="white" stroke-miterlimit="10" />
          <path
            d="M15.6768 52.5142C14.4043 52.5142 13.3715 53.546 13.3715 54.8174V59.8846H15.4463V55.9691C15.4463 55.3334 15.9627 54.8174 16.5989 54.8174H17.2905V52.5142H15.6768Z"
            fill="white" stroke="white" stroke-miterlimit="10" />
          <path
            d="M59.9371 52.5142C58.6646 52.5142 57.6318 53.546 57.6318 54.8174V59.8846H59.7066V55.9691C59.7066 55.3334 60.223 54.8174 60.8593 54.8174H61.5508V52.5142H59.9371Z"
            fill="white" stroke="white" stroke-miterlimit="10" />
          <path
            d="M71.0037 59.8848H73.77L69.7588 54.836L72.6773 52.5927L69.851 52.5143L67.7762 54.0921V50.4414H65.7015V59.8848H67.7762V56.3608L68.1059 56.1074L71.0037 59.8848Z"
            fill="white" />
          <path
            d="M5.59077 50.4414C4.28598 50.4414 3.22784 51.4986 3.22784 52.8023V57.5239C3.22784 58.8276 4.28598 59.8848 5.59077 59.8848H8.53003V57.8118H6.22473C5.84205 57.8118 5.53314 57.5032 5.53314 57.1209C5.53314 56.7385 5.84205 56.4299 6.22473 56.4299H8.2995V54.5873H6.22473C5.84205 54.5873 5.53314 54.2786 5.53314 53.8963C5.53314 53.514 5.84205 53.2053 6.22473 53.2053H8.53003V50.4414H5.59077Z"
            fill="white" />
        </svg>
      </div>
      <div class="mt-5 text-xl font-bold text-white">勤怠打刻</div>
    </div>
    <div class="h-full flex-1 overflow-y-auto pb-4">
      <div class="grid grid-cols-[70%,30%] px-[20px]">
        <div class="text-[11px] font-bold text-[#FFFFFF]">メンバー</div>
        <div class="text-end text-[11px] font-bold text-[#FFFFFF]">ステータス</div>
      </div>
      <div class="flex flex-col space-y-[10px] pl-[10px]">
        @foreach ($users as $user)
          <livewire:timecard::punch.member :$user :$selectUser :key="'member-' . $user->id" />
        @endforeach
      </div>
    </div>
  </div>
  <div class="flex w-[75%] items-center justify-center">
    @if ($selectUser)
      <livewire:timecard::punch.punch :user="$selectUser" />
    @endif
  </div>
  @livewireScripts
  <script>
    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.getRegistrations().then(function(registrations) {
        for (let registration of registrations) {
          registration.unregister();
        }
      });
    }
  </script>
</body>

</html>
