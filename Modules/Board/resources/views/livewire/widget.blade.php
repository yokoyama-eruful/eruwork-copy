<div>
  <div class="hidden sm:block">
    @vite(['Modules/Board/resources/css/widget.css'])
    <div class="sidebar-title">
      <h5 class="pt-15 font-bold">掲示板</h5>
      <a class="sidebar-link pt-15" href="{{ route('board.index') }}">
        掲示板一覧へ
        <img src="img/icon/transition-link.png" />
      </a>
    </div>
    @if ($posts->isEmpty())
      <p>投稿はありません</p>
    @else
      @foreach ($posts as $post)
        <a href="{{ route('board.show', ['id' => $post->id]) }}">
          <div class="bulletin-board-area">
            <div class="bulletin-board-box">
              @if ($post->ReadStatus === null)
                <div class="new-ribbon">NEW</div>
              @endif
              <div class="board-title">
                <span>{{ $post->created_at->format('Y.m.d') }}</span>
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
                <span>{{ $post->created_at->format('Y.m.d') }}</span>
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
