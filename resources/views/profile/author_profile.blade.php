<x-app-layout>
    <div class="max-w-7xl mx-auto mt-8 p-4 bg-white rounded-xl shadow-lg overflow-hidden dark:bg-gray-800 dark:border-gray-200">
        <div class="relative w-full h-64 bg-gray-300 rounded-xl overflow-hidden group">
            <!-- Imagem de Capa -->
            <img id="coverPreview"
                src="{{ $user->cover_photo ? asset('storage/' . $user->cover_photo) : 'default_cover.jpg' }}"
                alt="Imagem de Capa" class="w-full h-full object-cover transition-all duration-300 ease-in-out"
                onclick="document.getElementById('input_image_pfp').click()">
        </div>

            <!-- Foto de Perfil -->
            <div class="relative -mt-20">
                <div class="w-48 h-48 rounded-full overflow-hidden border-4 border-white shadow-lg">
                    @if (!$user->profile_photo)
                        <span
                            class="text-5xl text-gray-700 flex items-center justify-center w-full h-full bg-blue-500 text-white">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                    @else
                        <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Foto de Perfil"
                            class="w-full h-full object-cover">
                    @endif
                </div>
            

                <!-- Botão de seguir -->
                @if (auth()->user()->id !== $user->id)
                    <div class="absolute top-7 right-4">
                        <form action="{{ route('follow.toggle', $user->id) }}" method="POST">
                            @csrf
                            <button
                            class="flex items-center justify-center py-2 mt-16 px-6 text-gray-700 font-medium rounded-full border-2 
                            border-gray-300 hover:bg-gray-200 dark:hover:bg-gray-300 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-all
                            dark:bg-gray-200 dark:text-black">
                                {{ auth()->user()->isFollowing($user) ? 'Deixar de seguir' : 'Seguir' }}
                            </button>
                        </form>
                    </div>
                @endif
            </div>

        <!-- Informações do Usuário -->
        <div class="mt-6 px-4">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">{{ $user->name }}</h2>
            <p class="text-md text-gray-500">{{ '@' . $user->username }}</p>
            <p class="mt-2 text-gray-600 w-[700px] dark:text-gray-200">{{ $user->bio ?? '' }}</p>

            <!-- Botões que abrem o modal -->
            <div class="flex gap-6 mt-4 text-gray-700 dark:text-gray-200 text-sm">
                <div onclick="openModal('followers')" class="cursor-pointer hover:underline">
                    <span class="font-bold">{{ $user->followers()->count() }}</span> {{__("texts.seguidores")}}
                </div>
                <div onclick="openModal('following')" class="cursor-pointer hover:underline">
                    <span class="font-bold">{{ $user->following()->count() }}</span> {{__("texts.seguindo")}}
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div
                class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-[90%] max-w-md relative max-h-[400px] overflow-y-auto">
                <!-- Botão fechar -->
                <button onclick="closeModal()"
                    class="absolute top-2 right-2 text-xl text-gray-600 hover:text-black dark:text-gray-400 dark:hover:text-white">
                    &times;
                </button>

                <!-- Título -->
                <h2 id="modal-title" class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">{{__("texts.seguidores")}}</h2>

                <!-- Abas -->
                <div class="flex mb-4 border-b border-gray-200 dark:border-gray-600">
                    <button onclick="switchTab('followers')" id="tab-followers"
                        class="px-4 py-2 text-sm font-bold border-b-2 border-blue-500 dark:text-gray-200">
                        {{__("texts.seguidores")}}
                    </button>
                    <button onclick="switchTab('following')" id="tab-following"
                        class="px-4 py-2 text-sm text-gray-600 dark:text-gray-200">
                        {{__("texts.seguindo")}}
                    </button>
                </div>

                <!-- Conteúdo das listas -->
                <div id="content-followers">
                    @forelse($user->followers as $follower)
                        @php
                            $profileRoute =
                                auth()->user()->id == $follower->id
                                    ? route('profile.my_profile')
                                    : route('profile.author_profile', $follower->id);
                        @endphp

                        <a href="{{ $profileRoute }}">
                            <div
                                class="py-2 bg-white dark:bg-gray-800 dark:border-gray-700 rounded-xl mb-2 shadow-md border border-gray-200 
                                transition-all duration-300 transform hover:-translate-y-1 hover:scale-105 hover:shadow-lg cursor-pointer px-2">
                                <div class="flex items-center gap-4 p-2">
                                    {{-- Avatar --}}
                                    @if ($follower && !$follower->profile_photo)
                                        <div
                                            class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                            {{ strtoupper(substr($follower->name, 0, 1)) }}
                                        </div>
                                    @elseif ($follower && $follower->profile_photo)
                                        <img src="{{ asset('storage/' . $follower->profile_photo) }}"
                                            alt="Foto de perfil" class="w-12 h-12 object-cover rounded-full" />
                                    @endif
                                    <span class="font-medium text-gray-800 dark:text-gray-200 text-sm">{{ $follower->name }}</span>
                                </div>
                            </div>
                        </a>
                    @empty
                        <span class="font-medium text-gray-800 dark:text-gray-200 text-sm">{{__("texts.nenhum")}}</span>
                    @endforelse
                </div>

                <div id="content-following" class="hidden">
                    <div id="content-followers">
                        @forelse($user->following as $followed)
                            @php
                                $profileRoute =
                                    auth()->user()->id == $followed->id
                                        ? route('profile.my_profile')
                                        : route('profile.author_profile', $followed->id);
                            @endphp

                            <a href="{{ $profileRoute }}">
                                <div
                                    class="py-2 bg-white dark:bg-gray-800 dark:border-gray-700 rounded-xl mb-2 shadow-md border border-gray-200 
                            transition-all duration-300 transform hover:-translate-y-1 hover:scale-105 hover:shadow-lg cursor-pointer px-2">
                                    <div class="flex items-center gap-4 p-2">
                                        {{-- Avatar --}}
                                        @if ($followed && !$followed->profile_photo)
                                            <div
                                                class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                                {{ strtoupper(substr($followed->name, 0, 1)) }}
                                            </div>
                                        @elseif ($followed && $followed->profile_photo)
                                            <img src="{{ asset('storage/' . $followed->profile_photo) }}"
                                                alt="Foto de perfil" class="w-12 h-12 object-cover rounded-full" />
                                        @endif
                                        <span
                                            class="font-medium text-gray-800 dark:text-gray-200 text-sm">{{ $followed->name }}</span>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{__("texts.nenhum")}}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Posts -->
    @if ($posts->isEmpty())
        <div
            class="w-[80%] max-w-2xl mx-auto my-6 p-6 bg-white dark:bg-gray-800 dark:border-gray-700 rounded-xl shadow-md border border-gray-200 
                transition-all duration-300 transform hover:-translate-y-1 hover:scale-105 hover:shadow-lg cursor-pointer">
            <div class="flex items-start gap-4">
                <!-- Conteúdo do post -->
                <div class="flex-1">

                    <div class="flex justify-between items-center">
                        <p
                            class="text-gray-700 text-s leading-relaxed whitespace-pre-wrap 
                break-words max-w-[500px] mt-2 mb-5 dark:text-gray-100 line-clamp-2">{{__("texts.naohapost")}}</p>
                    </div>
                </div>
            </div>
        </div>
    @else
        @foreach ($posts as $post)
            <div
                class="posts w-[80%] w-full max-w-2xl mx-auto my-6 p-6 bg-white dark:bg-gray-800 dark:border-gray-700 rounded-xl shadow-md border border-gray-200 
                            sm:px-4 sm:py-4 box-border overflow-hidden transition-all duration-300 transform hover:-translate-y-1 hover:scale-105 hover:shadow-lg cursor-pointer"
                    onclick="responderPost('{{ route('comments', $post->id) }}')">

                <div class="flex items-start gap-4">
                    <x-avatar :user="$post->user" />

                    <!-- Conteúdo do post -->
                    <x-posts :post="$post" />

                    <div class="mt-10">
                        <div class="absolute bottom-4 left-4 right-4 flex justify-between items-center" style="z-index: 1;">
                            <x-button-chat :post="$post" />

                            {{-- Botões de Like e Delete (à direita) --}}
                            <div class="flex space-x-4 items-center" style="z-index: 1;">
                                <x-button-like :post="$post" />

                                {{-- Botão de Deletar (aparece só se for dono do post) --}}
                                @if (auth()->user()->id == $post->user_id)
                                    <x-button-delete :post="$post" />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        @endforeach
    @endif

    <!-- Script de Like -->
    <script>
        if (performance.navigation.type === 2) {
            location.reload();
        }

        function openModal(tab) {
            document.getElementById('modal').classList.remove('hidden');
            switchTab(tab);
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }

        function switchTab(tab) {
            const title = document.getElementById('modal-title');
            const followersContent = document.getElementById('content-followers');
            const followingContent = document.getElementById('content-following');
            const tabFollowers = document.getElementById('tab-followers');
            const tabFollowing = document.getElementById('tab-following');

            if (tab === 'followers') {
                title.innerText = 'Seguidores';
                followersContent.classList.remove('hidden');
                followingContent.classList.add('hidden');
                tabFollowers.classList.add('font-bold', 'border-b-2', 'border-blue-500');
                tabFollowing.classList.remove('font-bold', 'border-b-2', 'border-blue-500');
            } else {
                title.innerText = 'Seguindo';
                followingContent.classList.remove('hidden');
                followersContent.classList.add('hidden');
                tabFollowing.classList.add('font-bold', 'border-b-2', 'border-blue-500');
                tabFollowers.classList.remove('font-bold', 'border-b-2', 'border-blue-500');
            }
        }

        // Fecha modal ao apertar ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });

        // Fecha modal clicando fora
        document.addEventListener('click', function(e) {
            const modal = document.getElementById('modal');
            if (!modal.classList.contains('hidden') && e.target === modal) {
                closeModal();
            }
        });

        //Likes Script
        document.addEventListener('DOMContentLoaded', () => {
            const likeUrl = "{{ route('likes.toggle') }}".replace('http://', 'https://');
            console.log(likeUrl); // Verifique no console a URL gerada

            document.querySelectorAll('.like-button').forEach(button => {
                button.addEventListener('click', async (e) => {
                    e.preventDefault();

                    const postId = button.dataset.postId;
                    const liked = button.dataset.liked === '1';
                    const likeCountElement = button.querySelector('.like-count');
                    const icon = button.querySelector('.like-icon');

                    // Adiciona animação de rotação e escala (pop)
                    icon.classList.add('rotate-12', 'scale-125');

                    // Remove a animação depois de um tempo
                    setTimeout(() => {
                        icon.classList.remove('rotate-12', 'scale-125');
                    }, 300);

                    // Requisição AJAX para curtir/descurtir
                    const response = await fetch(likeUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector(
                                'meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            likeable_type: 'post',
                            likeable_id: postId
                        })
                    });

                    const data = await response.json();

                    // Atualiza o estado visual
                    button.dataset.liked = data.liked ? '1' : '0';
                    likeCountElement.textContent = data.likes_count;

                    if (data.liked) {
                        button.classList.add('text-red-500');
                        likeCountElement.classList.remove('hidden');
                    } else {
                        button.classList.remove('text-red-500');
                        likeCountElement.classList.add('hidden');
                    }
                });
            });
        })
    </script>

<script>
    function responderPost(url) {
        window.location.href = url;
    }

    document.querySelectorAll('.like-button, .open-delete-modal, .btn-chat').forEach(btn => {
    btn.addEventListener('click', function(event) {
        event.stopPropagation();
    });
});

</script>

</x-app-layout>
