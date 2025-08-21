@if (!$user->profile_photo)
                <!-- Avatar genérico -->
                <div
                    class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif

            {{-- Sempre inclui a imagem, com src condicional --}}
            <img id="preview_image"
                src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : '' }}"
                alt="Foto de perfil"
                class="w-12 h-12 object-cover rounded-full {{ $user->profile_photo ? '' : 'hidden' }}">