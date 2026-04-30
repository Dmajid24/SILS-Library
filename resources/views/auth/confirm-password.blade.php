<x-guest-layout>

    {{-- HEADER --}}
    <div class="text-center mb-6">

        <h2 class="text-xl sm:text-2xl font-bold text-gray-800">
            Confirm Password 🔒
        </h2>

        <p class="mt-2 text-sm text-gray-500 leading-relaxed px-2">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </p>

    </div>



    {{-- FORM --}}
    <form method="POST"
          action="{{ route('password.confirm') }}"
          class="space-y-5">

        @csrf

        {{-- PASSWORD --}}
        <div>

            <x-input-label for="password"
                           :value="__('Password')"
                           class="text-sm font-semibold text-gray-700" />

            <x-text-input
                id="password"
                class="block mt-2 w-full rounded-xl border-gray-200 shadow-sm
                       focus:border-indigo-500 focus:ring-indigo-500"
                type="password"
                name="password"
                required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')"
                           class="mt-2 text-sm" />

        </div>



        {{-- BUTTON --}}
        <div class="pt-2">

            <x-primary-button class="w-full justify-center py-3 rounded-xl text-sm sm:text-base">
                {{ __('Confirm') }}
            </x-primary-button>

        </div>

    </form>

</x-guest-layout>