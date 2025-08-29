<div>
  <div class="flex items-center justify-between">
    <h5 class="hidden text-xl font-bold sm:block">時給詳細</h5>
    <div><livewire:hourlyrate::hourly-rate-create :$user :key="$user->id" /></div>
  </div>
  <div class="mt-[10px] flex items-center space-x-[20px] border-b py-[20px]">
    <div
      class="flex h-[45px] w-[45px] items-center justify-center overflow-hidden rounded-full bg-gray-200 text-3xl text-gray-800">
      @if ($user->icon)
        <img class="h-full w-full object-cover" src="{{ $user->icon }}">
      @else
        <div class="flex h-full w-full items-center justify-center rounded-full border bg-white"><i
            class="fa-solid fa-image"></i>
        </div>
      @endif
    </div>
    <div class="truncate text-[20px] font-bold">{{ $user->profile?->name }}</div>
  </div>

  <div class="mt-[30px] hidden grid-cols-[30%,30%,30%,10%] sm:grid">
    <div class="pl-[20px] pr-[30px] text-left text-xs font-normal text-[#AAB0B6]">時給</div>
    <div class="text-left text-xs font-normal text-[#AAB0B6]">適用開始日</div>
    <div class="text-left text-xs font-normal text-[#AAB0B6]"></div>
    <div class="text-left text-xs font-normal text-[#AAB0B6]"></div>
  </div>
  <div class="mt-[24px] rounded-lg border-b sm:-mx-0 sm:mt-[8px] sm:border">
    @foreach ($this->rateTable as $hourlyRate)
      <div @class([
          'hidden grid-cols-[30%,30%,30%,10%] py-[30px] sm:grid',
          'border-b' => !$loop->last,
      ])>
        <div class="pl-[20px] pr-[30px] text-[15px] font-bold">{{ $hourlyRate->rate }}円</div>
        <div class="text-left text-[15px]">{{ $hourlyRate->effective_date->format('Y年m月d日') }}</div>
        <div class="w-fit rounded bg-[#3289FA1A] bg-opacity-10 px-[12px] py-[5px] text-xs font-bold text-[#3289FA]">
          適用中
        </div>
        <div class="text-left">
          <livewire:hourlyrate::hourly-rate-edit :$hourlyRate :key="$hourlyRate->id" />

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
        </div>
      </div>
    @endforeach
  </div>
</div>
