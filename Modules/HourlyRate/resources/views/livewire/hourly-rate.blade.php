<div class="flex h-screen w-full xl:h-full xl:flex-row xl:space-x-10">
  <div class="hidden h-full w-1/2 min-w-96 xl:block">
    <div>
      <div class="h-[5%] font-bold">時給一覧</div>
      <div class="h-[95%] min-w-full bg-white">
        <div class="border-t-ao-dash sticky top-0 z-10 h-[6%] w-full border-t-4 bg-ao-sub text-left">
          <div class="flex">
            <div class="w-3/6 px-4 py-2 text-left text-gray-600">名　前</div>
            <div class="w-2/6 px-4 py-2 text-left text-gray-600">時　給</div>
            <div class="w-1/6 px-4 py-2 text-left text-gray-600"></div>
          </div>
        </div>
        <div class="h-[94%] w-full overflow-y-auto">
          @foreach ($this->users as $user)
            <div class="flex w-full items-center border-b">
              <div class="w-3/6 px-4 py-2">{{ $user->name }}</div>
              <div class="w-2/6 px-4 py-2">{{ $user->latestHourlyRate ? $user->latestHourlyRate . '円' : '----' }}</div>
              <div class="flex w-1/6 justify-end px-4 py-3">
                <button class="flex items-center rounded bg-gray-200 px-5 hover:bg-green-600 hover:text-white md:py-2"
                  wire:click="selectUser('{{ $user->id }}')">
                  表示
                </button>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

  <script>
    function Datepickr() {
      return {
        initDatepickr() {
          flatpickr('.js-datepicker', {
            locale: {
              ...flatpickr.l10ns.ja,
              "firstDayOfWeek": 1
            },
            dateFormat: "Y-m-d",
            disableMobile: "true",
            static: false,
          });
        }
      }
    }
  </script>

  <div class="relative block w-full xl:hidden" x-data="{ show: false }" @user-selected.window="show = true">
    @foreach ($this->users as $user)
      <div class="flex w-full flex-wrap items-center justify-between border-b py-2">
        <div>{{ $user->name }}</div>
        <div>{{ $user->latestHourlyRate ? $user->latestHourlyRate . '円' : '----' }}</div>
        <button class="flex items-center rounded bg-gray-200 px-5 hover:bg-green-600 hover:text-white md:py-2"
          wire:click="selectUser('{{ $user->id }}'); $dispatch('user-selected')">
          表示
        </button>
      </div>
    @endforeach

    <div class="absolute inset-0 bg-white shadow-lg transition-all duration-300 ease-in-out" x-show="show"
      x-transition:enter="-translate-x-full opacity-0" x-transition:enter-start="-translate-x-full opacity-0"
      x-transition:enter-end="translate-x-0 opacity-100" x-transition:leave="translate-x-0 opacity-0"
      x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="-translate-x-full opacity-0" x-cloak>
      <div class="flex flex-row hover:text-ao-main" wire:click="refreshUser()" x-on:click="show=false">
        <i class="fa-solid fa-chevron-left"></i>
        <div>一覧へ</div>
      </div>
      @isset($selectedUser)
        <livewire:hourlyrate::hourly-rate-show :$selectedUser :key="$selectedId . now()->format('YmdHis')" />
      @endisset
    </div>

  </div>

  <!-- 右側の部分 -->
  <div class="hidden w-1/2 min-w-96 xl:block">
    @isset($selectedUser)
      <livewire:hourlyrate::hourly-rate-show :$selectedUser :key="$selectedId" />
    @endisset
  </div>
</div>
