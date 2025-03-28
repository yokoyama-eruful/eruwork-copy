<div class="mt-2">
  @if ($this->judgeLike())
    <div>
      <div class="flex flex-row items-center space-x-1">
        <button class="flex h-8 w-8 items-center justify-center rounded bg-blue-500 text-lg text-white"
          wire:click="getLikeStatus" @mouseenter="showTooltip = true" @mouseleave="showTooltip = false">
          <i class="fa-solid fa-thumbs-up me-1"></i>
        </button>

        <div>
          <button class="border-b border-blue-500 text-blue-500" type="button"
            x-on:click.prevent="$dispatch('open-modal', 'like-modal')">いいね{{ $likeCount }}</button>
          <x-modal-alert name="like-modal" title="いいねした人">
            <div class="flex flex-col">
              <div class="max-h-96 overflow-y-auto border">
                @if ($this->likes->isNotEmpty())
                  @foreach ($this->likes as $like)
                    <div class="flex flex-row items-center space-x-3 border-b px-2 py-2">
                      <div
                        class="flex h-8 w-8 items-center justify-center overflow-hidden rounded-full bg-gray-200 text-4xl text-gray-800">
                        @if (is_null($like->user))
                          ?
                        @else
                          @if ($like->user->icon)
                            <img class="h-full w-full" src="{{ $like->user->icon }}">
                          @else
                            👤
                          @endif
                        @endif
                      </div>
                      <p class="truncate">{{ $like->user->name ?? 'UnknownUser' }}</p>
                    </div>
                  @endforeach
                @else
                  いいねした人はいません
                @endif
              </div>

              <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                  閉じる
                </x-secondary-button>
              </div>
            </div>
          </x-modal-alert>
        </div>
      </div>
    </div>
  @else
    <div>
      <div class="flex flex-row items-center space-x-1">
        <button class="flex h-8 w-8 items-center justify-center rounded bg-blue-500 text-lg text-white"
          wire:click="getLikeStatus" @mouseenter="showTooltip = true" @mouseleave="showTooltip = false">
          <i class="fa-regular fa-thumbs-up me-1 opacity-80"></i>
        </button>

        <div>
          <button class="border-b border-blue-500 text-blue-500" type="button"
            x-on:click.prevent="$dispatch('open-modal', 'like-modal')">いいね{{ $likeCount }}</button>
          <x-modal-alert name="like-modal" title="いいねした人">
            <div class="flex flex-col">
              <div class="max-h-96 overflow-y-auto border">
                @if ($this->likes->isNotEmpty())
                  @foreach ($this->likes as $like)
                    <div class="flex flex-row items-center space-x-3 border-b px-2 py-2">
                      <div
                        class="flex h-8 w-8 items-center justify-center overflow-hidden rounded-full bg-gray-200 text-4xl text-gray-800">
                        @if ($like->user->IconImage)
                          <img class="h-full w-full" src="{{ $like->user->IconImage }}">
                        @else
                          👤
                        @endif
                      </div>
                      <p class="truncate">{{ $like->user->name }}</p>
                    </div>
                  @endforeach
                @else
                  いいねした人はいません
                @endif
              </div>

              <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                  閉じる
                </x-secondary-button>
              </div>
            </div>
          </x-modal-alert>
        </div>
      </div>
    </div>
  @endif
</div>
