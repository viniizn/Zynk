<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:bg-gray-900 dark:text-white">
            {{ __('texts.notific') }}
        </h2>
    </x-slot>

    @foreach ($notifications as $notification)
        @php
            $type = $notification->type;
            $data = $notification->data;
            $authorId = $data['user_id'] ?? $data['follower_id'] ?? null;
            $author = $authorId ? \App\Models\User::find($authorId) : null;

            $link = match ($type) {
                \App\Notifications\UserFollowNotification::class => route("comments", $data["post_id"]),
                \App\Notifications\CommentLikedNotification::class => route("comments", $data["post_id"]) . "#comment-" . $data["comment_id"],
                default => $author ? route("profile.author_profile", $author) : '#',
            };

        @endphp

        <!-- Card com ação de clique -->
        <div 
            class="block w-[80%] max-w-2xl mx-auto my-6 p-6 bg-white dark:text-white dark:bg-gray-800 dark:border-gray-700 
                   rounded-xl shadow-md border border-gray-200 transition-all duration-300  
                   transform hover:-translate-y-1 hover:scale-105 hover:shadow-lg cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 relative"
                   onclick="goToComment('{{ $link }}')"
                   >
            <div class="flex items-center gap-4">
                {{-- Avatar com link para o perfil do autor --}}
                @if ($author)
                    <div>
                        <a href="{{ route('profile.author_profile', $author) }}">
                            @if (!$author->profile_photo)
                                <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                    {{ strtoupper(substr($author->name, 0, 1)) }}
                                </div>
                            @else
                                <img src="{{ asset('storage/' . $author->profile_photo) }}"
                                     alt="Foto de {{ $author->name }}"
                                     class="w-12 h-12 object-cover rounded-full"
                                     loading="lazy"/>
                            @endif
                        </a>
                    </div>
                @endif

                <div>
                    @if ($type === \App\Notifications\UserFollowNotification::class)
                        <strong>{{ $data['name'] }}</strong> {{__("texts.notificLike")}}
                        <em>"{{ $data['post_title'] }}"</em>
                    @elseif ($type === \App\Notifications\CommentLikedNotification::class)
                        <strong>{{ $data['name'] }}</strong> {{__("texts.notificLikeComment")}}
                        <em>"{{ $data['comment_excerpt'] }}"</em>
                    @elseif ($type === \App\Notifications\NewFollowNotification::class)
                        <strong>{{ $data['follower_name'] }}</strong> {{__("texts.notificFollow")}}
                    @else
                        <em>{{__("texts.notifcDesconhecido")}}</em>
                    @endif


                    <br>
                    <small class="text-gray-500 dark:text-white">{{ $notification->created_at->diffForHumans() }}</small>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        function goToComment(urlWithHash) {
            const [url, hash] = urlWithHash.split('#');
    
            // Navega até o post SEM o hash (para impedir o scroll automático do navegador)
            window.location = url;
    
            // Armazena o hash para usar depois, quando o DOM estiver carregado
            if (hash) {
                sessionStorage.setItem('scrollToCommentHash', '#' + hash);
            }
        }
    
        document.addEventListener("DOMContentLoaded", function () {
            const hash = sessionStorage.getItem('scrollToCommentHash');
    
            if (hash && hash.startsWith("#comment-")) {
                sessionStorage.removeItem('scrollToCommentHash');
    
                // Primeiro sobe pro topo (caso a página já esteja no hash)
                window.scrollTo({ top: 0, behavior: 'auto' });
    
                // Aguarda o DOM e desce suavemente depois
                setTimeout(() => {
                    const tryScroll = () => {
                        const target = document.querySelector(hash);
                        if (target) {
                            target.scrollIntoView({
                                behavior: "smooth",
                                block: "center"
                            });
    
                            // Efeito visual
                            target.style.transition = "background-color 0.6s ease";
                            target.style.backgroundColor = "#f9f9f9";
                            setTimeout(() => {
                                target.style.backgroundColor = "";
                            }, 1500);
    
                            clearInterval(checkExist);
                        }
                    };
    
                    const checkExist = setInterval(tryScroll, 100);
                    setTimeout(() => clearInterval(checkExist), 3000);
                }, 300); // Pequeno delay antes de procurar o comentário
            }
        });
    </script>
    
</x-app-layout>
