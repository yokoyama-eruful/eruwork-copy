<x-app-layout>
  {{-- top.cssの読み込み --}}
  @vite(['resources/css/top.css'])
  <div class="sidebar">
    {{-- タイムカードの読み込み（Modules/Timecard/resources/views/general/livewire/stamp.blade.php） --}}
    <livewire:timecard::general.stamp />
    <hr class="border-line" />
    {{-- 掲示板の読み込み（Modules/Board/resources/views/livewire/widget.blade.php） --}}
    <livewire:board::widget />
  </div>

  {{-- カレンダーの読み込み --}}
  <livewire:calendar::general.widget />

  {{-- 以下モバイル --}}
  {{-- <div class="overlay"></div> --}}
  <div class="sp">
    <livewire:board::widget />
    {{-- タイムカードの読み込み（Modules/Timecard/resources/views/general/livewire/stamp.blade.php） --}}
    <livewire:timecard::general.stamp />

    <div class="calender-area-sp">
      <h3 class="calender-sp-title">シフト</h3>
      <div class="calendar-sp-month-day">
        <h4>9月</h4>
        <div class="calendar-sp-day">
          <ul>
            <li class="current calendar-sp-day-box">
              <a href="">
                <span>月</span>
                23
              </a>
            </li>
            <li class="calendar-sp-day-box">
              <a href="">
                <span>火</span>
                24
              </a>
            </li>
            <li class="calendar-sp-day-box">
              <a href="">
                <span>水</span>
                25
              </a>
            </li>
            <li class="calendar-sp-day-box">
              <a href="">
                <span>木</span>
                26
              </a>
            </li>
            <li class="calendar-sp-day-box">
              <a href="">
                <span>金</span>
                27
              </a>
            </li>
            <li class="calendar-sp-day-box">
              <a href="">
                <span>土</span>
                28
              </a>
            </li>
            <li class="calendar-sp-day-box">
              <a href="">
                <span>日</span>
                29
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="schedule-box-area">
        <h4>9月23日の予定</h4>
        <div class="schedule-detail-box">
          <p>予定は入っていません</p>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
