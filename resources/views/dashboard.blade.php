<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:bg-gray-900 dark:text-white">
            {{ $title ?? __('texts.foryou') }}
        </h2>
    </x-slot>

    <div class="py-12 dark:bg-gray-900">

        <!-- Adicionar post -->
        <x-modal-add-post />

        <!-- Deletar post Modal-->
        <x-modal_delete />

        <!-- Posts -->
        @foreach ($posts as $post)
            <div
                class="posts w-[80%] w-full max-w-2xl mx-auto my-6 p-6 bg-white dark:bg-gray-800 dark:border-gray-700 rounded-xl shadow-md border border-gray-200 
                            sm:px-4 sm:py-4 box-border overflow-hidden transition-all duration-300 transform hover:-translate-y-1 hover:scale-105 hover:shadow-lg cursor-pointer"
                            onclick="responderPost('{{ route('comments', $post->id) }}')">
                        <div class="flex items-start gap-4">
                    @php
                        $profileRoute =
                            auth()->user()->id == $post->user_id
                                ? route('profile.my_profile')
                                : route('profile.author_profile', $post->user->id);
                    @endphp
                    <a href="{{ $profileRoute }}">
                        <x-avatar :user="$post->user" />
                    </a>
                    <!-- Conteúdo do post -->
                        <x-posts :post="$post" />


                    <div class="mt-10">
                        <div class="absolute bottom-4 left-4 right-4 flex justify-between items-center" style="z-index: 1;">
                            <x-button-chat :post="$post" />

                            {{-- Botões de Like e Delete (à direita) --}}
                            <div class="flex space-x-4 items-center" style="z-index: 1;">
                                {{-- Botão de Like --}}
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

    </div>

    <!-- Botão de adicionar Post -->
    <x-button-add-post />

    <script src="{{ asset("js/modal_add_post.js") }}" defer></script>
    <script src="{{ asset('js/view_pdf.js') }}" defer></script>

    <!-- Script do modal de add e delete post -->
    <script>
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

                    const postId = button.dataset.postId; // ID do post a ser curtido
                    const liked = button.dataset.liked ===
                    '1'; // Verifica se o post já foi curtido
                    const likeCountElement = button.querySelector(
                    '.like-count'); // Elemento que mostra a quantidade de likes
                    const icon = button.querySelector('.like-icon'); // Ícone de like

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
                            likeable_type: 'post', // Tipo de conteúdo (post)
                            likeable_id: postId // ID do post
                        })
                    });

                    const data = await response.json();

                    // Atualiza o estado visual dependendo se foi curtido ou descurtido
                    button.dataset.liked = data.liked ? '1' :
                    '0'; // Atualiza o estado do "liked" no dataset
                    likeCountElement.textContent = data
                    .likes_count; // Atualiza a contagem de likes

                    if (data.liked) {
                        button.classList.add(
                        'text-red-500'); // Altera a cor do botão se foi curtido
                        likeCountElement.classList.remove(
                        'hidden'); // Exibe a quantidade de likes
                    } else {
                        button.classList.remove(
                        'text-red-500'); // Remove a cor do botão se foi descurtido
                        likeCountElement.classList.add(
                        'hidden'); // Esconde a contagem de likes se o post não foi curtido
                    }
                });
            });

            //Delete posts
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

            const input_title = document.getElementById("input_title");
            const char_count = document.getElementById("char_count_title");

            // Função para atualizar o contador de caracteres
            input_title.addEventListener("input", function() {
                const currentLength = input_title.value.length;
                char_count.textContent = `${currentLength}/60`; // Exibe "X/255"
            });

            const input_text = document.getElementById("input_text");
            const char_count2 = document.getElementById("char_count");

            // Função para atualizar o contador de caracteres
            input_text.addEventListener("input", function() {
                const currentLength = input_text.value.length;
                char_count2.textContent = `${currentLength}/1000`; // Exibe "X/255"
            });
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
