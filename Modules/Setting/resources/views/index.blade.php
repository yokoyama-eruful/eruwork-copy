<x-dashboard-layout>
  <x-dashboard.index>
    <x-dashboard.top>
      <h5 class="block text-xl font-bold lg:hidden">各種設定</h5>
    </x-dashboard.top>
    <x-dashboard.container>
      <h5 class="hidden text-xl font-bold lg:block">各種設定</h5>
      <div class="flex flex-col rounded-xl px-[20px] py-[30px] lg:mt-[30px] lg:border lg:px-[25px]">
        <form class="" method="POST" action="{{ route('setting.punch.update') }}">
          @csrf
          <div class="font-bold">打刻設定</div>
          <div class="border-b pb-[32px] pt-[26px]">
            <div class="grid grid-cols-[20%,80%] lg:grid-cols-[180px_minmax(0,1fr)] lg:items-start">
              <div class="text-[0.6875rem] font-bold">打刻方法</div>
              <div class="flex flex-col items-center space-y-[15px] lg:grid lg:grid-cols-2 lg:items-start lg:gap-x-6 lg:gap-y-2 lg:space-y-0">
                <label class="flex cursor-pointer space-x-2 lg:items-start">
                  <input class="mt-[2px]" name="rule" type="radio" value="personal"
                    @if ($rule->rule === 'personal') checked @endif />
                  <div class="flex flex-col text-sm">
                    <div class="text-sm">パーソナル打刻</div>
                    <div class="text-xs">（自分のスマホ・PCなどの端末から打刻）</div>
                  </div>
                </label>
                <label class="flex cursor-pointer space-x-2 text-sm lg:items-start xl:text-base">
                  <input class="mt-[2px]" name="rule" type="radio" value="public"
                    @if ($rule->rule === 'public') checked @endif />
                  <div class="flex flex-col">
                    <div class="text-sm">パブリック打刻</div>
                    <div class="text-xs">（1台の端末を全スタッフで共有して打刻）</div>
                  </div>
                </label>
              </div>
            </div>
            <div>
              @if ($rule->rule === 'public')
                <div class="mt-5 grid-cols-[20%,80%] lg:grid lg:grid-cols-[180px_minmax(0,1fr)] lg:items-center">
                  <div></div>
                  <div class="flex h-[35px] min-w-0 items-center gap-1 rounded bg-[#F4F4F4] px-[8px] py-[1px] text-[12px] lg:px-[16px]">
                    <span class="shrink-0 whitespace-nowrap">専用URL:</span><a class="ml-[4px] min-w-0 break-all text-blue-500"
                      href="{{ route('public-timecard.login') }}" target="_blank" rel="noopener noreferrer">{{ 'https://' . request()->getHost() . '/public-timecard/login' }}</a>
                  </div>
                </div>
                <div class="mt-2 grid-cols-[20%,80%] lg:grid lg:grid-cols-[180px_minmax(0,1fr)] lg:items-center">
                  <div></div>
                  <div class="flex h-[35px] min-w-0 items-center gap-1 rounded bg-[#F4F4F4] px-[8px] py-[1px] text-[12px] lg:px-[16px]">
                    <span class="shrink-0 whitespace-nowrap">PIN CODE：</span><span>{{ $pin }}</span>
                  </div>
                </div>
              @endif
            </div>

            <div class="mt-[30px] flex w-full justify-center lg:mt-5">
              <button class="mb-5 h-[45px] w-[150px] whitespace-nowrap rounded bg-[#3289FA] font-bold text-white hover:opacity-40 lg:mb-0"
                type="submit">更新する</button>
            </div>

          </div>
        </form>

        <form method="POST" action="{{ route('setting.workday.update') }}">
          @csrf
          <div class="border-b py-[30px]">
            <div class="font-bold">勤務日設定</div>
            <div class="mt-[30px] grid grid-cols-[35%,65%] items-center lg:grid-cols-[180px_minmax(0,1fr)]">
              <div class="text-[0.6875rem] font-bold">1日の起算時刻</div>
              <div>
                <input class="h-10 w-full max-w-[220px] rounded border-[#DDDDDD]" name="workday_start_time" type="time"
                  value="{{ old('workday_start_time', \Illuminate\Support\Str::of($rule->workday_start_time ?? '00:00:00')->substr(0, 5)) }}" />
                <div class="mt-2 text-xs text-[#7A7A7A]">この時刻をまたぐと別日の勤務として集計します。朝5:00開始などの就業規則に合わせて設定できます。</div>
                @error('workday_start_time')
                  <div class="mt-2 text-xs text-red-500">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="mt-[20px] grid grid-cols-[35%,65%] items-start lg:grid-cols-[180px_minmax(0,1fr)]">
              <div class="text-[0.6875rem] font-bold">休日曜日</div>
              <div>
                <div class="grid grid-cols-2 gap-x-4 gap-y-2 lg:grid-cols-4">
                  @foreach ([0 => '日曜', 1 => '月曜', 2 => '火曜', 3 => '水曜', 4 => '木曜', 5 => '金曜', 6 => '土曜'] as $value => $label)
                    <label class="flex items-center space-x-2 text-sm">
                      <input name="holiday_weekdays[]" type="checkbox" value="{{ $value }}"
                        @checked(in_array($value, old('holiday_weekdays', $rule->holiday_weekdays ?? [$rule->statutory_holiday_weekday ?? 0]), true))>
                      <span>{{ $label }}</span>
                    </label>
                  @endforeach
                </div>
                <div class="mt-2 text-xs text-[#7A7A7A]">固定の休日曜日を複数選べます。未選択なら曜日での休日扱いはしません。</div>
                @error('holiday_weekdays')
                  <div class="mt-2 text-xs text-red-500">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="mt-[20px] grid grid-cols-[35%,65%] items-start lg:grid-cols-[180px_minmax(0,1fr)]">
              <div class="text-[0.6875rem] font-bold">単発休日</div>
              <div>
                <textarea class="min-h-[96px] w-full max-w-[320px] rounded border-[#DDDDDD]" name="holiday_dates"
                  placeholder="2026-01-01&#10;2026-05-03">{{ old('holiday_dates', implode("\n", $rule->holiday_dates ?? [])) }}</textarea>
                <div class="mt-2 text-xs text-[#7A7A7A]">祝日など、その年だけの休日を `YYYY-MM-DD` 形式で1行ずつ入力できます。</div>
                @error('holiday_dates')
                  <div class="mt-2 text-xs text-red-500">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="mt-[20px] grid grid-cols-[35%,65%] items-start lg:grid-cols-[180px_minmax(0,1fr)]">
              <div class="text-[0.6875rem] font-bold">毎年休日</div>
              <div>
                <textarea class="min-h-[96px] w-full max-w-[320px] rounded border-[#DDDDDD]" name="annual_holiday_dates"
                  placeholder="04-01&#10;10-15">{{ old('annual_holiday_dates', implode("\n", $rule->annual_holiday_dates ?? [])) }}</textarea>
                <div class="mt-2 text-xs text-[#7A7A7A]">創設記念日など毎年くる休日を `MM-DD` 形式で1行ずつ入力できます。</div>
                @error('annual_holiday_dates')
                  <div class="mt-2 text-xs text-red-500">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="mt-[30px] flex w-full justify-center lg:mt-5">
              <button class="mb-5 h-[45px] w-[150px] whitespace-nowrap rounded bg-[#3289FA] font-bold text-white hover:opacity-40 lg:mb-0"
                type="submit">更新する</button>
            </div>
          </div>
        </form>

        <form method="POST" action="{{ route('setting.pay_unit.update') }}">
          @csrf

          @error('overtimeRate')
            <div class="mt-2 flex items-start gap-2 rounded-lg border border-red-200 bg-red-50 px-3 py-2">
              <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M18 10A8 8 0 11 2 10a8 8 0 0116 0zm-9-4a1 1 0 112 0v4a1 1 0 11-2 0V6zm1 8a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"
                  clip-rule="evenodd" />
              </svg>
              <p class="text-sm text-red-600">
                {{ $message }}
              </p>
            </div>
          @enderror

          @error('nightRate')
            <div class="mt-2 flex items-start gap-2 rounded-lg border border-red-200 bg-red-50 px-3 py-2">
              <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M18 10A8 8 0 11 2 10a8 8 0 0116 0zm-9-4a1 1 0 112 0v4a1 1 0 11-2 0V6zm1 8a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"
                  clip-rule="evenodd" />
              </svg>
              <p class="text-sm text-red-600">
                {{ $message }}
              </p>
            </div>
          @enderror

          @error('overtimeOver60Rate')
            <div class="mt-2 flex items-start gap-2 rounded-lg border border-red-200 bg-red-50 px-3 py-2">
              <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M18 10A8 8 0 11 2 10a8 8 0 0116 0zm-9-4a1 1 0 112 0v4a1 1 0 11-2 0V6zm1 8a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"
                  clip-rule="evenodd" />
              </svg>
              <p class="text-sm text-red-600">
                {{ $message }}
              </p>
            </div>
          @enderror

          @error('holidayRate')
            <div class="mt-2 flex items-start gap-2 rounded-lg border border-red-200 bg-red-50 px-3 py-2">
              <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M18 10A8 8 0 11 2 10a8 8 0 0116 0zm-9-4a1 1 0 112 0v4a1 1 0 11-2 0V6zm1 8a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"
                  clip-rule="evenodd" />
              </svg>
              <p class="text-sm text-red-600">
                {{ $message }}
              </p>
            </div>
          @enderror

          <div class="py-[30px]">
            <div class="font-bold">給与算出設定</div>
            <div class="mt-[30px] grid grid-cols-[35%,65%] items-center lg:grid-cols-[20%,80%]">
              <div class="text-[0.6875rem] font-bold">時給発生タイミング</div>

              <div class="flex flex-wrap items-center gap-x-6 gap-y-2 lg:justify-start">
                <label class="flex cursor-pointer items-center space-x-2">
                  <input name="pay_unit" type="radio" value="1"
                    @if ($wagePremium?->pay_unit === 1) checked @endif />
                  <div>1分</div>
                </label>

                <label class="flex cursor-pointer items-center space-x-2">
                  <input name="pay_unit" type="radio" value="15"
                    @if ($wagePremium?->pay_unit === 15) checked @endif />
                  <div>15分</div>
                </label>

                <label class="flex cursor-pointer items-center space-x-2">
                  <input name="pay_unit" type="radio" value="30"
                    @if ($wagePremium?->pay_unit === 30) checked @endif />
                  <div>30分</div>
                </label>
              </div>
            </div>

            <div class="mt-[30px] items-center space-y-2 lg:grid lg:grid-cols-[50%,50%] lg:space-y-0">
              <div class="grid grid-cols-[40%,60%] items-center">
                <div class="text-[0.6875rem] font-bold">深夜割増設定</div>
                <label class="flex cursor-pointer items-center space-x-2">
                  <input class="w-[80px] rounded border-[#DDDDDD] lg:w-[100px]" name="nightRate" type="text"
                    value="{{ old('nightRate', $wagePremium?->night_rate) }}" />
                  <div>%</div>
                </label>
              </div>
              <div class="grid grid-cols-[40%,60%] items-center">
                <div class="text-[0.6875rem] font-bold">残業割増設定</div>
                <label class="flex cursor-pointer items-center space-x-2">
                  <input class="w-[80px] rounded border-[#DDDDDD] lg:w-[100px]" name="overtimeRate" type="text"
                    value="{{ old('overtimeRate', $wagePremium?->overtime_rate) }}" />
                  <div>%</div>
                </label>
              </div>
            </div>
            <div class="mt-[20px] items-center space-y-2 lg:grid lg:grid-cols-[50%,50%] lg:space-y-0">
              <div class="grid grid-cols-[40%,60%] items-center">
                <div class="text-[0.6875rem] font-bold">60h超残業設定</div>
                <label class="flex cursor-pointer items-center space-x-2">
                  <input class="w-[80px] rounded border-[#DDDDDD] lg:w-[100px]" name="overtimeOver60Rate" type="text"
                    value="{{ old('overtimeOver60Rate', $wagePremium?->overtime_over_60_rate ?? 50) }}" />
                  <div>%</div>
                </label>
              </div>
              <div class="grid grid-cols-[40%,60%] items-center">
                <div class="text-[0.6875rem] font-bold">法定休日設定</div>
                <label class="flex cursor-pointer items-center space-x-2">
                  <input class="w-[80px] rounded border-[#DDDDDD] lg:w-[100px]" name="holidayRate" type="text"
                    value="{{ old('holidayRate', $wagePremium?->holiday_rate ?? 35) }}" />
                  <div>%</div>
                </label>
              </div>
            </div>
            <div class="mt-[30px] flex w-full justify-center lg:mt-5">
              <button class="mb-5 h-[45px] w-[150px] whitespace-nowrap rounded bg-[#3289FA] font-bold text-white hover:opacity-40 lg:mb-0"
                type="submit">更新する</button>
            </div>
          </div>
        </form>

        {{-- <div>
          <div class="border-t pt-[30px]">
            <div class="font-bold">プラン設定</div>
            <div class="grid grid-cols-[20%,80%] items-center">
              <div class="text-[0.6875rem] font-bold">ご利用中のプラン</div>
              <label class="flex cursor-pointer items-center space-x-2">
                <input class="w-[80px] rounded border-[#DDDDDD] lg:w-[100px]" name="overtimeRate" type="text" />
              </label>
            </div>

            <div class="mt-[30px] grid grid-cols-[20%,80%] items-center">
              <div class="text-[0.6875rem] font-bold">プランの解約</div>
              <div class="">
                <button
                  class="h-[45px] w-[150px] whitespace-nowrap rounded bg-[#FF4A62] text-sm font-bold text-white hover:opacity-40">解約する</button>
                <div class="mt-[11px] text-sm">※解約をご希望の場合は、解約希望日の1ヶ月前までに申請をお願いいたします。</div>
              </div>
            </div>
          </div>
        </div> --}}
      </div>
    </x-dashboard.container>
  </x-dashboard.index>
</x-dashboard-layout>
