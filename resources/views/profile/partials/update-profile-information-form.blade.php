<section>

    {{-- HEADER --}}
    <header class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">
            Profile Information
        </h2>

        <p class="mt-2 text-sm text-gray-500">
            Update your personal information, email address, and phone number.
        </p>
    </header>

    {{-- EMAIL VERIFY FORM --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- MAIN FORM --}}
    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        {{-- FIRST NAME --}}
        <div>
            <x-input-label for="first_name" :value="__('First Name')" />

            <x-text-input
                id="first_name"
                name="first_name"
                type="text"
                class="mt-2 block w-full rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                :value="old('first_name', $user->first_name)"
                required
                autofocus
                autocomplete="given-name"
                placeholder="Enter first name"
            />

            <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
        </div>

        {{-- LAST NAME --}}
        <div>
            <x-input-label for="last_name" :value="__('Last Name')" />

            <x-text-input
                id="last_name"
                name="last_name"
                type="text"
                class="mt-2 block w-full rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                :value="old('last_name', $user->last_name)"
                autocomplete="family-name"
                placeholder="Enter last name"
            />

            <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
        </div>

        {{-- EMAIL --}}
        <div>
            <x-input-label for="email" :value="__('Email Address')" />

            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-2 block w-full rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                :value="old('email', $user->email)"
                required
                autocomplete="username"
                placeholder="Enter email address"
            />

            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            {{-- VERIFY EMAIL --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())

                <div class="mt-3 bg-yellow-50 border border-yellow-200 rounded-xl p-4">

                    <p class="text-sm text-yellow-700">
                        Your email address is not verified.
                    </p>

                    <button
                        form="send-verification"
                        class="mt-2 text-sm font-medium text-indigo-600 hover:underline">
                        Click here to resend verification email.
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm text-green-600">
                            Verification link has been sent successfully.
                        </p>
                    @endif

                </div>

            @endif
        </div>

        {{-- PHONE --}}
        <div>
            <x-input-label for="phone" :value="__('Phone Number')" />

            <x-text-input
                id="phone"
                name="phone"
                type="text"
                class="mt-2 block w-full rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                :value="old('phone', $user->phone)"
                placeholder="Example: 08123456789"
            />

            <p class="mt-1 text-xs text-gray-400">
                Required to borrow books.
            </p>

            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        {{-- SAVE BUTTON --}}
        <div class="flex items-center gap-4 pt-2">

            <x-primary-button class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700">
                {{ __('Save Changes') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    class="text-sm text-green-600 font-medium"
                >
                    Profile updated successfully.
                </p>
            @endif

        </div>

    </form>

</section>