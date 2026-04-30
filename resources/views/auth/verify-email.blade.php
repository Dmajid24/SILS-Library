<x-guest-layout>

    {{-- HEADER --}}
    <div class="text-center mb-6">

        <h2 class="text-xl sm:text-2xl font-bold text-gray-800">
            Verify Email 📩
        </h2>

        <p class="mt-2 text-sm text-gray-500 leading-relaxed px-2">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </p>

    </div>



    {{-- SUCCESS --}}
    @if (session('status') == 'verification-link-sent')
        <div class="mb-5 bg-green-100 text-green-700 px-4 py-3 rounded-xl text-sm">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif



    {{-- ACTIONS --}}
    <div class="space-y-4">

        {{-- RESEND EMAIL --}}
        <form method="POST"
              action="{{ route('verification.send') }}">
            @csrf

            <x-primary-button class="w-full justify-center py-3 rounded-xl text-sm sm:text-base">
                {{ __('Resend Verification Email') }}
            </x-primary-button>

        </form>



        {{-- LOGOUT --}}
        <form method="POST"
              action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                class="w-full py-3 rounded-xl border border-gray-200 bg-white
                       text-sm font-medium text-gray-600 hover:text-indigo-600
                       hover:border-indigo-300 transition">
                {{ __('Log Out') }}
            </button>

        </form>

    </div>

</x-guest-layout>