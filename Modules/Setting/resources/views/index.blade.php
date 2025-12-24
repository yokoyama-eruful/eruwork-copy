<x-dashboard-layout>
  <x-dashboard.index>
    <x-dashboard.top>
      <h5 class="block text-xl font-bold lg:hidden">各種設定</h5>
    </x-dashboard.top>
    <x-dashboard.container>
      <h5 class="hidden text-xl font-bold lg:block">各種設定</h5>
      <form class="flex h-[calc(var(--vh)*100-190px)] flex-col rounded-xl px-[25px] py-[30px] lg:mt-[30px] lg:border"
        method="POST" action="{{ route('setting.update') }}">
        @csrf
        <div class="font-bold">打刻設定</div>
        <div class="border-b pb-[32px] pt-[26px]">
          <div class="grid grid-cols-[20%,80%] lg:items-center">
            <div class="text-[11px] font-bold">打刻方法</div>
            <div class="flex flex-col items-center space-y-[15px] lg:flex-row lg:space-x-[72px] lg:space-y-0">
              <label class="flex cursor-pointer space-x-2 lg:items-center">
                <input class="mt-1 lg:mt-0" name="rule" type="radio" value="personal"
                  @if ($rule->rule === 'personal') checked @endif />
                <div class="flex flex-col text-sm lg:flex-row lg:text-base">
                  <div>パーソナル打刻</div>
                  <div>（自分のスマホ・PCなどの端末から打刻）</div>
                </div>
              </label>
              <label class="flex cursor-pointer space-x-2 text-sm lg:items-center lg:text-base">
                <input class="mt-1 lg:mt-0" name="rule" type="radio" value="public"
                  @if ($rule->rule === 'public') checked @endif />
                <div class="flex flex-col lg:flex-row">
                  <div>パブリック打刻</div>
                  <div>（1台の端末を全スタッフで共有して打刻）</div>
                </div>
              </label>
            </div>
          </div>
          @if ($rule->rule === 'public')
            <div class="mt-5 grid grid-cols-[20%,80%] lg:items-center">
              <div></div>
              <div class="flex h-[35px] items-center bg-[#F4F4F4] px-[20px]">専用URL:<a class="text-blue-500"
                  href="{{ route('public-timecard.login') }}">　{{ 'https://' . request()->getHost() . '/public-timecard/login' }}</a>
              </div>
            </div>
            <div class="mt-5 grid grid-cols-[20%,80%] lg:items-center">
              <div></div>
              <div class="flex h-[35px] items-center bg-[#F4F4F4] px-[20px]">PIN CODE：{{ $pin }}</div>
            </div>
          @endif
        </div>

        <div class="border-b py-[30px]">
          <div class="font-bold">給与算出設定</div>
          <div class="mt-[30px] grid grid-cols-[20%,80%] items-center">
            <div class="text-[11px] font-bold">時給発生タイミング</div>
            <div class="flex items-center justify-between lg:justify-start lg:space-x-[72px]">
              <label class="flex cursor-pointer items-center space-x-2">
                <input name="pay_unit" type="radio" value="1" @if ($wagePremium->pay_unit === 1) checked @endif />
                <div>1分</div>
              </label>
              <label class="flex cursor-pointer items-center space-x-2">
                <input name="pay_unit" type="radio" value="15" @if ($wagePremium->pay_unit === 15) checked @endif />
                <div>15分</div>
              </label>
              <label class="flex cursor-pointer items-center space-x-2">
                <input name="pay_unit" type="radio" value="30" @if ($wagePremium->pay_unit === 30) checked @endif />
                <div>30分</div>
              </label>
            </div>
          </div>

          <div class="mt-[30px] items-center space-y-2 lg:grid lg:grid-cols-[50%,50%] lg:space-y-0">
            <div class="grid grid-cols-[40%,60%] items-center">
              <div class="text-[11px] font-bold">残業割増設定</div>
              <label class="flex cursor-pointer items-center space-x-2">
                <input class="w-[80px] rounded border-[#DDDDDD] lg:w-[100px]" name="overtimeRate" type="text"
                  value="{{ old('overtimeRate', $wagePremium->overtime_rate) }}" />
                <div>%</div>
              </label>
            </div>
            <div class="grid grid-cols-[40%,60%] items-center">
              <div class="text-[11px] font-bold">深夜割増設定</div>
              <label class="flex cursor-pointer items-center space-x-2">
                <input class="w-[80px] rounded border-[#DDDDDD] lg:w-[100px]" name="nightRate" type="text"
                  value="{{ old('nightRate', $wagePremium->night_rate) }}" />
                <div>%</div>
              </label>
            </div>
          </div>
        </div>
        <div class="flex h-full items-end justify-center">
          <button class="mb-5 h-[45px] w-[150px] rounded bg-[#3289FA] font-bold text-white hover:opacity-40 lg:mb-0"
            type="submit">更新する</button>
        </div>
      </form>
    </x-dashboard.container>
  </x-dashboard.index>
</x-dashboard-layout>
