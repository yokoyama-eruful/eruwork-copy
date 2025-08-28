<div class="speach-news">
  @if ($count > 0)
    <img src="img/icon/news-bell.png" />
    <div class="speech-bubble">
      <p>シフト申請：</p>
      <a href="{{ route('shift.submission.index') }}">{{ $count }}件受信済み</a>
      <img src="img/icon/close.png" />
    </div>
  @endif
</div>
