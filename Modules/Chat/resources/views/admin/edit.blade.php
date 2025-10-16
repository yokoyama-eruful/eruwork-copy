<x-dashboard-layout :url="route('chatManager.index')">
  <x-dashboard.index>
    <x-dashboard.top>
      <x-return-button class="hidden lg:block" href="{{ route('chatManager.index') }}">
        一覧に戻る
      </x-return-button>

      <div class="block text-xl font-bold lg:hidden">
        グループ編集
      </div>
    </x-dashboard.top>
    <x-dashboard.container>
      <form class="mb-5 flex flex-col px-5 lg:mb-0 lg:px-6"
        action="{{ route('chatManager.update', ['group' => $group]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <input name="id" type="hidden" value="{{ $group->id }}">
        <div class="hidden text-xl font-bold lg:block">
          グループ編集
        </div>
        <hr class="mb-2 hidden w-11/12 lg:block">
        <div class="grid gap-4 p-2">
          <label class="flex flex-col gap-2">
            グループアイコン
            <input class="rounded-md border border-slate-300 px-3 py-2 font-normal" name="icon" type="file">
            @error('icon')
              <div class="font-normal text-red-500">{{ $message }}</div>
            @enderror
          </label>

          <label class="flex flex-col gap-2">
            グループ名
            <input class="rounded-md border border-slate-300 px-3 py-2 font-normal" name="name" type="text"
              value="{{ old('name', $group->name) }}" required>
            @error('name')
              <div class="font-normal text-red-500">{{ $message }}</div>
            @enderror
          </label>
        </div>

        <div class="flex flex-col gap-2">
          <span class="font-semibold">メンバーの選択</span>
          <div class="grid grid-cols-4 gap-3">
            @foreach ($users as $user)
              <div class="flex cursor-pointer items-center justify-between rounded-lg border bg-white p-4"
                data-user-id="{{ $user->id }}" onclick="toggleSelection(this)">
                <span>{{ $user->name }}</span>
              </div>
            @endforeach
          </div>
        </div>
        <input id="selected_members" name="member" type="hidden" value="{{ implode(',', $memberIds) }}">
        <script>
          function toggleSelection(element) {
            const userId = element.getAttribute('data-user-id');
            const selectedMembersInput = document.getElementById('selected_members');
            const selectedMembers = new Set(selectedMembersInput.value.split(',').filter(Boolean));

            if (selectedMembers.has(userId)) {
              selectedMembers.delete(userId);
              element.classList.remove('bg-blue-500', 'text-white');
              element.classList.add('bg-white');
            } else {
              selectedMembers.add(userId);
              element.classList.add('bg-blue-500', 'text-white');
              element.classList.remove('bg-white');
            }

            selectedMembersInput.value = Array.from(selectedMembers).join(',');
          }

          // ページ読み込み時に初期選択を反映
          document.addEventListener('DOMContentLoaded', function() {
            const selectedMembers = new Set(document.getElementById('selected_members').value.split(',').filter(Boolean));
            document.querySelectorAll('[data-user-id]').forEach(function(element) {
              const userId = element.getAttribute('data-user-id');
              if (selectedMembers.has(userId)) {
                element.classList.add('bg-blue-500', 'text-white');
                element.classList.remove('bg-white');
              }
            });
          });
        </script>

        <button
          class="mx-auto mt-4 max-w-48 rounded-md bg-blue-600 px-6 py-2 text-center font-semibold text-white disabled:cursor-not-allowed disabled:opacity-50"
          type="submit">
          更新する
        </button>
      </form>
    </x-dashboard.container>
  </x-dashboard.index>
</x-dashboard-layout>
