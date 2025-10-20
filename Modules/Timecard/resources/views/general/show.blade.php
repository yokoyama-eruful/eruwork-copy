<x-app-layout :url="route('timecard.index')">
  <x-main.index>
    <x-main.top>
    </x-main.top>
    <x-main.container>
      <div class="fixed inset-x-0 bottom-0 top-[50px] z-10 block bg-white px-[15px] pt-[30px] lg:hidden">
        <div class="flex items-center hover:opacity-40">
          <div class="ml-2 text-lg font-bold">扶養控除目安</div>
        </div>

        <div class="mt-[30px] flex items-center justify-between rounded bg-[#F7F7F7] py-2">
          <div class="flex flex-col items-start">
            <div class="flex items-end justify-start ps-4 text-base font-bold">{{ $selectedDate->isoFormat('Y年度') }}
            </div>
            <div class="flex items-start justify-start ps-4 text-[11px]">勤怠時間合計</div>
          </div>
          <div class="row-span-2 flex items-center justify-end pe-[15px] text-2xl font-bold">
            {{ $totalYearWorkingTime }}
          </div>
        </div>

        <div class="mt-5 text-sm font-bold">扶養控除ラインと現在の収入の比較</div>
        <div class="mt-[10px]">
          <div class="-mx-[15px] grid grid-cols-8 text-[10px] text-[#777777]">
            <div class="text-center">0</div>
            <div class="text-center">25</div>
            <div class="text-center">50</div>
            <div class="text-center">75</div>
            <div class="text-center">100</div>
            <div class="text-center">125</div>
            <div class="text-center">150</div>
            <div class="text-center">万円</div>
          </div>
          <div class="relative grid h-[180px] grid-cols-7 overflow-hidden rounded border">
            <!-- グリッド背景 -->
            <div class="border-r"></div>
            <div class="border-r"></div>
            <div class="border-r"></div>
            <div class="border-r"></div>
            <div class="border-r"></div>
            <div class="border-r"></div>
            <div></div>

            <div class="absolute left-0 top-[70px] h-9 rounded-r bg-[#6ed0f7] transition-[width] duration-1000 ease-out"
              style="width: {{ $barWidth }};">
            </div>

            <div
              class="absolute top-10 z-[6] whitespace-nowrap rounded bg-white py-1 pl-[6px] pr-[10px] text-xs font-bold shadow-[0_4px_13px_0_#5D5F6240] transition-[left] duration-1000 ease-out"
              style="left: {{ $barWidth }}; transform: translateX(8px);">
              {{ number_format($totalYearPay) }}円
            </div>

            <hr
              class="absolute left-[58.86%] top-0 z-[5] h-[calc(100%+10px)] border-r-[1.5px] border-dashed border-[#FF4A62]" />
          </div>

        </div>
        <div class="mt-[56px]">
          <div class="text-xs font-bold">あなたの時給から扶養控除目安を算出</div>
          <div class="mt-3 flex flex-col space-y-2">
            <div class="flex items-center justify-between rounded bg-[#F7F7F7] px-[10px] py-[25px]">
              <div class="text-sm font-bold">106万</div>
              <div class="flex items-center space-x-[2px]">
                <div class="text-sm font-bold text-[#FF4A62]">{{ number_format(1060000 - $totalYearPay) }}</div>
                <div class="text-xs">円以上で超過</div>
              </div>
            </div>
            <div class="flex items-center justify-between rounded bg-[#F7F7F7] px-[10px] py-[25px]">
              <div class="text-sm font-bold">130万</div>
              <div class="flex items-center space-x-[2px]">
                <div class="text-sm font-bold text-[#FF4A62]">{{ number_format(1300000 - $totalYearPay) }}</div>
                <div class="text-xs">円以上で超過</div>
              </div>
            </div>
            <div class="flex items-center justify-between rounded bg-[#F7F7F7] px-[10px] py-[25px]">
              <div class="text-sm font-bold">150万</div>
              <div class="flex items-center space-x-[2px]">
                <div class="text-sm font-bold text-[#FF4A62]">{{ number_format(1500000 - $totalYearPay) }}</div>
                <div class="text-xs">円以上で超過</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </x-main.container>
  </x-main.index>
</x-app-layout>
