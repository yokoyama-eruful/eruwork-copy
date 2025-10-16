<div>
  <div class="hidden lg:block">
    @vite(['Modules/Board/resources/css/widget.css'])
    <div class="sidebar-title">
      <h5 class="pt-15 font-bold">掲示板</h5>
      <a class="sidebar-link pt-15" href="{{ route('board.index') }}">
        掲示板一覧へ
        <img src="img/icon/transition-link.png" />
      </a>
    </div>
    @if ($posts->isEmpty())
      <div class="mt-[100px] flex flex-col items-center justify-center">
        <svg width="60" height="60" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path opacity="0.1" fill-rule="evenodd" clip-rule="evenodd"
            d="M43.75 12.5C42.0927 12.5011 40.5037 13.1599 39.3318 14.3318C38.1599 15.5037 37.5011 17.0927 37.5 18.75H62.5C62.5 17.0924 61.8415 15.5027 60.6694 14.3306C59.4973 13.1585 57.9076 12.5 56.25 12.5H43.75ZM32.5292 13.2417C33.559 11.1439 35.1562 9.3768 37.1396 8.14096C39.123 6.90511 41.4131 6.25001 43.75 6.25H56.25C58.5876 6.24923 60.8786 6.90397 62.8628 8.13986C64.847 9.37574 66.4449 11.1433 67.475 13.2417C69.5458 13.4167 71.6083 13.625 73.6667 13.8667C79.9042 14.5875 84.375 19.95 84.375 26.0708V81.25C84.375 84.5652 83.058 87.7446 80.7138 90.0888C78.3696 92.433 75.1902 93.75 71.875 93.75H28.125C24.8098 93.75 21.6304 92.433 19.2862 90.0888C16.942 87.7446 15.625 84.5652 15.625 81.25V26.0708C15.625 19.9458 20.0958 14.5875 26.3333 13.8625C28.3875 13.625 30.4542 13.4208 32.5292 13.2417Z"
            fill="black" />
        </svg>
        <div class="mt-5 text-xl font-bold text-[#222222] text-opacity-10">掲示物がありません</div>
      </div>
    @else
      @foreach ($posts as $post)
        <a href="{{ route('board.show', ['id' => $post->id]) }}">
          <div class="bulletin-board-area">
            <div class="bulletin-board-box">
              @if ($post->ReadStatus === null)
                <div class="new-ribbon">NEW</div>
              @endif
              <div class="board-title">
                <span>{{ $post->created_at?->format('Y.m.d') }}</span>
                @if ($post->attachments->isNotEmpty())
                  <img src="img/icon/attached-icon.png" />
                @endif
              </div>
              <h4 class="ellipsis">{!! nl2br(e($post->title)) !!}</h4>
              <p>{{ $post->user->profile->name ?? 'UnknownUser' }}</p>
            </div>
          </div>
        </a>
      @endforeach
    @endif
  </div>
  <div class="slider">
    <div class="slides-wrapper">
      @foreach ($posts->take(3) as $post)
        <a href="{{ route('board.show', ['id' => $post->id]) }}">
          <div class="bulletin-board-area slide">
            <div class="bulletin-board-box">
              @if ($post->ReadStatus === null)
                <div class="new-ribbon">NEW</div>
              @endif
              <div class="board-title">
                <span>{{ $post->created_at?->format('Y.m.d') }}</span>
                @if ($post->attachments->isNotEmpty())
                  <img src="images/icon/attached-icon.png" />
                @endif
              </div>
              <div class="board-text">
                <h4 class="ellipsis">{!! nl2br(e($post->title)) !!}</h4>
                <p>{{ $post->user->profile->name ?? 'UnknownUser' }}</p>
              </div>
            </div>
          </div>
        </a>
      @endforeach
    </div>
    <div class="pagination">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
</div>
