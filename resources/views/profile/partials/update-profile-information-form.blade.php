<section>
    {{-- HEADER --}}
    <header class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">
            {{ __('profile.info_title') }}
        </h2>

        <p class="mt-2 text-sm text-gray-500">
            {{ __('profile.info_subtitle') }}
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
            <x-input-label for="first_name" :value="__('profile.first_name')" />
            <x-text-input
                id="first_name"
                name="first_name"
                type="text"
                class="mt-2 block w-full rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                :value="old('first_name', $user->first_name)"
                required
                autofocus
                autocomplete="given-name"
                placeholder="{{ __('profile.enter_first_name') }}"
            />
            <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
        </div>

        {{-- LAST NAME --}}
        <div>
            <x-input-label for="last_name" :value="__('profile.last_name')" />
            <x-text-input
                id="last_name"
                name="last_name"
                type="text"
                class="mt-2 block w-full rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                :value="old('last_name', $user->last_name)"
                autocomplete="family-name"
                placeholder="{{ __('profile.enter_last_name') }}"
            />
            <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
        </div>

        {{-- EMAIL --}}
        <div>
            <x-input-label for="email" :value="__('profile.email')" />
            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-2 block w-full rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                :value="old('email', $user->email)"
                required
                autocomplete="username"
                placeholder="{{ __('profile.enter_email') }}"
            />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            {{-- VERIFY EMAIL --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                    <p class="text-sm text-yellow-700">
                        {{ __('profile.unverified') }}
                    </p>
                    <button
                        form="send-verification"
                        class="mt-2 text-sm font-medium text-indigo-600 hover:underline">
                        {{ __('profile.resend_verification') }}
                    </button>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm text-green-600">
                            {{ __('profile.verification_sent') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- PHONE --}}
        <div>
            <x-input-label for="phone" :value="__('profile.phone')" />
            <x-text-input
                id="phone"
                name="phone"
                type="text"
                class="mt-2 block w-full rounded-xl border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
                :value="old('phone', $user->phone)"
                placeholder="{{ __('profile.phone_placeholder') }}"
            />
            <p class="mt-1 text-xs text-gray-400">
                {{ __('profile.phone_hint') }}
            </p>
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        {{-- SAVE BUTTON --}}
        <div class="flex items-center gap-4 pt-2">
            <x-primary-button class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700">
                {{ __('profile.save_changes') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    class="text-sm text-green-600 font-medium"
                >
                    {{ __('profile.updated_success') }}
                </p>
            @endif
        </div>
    </form>
</section>