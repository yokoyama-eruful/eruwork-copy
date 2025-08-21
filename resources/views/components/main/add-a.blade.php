<a
  {{ $attributes->merge([
      'class' =>
          'flex h-[35px] items-center rounded-[5px] bg-[#3289fa] px-5 py-2 text-sm font-bold text-[#fff] hover:bg-[#3289fa4d]',
  ]) }}>
  <img class="mr-[5px] h-[14px] w-[14px]" src="img/icon/add-schedule.png" />
  {{ $slot }}
</a>
