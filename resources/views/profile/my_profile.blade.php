<x-app-layout>
    <div class="max-w-7xl mx-auto mt-8 p-4 bg-white rounded-xl shadow-lg overflow-hidden dark:bg-gray-800 dark:border-gray-200">
        <form method="post" id="coverForm" enctype="multipart/form-data" class="mt-6 space-y-6">
            @csrf
            @method('patch')
    
            <div class="relative w-full h-48 sm:h-64 bg-gray-300 rounded-xl overflow-hidden group cursor-pointer">
                <!-- Imagem de Capa -->
                <img id="coverPreview"
                    src="{{ $user->cover_photo ? asset('storage/' . $user->cover_photo) : 'default_cover.jpg' }}"
                    alt="Imagem de Capa"
                    class="w-full h-full object-cover transition-all duration-300 ease-in-out group-hover:bg-gray-800"
                    onclick="document.getElementById('input_image_pfp').click()">
                
                <!-- Campo de Envio de Arquivo -->
                <label for="input_image_pfp"
                    class="cursor-pointer absolute inset-0 flex items-center justify-center text-white text-lg font-semibold tracking-wide bg-black bg-opacity-50 rounded-md shadow-md opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    {{__("texts.imagemAlterar")}}
                    <input type="file" name="cover_photo" id="input_image_pfp" accept="image/*" class="hidden"
                        onchange="uploadCoverImage(event)" />
                </label>
            </div>
    
            <div id="coverToast"
                class="fixed bottom-6 z-50 right-6 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg opacity-0 scale-95 translate-y-4 pointer-events-none transition-all duration-500 ease-out hover:scale-105 select-none pointer-events-auto">
                {{__("texts.imagemAlterada")}}
            </div>
        </form>
    
        <!-- Foto de Perfil -->
        <div class="relative -mt-24 sm:-mt-20 ml-2 sm:ml-4">
            <div class="w-32 h-32 sm:w-48 sm:h-48 rounded-full overflow-hidden border-4 border-white shadow-lg">
                @if (!$user->profile_photo)
                    <span
                        class="text-4xl sm:text-5xl text-gray-700 flex items-center justify-center w-full h-full bg-blue-500 text-white">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </span>
                @else
                    <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : '' }}"
                        alt="Foto de Perfil" class="w-full h-full object-cover">
                @endif
            </div>
    
            <!-- Botão Editar Perfil -->
            <div class="absolute top-10 sm:top-7 right-4">
                <a href="{{ route('profile.edit') }}">
                    <button
                        class="flex items-center justify-center py-2 mt-16 px-4 sm:px-6 text-gray-700 font-medium rounded-full border-2 
                        border-gray-300 hover:bg-gray-200 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-all
                        dark:bg-gray-200 dark:text-black text-sm sm:text-base">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                        <p class="ml-2">{{__("texts.editProfile")}}</p>
                    </button>
                </a>
            </div>
        </div>
    
        <!-- Informações do Usuário -->
        <div class="mt-6 px-2 sm:px-4">
            <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 dark:text-white">{{ $user->name }}</h2>
            <p class="text-sm sm:text-md text-gray-500">{{ '@' . $user->username }}</p>
            
            <p class="mt-2 text-gray-600 dark:text-gray-200 w-full max-w-2xl">
                {{ $user->bio ?? '' }}
            </p>
    
            <!-- Seguidores/Seguindo -->
            <div class="flex flex-wrap gap-4 mt-4 text-gray-700 dark:text-gray-200 text-sm">
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
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-[90%] max-w-md relative">
                <!-- Botão fechar -->
                <button onclick="closeModaal()"
                    class="absolute top-2 right-2 text-xl text-gray-600 hover:text-black dark:text-gray-400 dark:hover:text-white">
                    &times;
                </button>

                <!-- Título -->
                <h2 id="modal-title" class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">{{__("texts.seguidores")}}</h2>

                <!-- Abas -->
                <div class="flex mb-4 border-b border-gray-200 dark:border-gray-300">
                    <button onclick="switchTab('followers')" id="tab-followers"
                        class="px-4 py-2 text-sm border-b-2 border-blue-500 text-gray-600">
                        {{__("texts.seguidores")}}
                    </button>
                    <button onclick="switchTab('following')" id="tab-following"
                        class="px-4 py-2 text-sm text-gray-600">
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

    <div class="py-2 dark:bg-gray-900">

    <!-- Posts -->
    @if ($posts->isEmpty())
        <div
            class="w-[80%] w-full max-w-2xl mx-auto my-6 p-6 bg-white dark:bg-gray-800 dark:border-gray-700 rounded-xl shadow-md border border-gray-200 
                transition-all duration-300 transform hover:-translate-y-1 hover:scale-105 hover:shadow-lg cursor-pointer">
            <div class="flex items-start gap-4">
                <!-- Conteúdo do post -->
                <div class="flex-1">

                    <div class="flex justify-between items-center">
                        <p
                            class="text-gray-700 text-s leading-relaxed whitespace-pre-wrap 
                break-words max-w-[500px] mt-2 mb-5 dark:text-gray-100 line-clamp-2">
                            Ainda não há postagens.</p>
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
    <!-- Botão de adicionar Post -->
    <x-button-add-post />

    <!-- Adicionar post -->
    <x-modal-add-post />

    <!-- Deletar post Modal-->
    <x-modal_delete />

</div>
    <!-- Script de Preview -->
    <script src="{{ asset("js/modal_add_post.js") }}" defer></script>
    <script src="{{ asset('js/view_pdf.js') }}" defer></script>

    <script>
        function openModal(tab) {
            document.getElementById('modal').classList.remove('hidden');
            switchTab(tab);
        }

        function closeModaal() {
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

        function showCoverToast() {
            const toast = document.getElementById('coverToast');

            // Mostrar com animação
            toast.classList.remove('opacity-0', 'scale-95', 'translate-y-4', 'pointer-events-none');
            toast.classList.add('opacity-100', 'scale-100', 'translate-y-0');

            // Ocultar suavemente após 3 segundos
            setTimeout(() => {
                toast.classList.remove('opacity-100', 'scale-100', 'translate-y-0');
                toast.classList.add('opacity-0', 'scale-95', 'translate-y-4');
                
                // Só bloqueia o pointer depois que a animação terminar (ex: 500ms)
                setTimeout(() => {
                    toast.classList.add('pointer-events-none');
                }, 500); // tempo deve bater com a duration-500
            }, 3000);
        }
        
        function uploadCoverImage(event) {
    const formData = new FormData();
    const file = event.target.files[0]; // Captura o arquivo da imagem
    formData.append('cover_photo', file); // Adiciona ao FormData
    formData.append('_token', "{{ csrf_token() }}"); // Token CSRF
    formData.append('_method', 'PATCH'); // Método PATCH

    // Exibe o preview da imagem antes de enviar para o servidor
    const previewImage = document.getElementById('coverPreview');
    const reader = new FileReader();
    reader.onloadend = function() {
        previewImage.src = reader.result; // Atualiza o preview da imagem
    };
    reader.readAsDataURL(file); // Converte a imagem selecionada para URL base64

    // Realiza a requisição AJAX para o servidor com o protocolo correto
    const url = "{{ route('profile.update_back') }}"//.replace('http://', 'https://');


    fetch(url, {
        method: "POST",
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, // Passando o CSRF Token no header
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Atualiza a imagem de capa no banco de dados
            document.getElementById('coverPreview').src = data.new_cover_url;
            showCoverToast(); // Sucesso ao atualizar imagem
        } else {
            alert('Erro ao atualizar imagem!');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        alert('Ocorreu um erro inesperado.');
    });
}


        //Script do modal de add e delete post -->
        if (performance.navigation.type === 2) {
            location.reload();
        }

        //Likes Script
        document.addEventListener('DOMContentLoaded', () => {
            const likeUrl = "{{ route('likes.toggle') }}"//.replace('http://', 'https://');
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

            //Modal de deletar posts
            const modal_delete = document.getElementById('delete-modal');
            const btnOpenDelete = document.querySelectorAll('.open-delete-modal');
            const modalContentDelete = document.getElementById('delete-modal-content');

            // Abre o modal ao clicar no botão
            btnOpenDelete.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    modal_delete.classList.remove('hidden');

                    // Pegue os dados do post
                    const postId = button.dataset.id;
                    const postTitle = button.dataset.title;

                    // Opcional: mostrar título no modal ou preencher o form dinamicamente
                    const form = document.getElementById('delete_form');

                    form.action = `{{ url('delete_post_submit') }}/${postId}`;
                });
            });

            const textarea = document.getElementById('input_text');

            // Fecha modal clicando no botão Cancelar (form)
            button_cancel.addEventListener('click', (e) => {
                modal_delete.classList.add('hidden');
            });

            let click_delete = false;

            modal_delete.addEventListener('mousedown', (e) => {
                click_delete = modalContentDelete.contains(e.target);
            });

            modal_delete.addEventListener("mouseup", (e) => {
                if (!click_delete && e.target == modal_delete) {
                    modal_delete.classList.add("hidden");
                    limparPreview();
                }
            })
        });
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
