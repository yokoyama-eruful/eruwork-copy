<x-guest-layout>
  <form method="POST" action="{{ route('login') }}">
    @csrf

    <div>
      <x-input-label for="loginId" :value="__('loginId')" />
      <x-text-input class="mt-1 block w-full" id="loginId" name="loginId" type="text" :value="old('name')" required />
      <x-input-error class="mt-2" :messages="$errors->get('loginId')" />
    </div>
    <div class="mt-4">
      <x-input-label for="password" :value="__('Password')" />

      <x-text-input class="mt-1 block w-full" id="password" name="password" type="password" required
        autocomplete="current-password" />

      <x-input-error class="mt-2" :messages="$errors->get('password')" />
    </div>
    <div class="mt-4 flex items-center justify-end">
      <x-primary-button class="ms-3">
        {{ __('Log in') }}
      </x-primary-button>
    </div>
  </form>
</x-guest-layout>
