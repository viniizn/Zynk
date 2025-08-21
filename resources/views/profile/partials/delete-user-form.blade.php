<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-white">
            {{ __('texts.deleteConta') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-200">
            {{ __('texts.deleteContaDesc') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('texts.deleteConta') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('texts.deleteContaConfirm') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('texts.deleteContaVerification') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('texts.senha') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('texts.senha') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('texts.cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('texts.deleteConta') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
