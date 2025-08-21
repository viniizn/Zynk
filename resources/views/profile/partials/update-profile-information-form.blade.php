<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-white">
            {{ __('texts.profileInformation') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
            {{ __("texts.profileInformationDesc") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6 ">
        @csrf
        @method('patch')

        <div class="flex flex-col md:flex-row gap-6">
            <div class="w-full md:w-1/2">
                <x-input-label for="name" :value="__('texts.nome')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full dark:bg-gray-800 dark:text-gray-200 border dark:border-gray-700" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
        
            <div class="w-full md:w-1/2">
                <x-input-label for="username" :value="__('texts.username')" />
                <x-text-input id="username" name="username" type="text" class="mt-1 block w-full dark:bg-gray-800 dark:text-gray-200 border dark:border-gray-700" :value="old('username', $user->username)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('username')" />
            </div>
        </div>

        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <textarea id="bio" name="bio" class="mt-1 block w-full h-32 p-2 rounded-lg shadow-sm border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-800 dark:text-gray-200 border dark:border-gray-700 dark:placeholder-gray-400">{{ old('bio', $user->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />

            <p id="char_count" class="text-sm text-gray-500 dark:text-gray-400 mt-1">0/255</p>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full dark:bg-gray-800 dark:text-gray-200 border dark:border-gray-700" :value="old('email', $user->email)" required autocomplete="email" />
            <x-input-error class="mt-2 flex" :messages="$errors->get('email')" />
    
            <div class="relative cursor-pointer w-32 h-32 mt-5 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-lg group overflow-hidden">
                <div id="profile_pfp" class="group-hover:bg-gray-800 w-full h-full relative">
                    {{-- Letra de fallback --}}
                    @if (!$user->profile_photo)
                        <span id="profile_letter" class="absolute inset-0 flex items-center justify-center text-5xl text-white">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                    @endif
                
                    {{-- Sempre inclui a imagem, com src condicional --}}
                    <img id="preview_image" src="{{ $user->profile_photo ? asset("storage/" . $user->profile_photo) : '' }}" alt="Foto de perfil" class="w-full h-full object-cover rounded-full {{ $user->profile_photo ? '' : 'hidden' }}" />
                </div>
            
                <label for="input_image_pfp" class="cursor-pointer absolute inset-0 flex items-center justify-center text-sm opacity-0 group-hover:opacity-100 bg-black bg-opacity-20 transition-opacity duration-300">
                    {{__("texts.imagemAlterar")}}
                    <input type="file" name="profile_photo" id="input_image_pfp" accept="image/*" class="hidden" />
                </label>
            </div>

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('texts.emailNaoencontrado') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('texts.emailClickVerification') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('texts.salvo') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-300"
                >{{ __('texts.save') }}</p>
            @endif
        </div>
    </form>
</section>

<script>
    const inputImage = document.getElementById('input_image_pfp');
    const imagePreview = document.getElementById('preview_image');
    const profileLetter = document.getElementById('profile_letter');

    inputImage?.addEventListener('change', function () {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            const reader = new FileReader();

            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('hidden');
                profileLetter?.classList.add('hidden');
            }

            reader.readAsDataURL(file);
        }
    });

    const bio = document.getElementById("bio");
    const char_count = document.getElementById("char_count");

    // Função para atualizar o contador de caracteres
    bio.addEventListener("input", function() {
        const currentLength = bio.value.length;
        char_count.textContent = `${currentLength}/255`; // Exibe "X/255"
    });
</script>
