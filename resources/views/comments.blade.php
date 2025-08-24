<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:bg-gray-900 dark:text-white">
            {{ __('texts.comentarios') }}

        </h2>
    </x-slot>

    <!-- Deletar post Modal-->
    <div id="delete-modal_comment" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 hidden">
        <!-- Wrapper para detectar clique fora do form -->
        <div id="delete-modal-content_comment" class="sm:w-[60%] w-full max-w-3xl mx-auto">
            <form id="delete_form_comment" method="POST"
            class="bg-gradient-to-br from-white via-gray-50 to-white 
            dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 
            p-8 rounded-2xl shadow-xl 
            border border-gray-200 dark:border-gray-700">
                @csrf
                @method('DELETE')
                <div class="mb-6">
                    <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ __("texts.excluirPost")}}</h2>
                    <h3 class="text-xl text-red-500 mt-1">{{ __("texts.excluirPostDesc")}}</h3>
                </div>
    
                <div class="flex justify-center gap-3">
                    <button type="button" id="cancel-delete_comment"
                        class="px-4 py-2 w-[40%] bg-gray-200 hover:bg-gray-300 rounded-lg">{{ __("texts.cancel")}}</button>
                    <button type="submit"
                    class="px-4 py-2 w-[40%] text-red-600 border border-red-600 hover:bg-red-600 hover:text-white rounded-lg">{{ __("texts.excluir")}}</button>
                </div>
            </form>
        </div>
    </div>

    <div
    class="w-[80%] w-full sm:max-w-[80%] mx-auto my-6 p-6 bg-white dark:bg-gray-800 dark:border-gray-700 rounded-xl shadow-md border border-gray-200 
            sm:px-4 sm:py-4 box-border overflow-hidden transition-all duration-300 transform hover:-translate-y-1 hover:scale-105 hover:shadow-lg cursor-pointer">
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
        <div class="flex-1 p-3 -ml-5 sm:-ml-3">

            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 sm:gap-0">
                <h2 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $post->user->name }}</h2>
                <span class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
            </div>
            <p class="text-sm sm:text-md text-gray-500">{{ '@' . $post->user->username }}</p>
        
        
            <hr class="mt-3 mb-2 border-gray-300 dark:border-gray-700">
        
            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $post->title }}</h3>
        
            <p class="text-sm sm:text-base text-gray-700 dark:text-gray-100 leading-relaxed whitespace-pre-wrap 
            sm:break-words hyphens-auto max-w-full sm:max-w-[900px] mt-2 mb-5">{{ $post->description }}</p>
        
                @if (!empty($post->img_path))
                    <img src="{{ asset('storage/' . $post->img_path) }}"
                    class="w-full max-w-lg rounded-xl mb-4 object-cover aspect-video" />
                @endif
        
                @if (!empty($post->video_path))
                    <video controls class="w-full max-w-lg rounded-xl mb-4 object-cover aspect-video">
                        <source src="{{ asset('storage/' . $post->video_path) }}" type="video/mp4" />
                        Seu navegador não suporta vídeo.
                    </video>
                @endif
        
                @if (!empty($post->doc_path))
                    @php
                        $filename = basename($post->doc_path);
                        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                        $fileUrl = asset('storage/' . $post->doc_path);
        
                        $fileTypes = [
                            'pdf' => [
                                'label' => __("texts.arquivo") . " PDF",
                                'icon' =>
                                    '<svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="-4 0 40 40" fill="none">
                                    <path d="M25.6686 26.0962C25.1812 26.2401 24.4656 26.2563 23.6984 26.145C22.875 26.0256 22.0351 25.7739 21.2096 25.403C22.6817 25.1888 23.8237 25.2548 24.8005 25.6009C25.0319 25.6829 25.412 25.9021 25.6686 26.0962ZM17.4552 24.7459C17.3953 24.7622 17.3363 24.7776 17.2776 24.7939C16.8815 24.9017 16.4961 25.0069 16.1247 25.1005L15.6239 25.2275C14.6165 25.4824 13.5865 25.7428 12.5692 26.0529C12.9558 25.1206 13.315 24.178 13.6667 23.2564C13.9271 22.5742 14.193 21.8773 14.468 21.1894C14.6075 21.4198 14.7531 21.6503 14.9046 21.8814C15.5948 22.9326 16.4624 23.9045 17.4552 24.7459ZM14.8927 14.2326C14.958 15.383 14.7098 16.4897 14.3457 17.5514C13.8972 16.2386 13.6882 14.7889 14.2489 13.6185C14.3927 13.3185 14.5105 13.1581 14.5869 13.0744C14.7049 13.2566 14.8601 13.6642 14.8927 14.2326ZM9.63347 28.8054C9.38148 29.2562 9.12426 29.6782 8.86063 30.0767C8.22442 31.0355 7.18393 32.0621 6.64941 32.0621C6.59681 32.0621 6.53316 32.0536 6.44015 31.9554C6.38028 31.8926 6.37069 31.8476 6.37359 31.7862C6.39161 31.4337 6.85867 30.8059 7.53527 30.2238C8.14939 29.6957 8.84352 29.2262 9.63347 28.8054ZM27.3706 26.1461C27.2889 24.9719 25.3123 24.2186 25.2928 24.2116C24.5287 23.9407 23.6986 23.8091 22.7552 23.8091C21.7453 23.8091 20.6565 23.9552 19.2582 24.2819C18.014 23.3999 16.9392 22.2957 16.1362 21.0733C15.7816 20.5332 15.4628 19.9941 15.1849 19.4675C15.8633 17.8454 16.4742 16.1013 16.3632 14.1479C16.2737 12.5816 15.5674 11.5295 14.6069 11.5295C13.948 11.5295 13.3807 12.0175 12.9194 12.9813C12.0965 14.6987 12.3128 16.8962 13.562 19.5184C13.1121 20.5751 12.6941 21.6706 12.2895 22.7311C11.7861 24.0498 11.2674 25.4103 10.6828 26.7045C9.04334 27.3532 7.69648 28.1399 6.57402 29.1057C5.8387 29.7373 4.95223 30.7028 4.90163 31.7107C4.87693 32.1854 5.03969 32.6207 5.37044 32.9695C5.72183 33.3398 6.16329 33.5348 6.6487 33.5354C8.25189 33.5354 9.79489 31.3327 10.0876 30.8909C10.6767 30.0029 11.2281 29.0124 11.7684 27.8699C13.1292 27.3781 14.5794 27.011 15.985 26.6562L16.4884 26.5283C16.8668 26.4321 17.2601 26.3257 17.6635 26.2153C18.0904 26.0999 18.5296 25.9802 18.976 25.8665C20.4193 26.7844 21.9714 27.3831 23.4851 27.6028C24.7601 27.7883 25.8924 27.6807 26.6589 27.2811C27.3486 26.9219 27.3866 26.3676 27.3706 26.1461ZM30.4755 36.2428C30.4755 38.3932 28.5802 38.5258 28.1978 38.5301H3.74486C1.60224 38.5301 1.47322 36.6218 1.46913 36.2428L1.46884 3.75642C1.46884 1.6039 3.36763 1.4734 3.74457 1.46908H20.263L20.2718 1.4778V7.92396C20.2718 9.21763 21.0539 11.6669 24.0158 11.6669H30.4203L30.4753 11.7218L30.4755 36.2428ZM28.9572 10.1976H24.0169C21.8749 10.1976 21.7453 8.29969 21.7424 7.92417V2.95307L28.9572 10.1976ZM31.9447 36.2428V11.1157L21.7424 0.871022V0.823357H21.6936L20.8742 0H3.74491C2.44954 0 0 0.785336 0 3.75711V36.2435C0 37.5427 0.782956 40 3.74491 40H28.2001C29.4952 39.9997 31.9447 39.2143 31.9447 36.2428Z" fill="#EB5757"/>
                                    </svg>',
                            ],
                            'doc' => [
                                'label' => __("texts.documento") . " Word",
                                'icon' =>
                                    'http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32px" height="32px" viewBox="0 0 32 32"><defs><linearGradient id="a" x1="4.494" y1="-1712.086" x2="13.832" y2="-1695.914" gradientTransform="translate(0 1720)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#2368c4"/><stop offset="0.5" stop-color="#1a5dbe"/><stop offset="1" stop-color="#1146ac"/></linearGradient></defs><title>file_type_word</title><path d="M28.806,3H9.705A1.192,1.192,0,0,0,8.512,4.191h0V9.5l11.069,3.25L30,9.5V4.191A1.192,1.192,0,0,0,28.806,3Z" style="fill:#41a5ee"/><path d="M30,9.5H8.512V16l11.069,1.95L30,16Z" style="fill:#2b7cd3"/><path d="M8.512,16v6.5L18.93,23.8,30,22.5V16Z" style="fill:#185abd"/><path d="M9.705,29h19.1A1.192,1.192,0,0,0,30,27.809h0V22.5H8.512v5.309A1.192,1.192,0,0,0,9.705,29Z" style="fill:#103f91"/><path d="M16.434,8.2H8.512V24.45h7.922a1.2,1.2,0,0,0,1.194-1.191V9.391A1.2,1.2,0,0,0,16.434,8.2Z" style="opacity:0.10000000149011612;isolation:isolate"/><path d="M15.783,8.85H8.512V25.1h7.271a1.2,1.2,0,0,0,1.194-1.191V10.041A1.2,1.2,0,0,0,15.783,8.85Z" style="opacity:0.20000000298023224;isolation:isolate"/><path d="M15.783,8.85H8.512V23.8h7.271a1.2,1.2,0,0,0,1.194-1.191V10.041A1.2,1.2,0,0,0,15.783,8.85Z" style="opacity:0.20000000298023224;isolation:isolate"/><path d="M15.132,8.85H8.512V23.8h6.62a1.2,1.2,0,0,0,1.194-1.191V10.041A1.2,1.2,0,0,0,15.132,8.85Z" style="opacity:0.20000000298023224;isolation:isolate"/><path d="M3.194,8.85H15.132a1.193,1.193,0,0,1,1.194,1.191V21.959a1.193,1.193,0,0,1-1.194,1.191H3.194A1.192,1.192,0,0,1,2,21.959V10.041A1.192,1.192,0,0,1,3.194,8.85Z" style="fill:url(#a)"/><path d="M6.9,17.988c.023.184.039.344.046.481h.028c.01-.13.032-.287.065-.47s.062-.338.089-.465l1.255-5.407h1.624l1.3,5.326a7.761,7.761,0,0,1,.162,1h.022a7.6,7.6,0,0,1,.135-.975l1.039-5.358h1.477l-1.824,7.748H10.591L9.354,14.742q-.054-.222-.122-.578t-.084-.52H9.127q-.021.189-.084.561c-.042.249-.075.432-.1.552L7.78,19.871H6.024L4.19,12.127h1.5l1.131,5.418A4.469,4.469,0,0,1,6.9,17.988Z" style="fill:#fff"/></svg>',
                            ],
                            'docx' => [
                                'label' => __("texts.documento") . " Word",
                                'icon' =>
                                '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32px" height="32px" viewBox="0 0 32 32"><defs><linearGradient id="a" x1="4.494" y1="-1712.086" x2="13.832" y2="-1695.914" gradientTransform="translate(0 1720)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#2368c4"/><stop offset="0.5" stop-color="#1a5dbe"/><stop offset="1" stop-color="#1146ac"/></linearGradient></defs><title>file_type_word</title><path d="M28.806,3H9.705A1.192,1.192,0,0,0,8.512,4.191h0V9.5l11.069,3.25L30,9.5V4.191A1.192,1.192,0,0,0,28.806,3Z" style="fill:#41a5ee"/><path d="M30,9.5H8.512V16l11.069,1.95L30,16Z" style="fill:#2b7cd3"/><path d="M8.512,16v6.5L18.93,23.8,30,22.5V16Z" style="fill:#185abd"/><path d="M9.705,29h19.1A1.192,1.192,0,0,0,30,27.809h0V22.5H8.512v5.309A1.192,1.192,0,0,0,9.705,29Z" style="fill:#103f91"/><path d="M16.434,8.2H8.512V24.45h7.922a1.2,1.2,0,0,0,1.194-1.191V9.391A1.2,1.2,0,0,0,16.434,8.2Z" style="opacity:0.10000000149011612;isolation:isolate"/><path d="M15.783,8.85H8.512V25.1h7.271a1.2,1.2,0,0,0,1.194-1.191V10.041A1.2,1.2,0,0,0,15.783,8.85Z" style="opacity:0.20000000298023224;isolation:isolate"/><path d="M15.783,8.85H8.512V23.8h7.271a1.2,1.2,0,0,0,1.194-1.191V10.041A1.2,1.2,0,0,0,15.783,8.85Z" style="opacity:0.20000000298023224;isolation:isolate"/><path d="M15.132,8.85H8.512V23.8h6.62a1.2,1.2,0,0,0,1.194-1.191V10.041A1.2,1.2,0,0,0,15.132,8.85Z" style="opacity:0.20000000298023224;isolation:isolate"/><path d="M3.194,8.85H15.132a1.193,1.193,0,0,1,1.194,1.191V21.959a1.193,1.193,0,0,1-1.194,1.191H3.194A1.192,1.192,0,0,1,2,21.959V10.041A1.192,1.192,0,0,1,3.194,8.85Z" style="fill:url(#a)"/><path d="M6.9,17.988c.023.184.039.344.046.481h.028c.01-.13.032-.287.065-.47s.062-.338.089-.465l1.255-5.407h1.624l1.3,5.326a7.761,7.761,0,0,1,.162,1h.022a7.6,7.6,0,0,1,.135-.975l1.039-5.358h1.477l-1.824,7.748H10.591L9.354,14.742q-.054-.222-.122-.578t-.084-.52H9.127q-.021.189-.084.561c-.042.249-.075.432-.1.552L7.78,19.871H6.024L4.19,12.127h1.5l1.131,5.418A4.469,4.469,0,0,1,6.9,17.988Z" style="fill:#fff"/></svg>',
                            ],
                            'zip' => [
                                'label' => __("texts.arquivo") . " ZIP",
                                'icon' =>
                                    '<svg xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://www.w3.org/2000/svg" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" width="32px" height="32px" viewBox="0 0 24 24" version="1.1">
                                    <g transform="translate(0 -1028.4)">
                                    <path d="m5 1030.4c-1.1046 0-2 0.9-2 2v8 4 6c0 1.1 0.8954 2 2 2h14c1.105 0 2-0.9 2-2v-6-4-4l-6-6h-10z" fill="#95a5a6"/>
                                    <path d="m5 1029.4c-1.1046 0-2 0.9-2 2v8 4 6c0 1.1 0.8954 2 2 2h14c1.105 0 2-0.9 2-2v-6-4-4l-6-6h-10z" fill="#bdc3c7"/>
                                    <path d="m21 1035.4-6-6v4c0 1.1 0.895 2 2 2h4z" fill="#95a5a6"/>
                                    <path d="m12 1041.4c-1.105 0-2 0.9-2 2v4c0 1.1 0.895 2 2 2s2-0.9 2-2v-4c0-1.1-0.895-2-2-2zm0 1c0.552 0 1 0.4 1 1 0 0.5-0.448 1-1 1s-1-0.5-1-1c0-0.6 0.448-1 1-1zm0 3c0.552 0 1 0.4 1 1v1c0 0.5-0.448 1-1 1s-1-0.5-1-1v-1c0-0.6 0.448-1 1-1z" fill="#bdc3c7"/>
                                    <path d="m10 1029.4v10c0 1.1 0.895 2 2 2s2-0.9 2-2v-10h-4z" fill="#7f8c8d"/>
                                    <path d="m12 1029.4v1h1v-1h-1zm0 1h-1v1h1v-1zm0 1v1h1v-1h-1zm0 1h-1v1h1v-1zm0 1v1h1v-1h-1zm0 1h-1v1h1v-1zm0 1v1h1v-1h-1zm0 1h-1v1h1v-1zm0 1v1h1v-1h-1zm0 1h-1v1h1v-1zm0 1v1c0.552 0 1-0.5 1-1h-1z" fill="#95a5a6"/>
                                    <path d="m11 1029.4v1h1v-1h-1zm0 2v1h1v-1h-1zm0 2v1h1v-1h-1zm0 2v1h1v-1h-1zm0 2v1h1v-1h-1zm0 2c0 0.5 0.448 1 1 1v-1h-1z" fill="#ecf0f1"/>
                                    <path d="m12 1041.4c-1.105 0-2 0.9-2 2v4c0 1.1 0.895 2 2 2s2-0.9 2-2v-4c0-1.1-0.895-2-2-2zm0 1c0.552 0 1 0.4 1 1 0 0.5-0.448 1-1 1s-1-0.5-1-1c0-0.6 0.448-1 1-1zm0 3c0.552 0 1 0.4 1 1v1c0 0.5-0.448 1-1 1s-1-0.5-1-1v-1c0-0.6 0.448-1 1-1z" fill="#95a5a6"/>
                                    <path d="m12 1040.4c-1.105 0-2 0.9-2 2v4c0 1.1 0.895 2 2 2s2-0.9 2-2v-4c0-1.1-0.895-2-2-2zm0 1c0.552 0 1 0.4 1 1 0 0.5-0.448 1-1 1s-1-0.5-1-1c0-0.6 0.448-1 1-1zm0 3c0.552 0 1 0.4 1 1v1c0 0.5-0.448 1-1 1s-1-0.5-1-1v-1c0-0.6 0.448-1 1-1z" fill="#ecf0f1"/>
                                    </g>
                                    </svg>',
                            ],
                        ];
        
                        $fileLabel = $fileTypes[$extension]['label'] ?? 'Arquivo';
                        $fileIcon =
                            $fileTypes[$extension]['icon'] ??
                            '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#828282" viewBox="0 0 24 24"><path d="M6 2a2 2 0 00-2 2v16c0 1.104.896 2 2 2h12a2 2 0 002-2V8l-6-6H6z"/></svg>';
                    @endphp
        
                    <a href="{{ $fileUrl }}" target="_blank" download
                        class="flex items-center space-x-3 p-3 border border-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:border-gray-600 transition cursor-pointer w-full max-w-xs"
                        style="position: relative; z-index: 10;">
                        {!! $fileIcon !!}
                        <div>
                            <p class="font-semibold text-gray-700 truncate max-w-[200px] dark:text-white">{{ $fileLabel }}</p>
                            <p class="text-xs text-gray-500">{{__("texts.clickDocument")}}</p>
                        </div>
                    </a>
                @endif
            <div class="mt-10">
                <div class="absolute bottom-4 left-4 right-4 flex justify-between items-center">
                    {{-- Botão de Chat (à esquerda) --}}
                    <div class="container-chat">
                        <button id="botao-add-comment"
                            class="text-gray-500 hover:text-white 
                                hover:bg-blue-600 rounded-full w-10 h-10 flex items-center justify-center 
                                shadow-md hover:shadow-xl transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M12 2.25c-2.429 0-4.817.178-7.152.521C2.87 3.061 1.5 4.795 1.5 6.741v6.018c0 1.946 1.37 3.68 3.348 3.97.877.129 1.761.234 2.652.316V21a.75.75 0 0 0 1.28.53l4.184-4.183a.39.39 0 0 1 .266-.112c2.006-.05 3.982-.22 5.922-.506 1.978-.29 3.348-2.023 3.348-3.97V6.741c0-1.947-1.37-3.68-3.348-3.97A49.145 49.145 0 0 0 12 2.25ZM8.25 8.625a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Zm2.625 1.125a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Zm4.875-1.125a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Z" clip-rule="evenodd" />
                            </svg>  
                            @if ($post->comments->count() > 0)
                                <span class="like-count ml-1 text-sm font-medium font-sans">
                                    {{ $post->comments->count() }}
                                </span>
                            @endif                                                                                                                        
                        </button>
                    </div>
                
                    {{-- Botões de Like e Delete (à direita) --}}
                    <div class="flex space-x-4 items-center">
                        {{-- Botão de Like --}}
                        <button 
                            class="like-button text-gray-500 hover:text-white 
                                hover:bg-red-500 rounded-full w-10 h-10 flex items-center justify-center 
                                shadow-md hover:shadow-xl transition-all duration-300
                                {{ $post->isLikedBy(auth()->user()) ? 'text-red-500' : '' }}"
                            data-post-id="{{ $post->id }}"
                            data-liked="{{ $post->isLikedBy(auth()->user()) ? '1' : '0' }}" 
                            data-like-type="post"
                            data-like-count="{{ $post->likes->count() }}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" 
                                fill="currentColor" 
                                class="like-icon size-6 transition-transform duration-300 ease-out">
                                <path d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 
                            25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 
                            2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 
                            5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 
                            0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 
                            15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 
                            0 0 1-.704 0l-.003-.001Z" />
                            </svg>
                            <span class="like-count ml-1 text-sm font-medium font-sans {{ $post->isLikedBy(auth()->user()) ? 'block' : 'hidden' }}">
                                {{ $post->likes->count() }}
                            </span>
                        </button>
                
                        {{-- Botão de Deletar (aparece só se for dono do post) --}}
                        @if (auth()->user()->id == $post->user_id)
                        <button class="open-delete-modal text-gray-500 hover:text-white hover:bg-red-500 rounded-full w-10 h-10 flex items-center justify-center shadow-md hover:shadow-xl transition-all duration-300"
                                data-id="{{ $post->id }}"
                                data-title="{{ $post->title }}">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                class="w-5 h-5 transition-colors duration-300">
                                <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                                clip-rule="evenodd" />
                            </svg>
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Deletar post Modal-->
<x-modal_delete />

<div class="max-w-[90%] sm:max-w-[70%] mx-auto mt-10">
    {{-- Comentários --}}
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg p-6 transition-all duration-300">
        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">{{ __('texts.comentarios') }}</h3>

        @forelse ($post->comments as $comment)
            <div class="w-full max-w-2xl mx-auto my-6 p-5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-md transition-all duration-300 transform hover:-translate-y-1 hover:scale-105 hover:shadow-lg">
                <div id="comment-{{ $comment->id }}" class="">

                <div class="flex items-start gap-4">
                    @php
                        $profileRoute = auth()->user()->id == $comment->user_id
                            ? route('profile.my_profile')
                            : route('profile.author_profile', $comment->user->id);
                    @endphp

                    <a href="{{ $profileRoute }}">
                        {{-- Avatar dinâmico --}}
                        @if (!$comment->user->profile_photo)
                            <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                            </div>
                        @else
                            <img src="{{ asset('storage/' . $comment->user->profile_photo) }}"
                                alt="Foto de perfil"
                                class="w-12 h-12 object-cover rounded-full" />
                        @endif
                    </a>

                    <div class="flex-1">
                            {{-- Nome e data --}}
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                                <h2 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $comment->user->name }}</h2>
                                <span class="text-sm text-gray-500 mt-1 sm:mt-0">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm sm:text-md text-gray-500">{{ '@' . $comment->user->username }}</p>


                            <hr class="mt-3 mb-2 border-gray-300 dark:border-gray-700">

                            {{-- Corpo do comentário --}}
                            <p class="text-sm sm:text-base text-gray-700 dark:text-gray-100 leading-relaxed whitespace-pre-wrap break-words mt-2 mb-4">{{ $comment->body }}</p>

                            {{-- Imagem do comentário (responsiva, como nos posts) --}}
                            @if (!empty($comment->img_path))
                                <img src="{{ asset('storage/' . $comment->img_path) }}"
                                    class="w-full max-w-lg rounded-xl mb-4 object-cover aspect-video" />
                            @endif

                            {{-- Vídeo do comentário (idem) --}}
                            @if (!empty($comment->video_path))
                                <video controls class="w-full max-w-lg rounded-xl mb-4 object-cover aspect-video">
                                    <source src="{{ asset('storage/' . $comment->video_path) }}" type="video/mp4" />
                                    Seu navegador não suporta vídeo.
                                </video>
                            @endif
                
                            @if (!empty($comment->doc_path))
                                @php
                                    $filename = basename($comment->doc_path);
                                    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                                    $fileUrl = asset('storage/' . $comment->doc_path);
                    
                                    $fileTypes = [
                                        'pdf' => [
                                            'label' => __("texts.arquivo") . " PDF",
                                            'icon' =>
                                                '<svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="-4 0 40 40" fill="none">
                                                <path d="M25.6686 26.0962C25.1812 26.2401 24.4656 26.2563 23.6984 26.145C22.875 26.0256 22.0351 25.7739 21.2096 25.403C22.6817 25.1888 23.8237 25.2548 24.8005 25.6009C25.0319 25.6829 25.412 25.9021 25.6686 26.0962ZM17.4552 24.7459C17.3953 24.7622 17.3363 24.7776 17.2776 24.7939C16.8815 24.9017 16.4961 25.0069 16.1247 25.1005L15.6239 25.2275C14.6165 25.4824 13.5865 25.7428 12.5692 26.0529C12.9558 25.1206 13.315 24.178 13.6667 23.2564C13.9271 22.5742 14.193 21.8773 14.468 21.1894C14.6075 21.4198 14.7531 21.6503 14.9046 21.8814C15.5948 22.9326 16.4624 23.9045 17.4552 24.7459ZM14.8927 14.2326C14.958 15.383 14.7098 16.4897 14.3457 17.5514C13.8972 16.2386 13.6882 14.7889 14.2489 13.6185C14.3927 13.3185 14.5105 13.1581 14.5869 13.0744C14.7049 13.2566 14.8601 13.6642 14.8927 14.2326ZM9.63347 28.8054C9.38148 29.2562 9.12426 29.6782 8.86063 30.0767C8.22442 31.0355 7.18393 32.0621 6.64941 32.0621C6.59681 32.0621 6.53316 32.0536 6.44015 31.9554C6.38028 31.8926 6.37069 31.8476 6.37359 31.7862C6.39161 31.4337 6.85867 30.8059 7.53527 30.2238C8.14939 29.6957 8.84352 29.2262 9.63347 28.8054ZM27.3706 26.1461C27.2889 24.9719 25.3123 24.2186 25.2928 24.2116C24.5287 23.9407 23.6986 23.8091 22.7552 23.8091C21.7453 23.8091 20.6565 23.9552 19.2582 24.2819C18.014 23.3999 16.9392 22.2957 16.1362 21.0733C15.7816 20.5332 15.4628 19.9941 15.1849 19.4675C15.8633 17.8454 16.4742 16.1013 16.3632 14.1479C16.2737 12.5816 15.5674 11.5295 14.6069 11.5295C13.948 11.5295 13.3807 12.0175 12.9194 12.9813C12.0965 14.6987 12.3128 16.8962 13.562 19.5184C13.1121 20.5751 12.6941 21.6706 12.2895 22.7311C11.7861 24.0498 11.2674 25.4103 10.6828 26.7045C9.04334 27.3532 7.69648 28.1399 6.57402 29.1057C5.8387 29.7373 4.95223 30.7028 4.90163 31.7107C4.87693 32.1854 5.03969 32.6207 5.37044 32.9695C5.72183 33.3398 6.16329 33.5348 6.6487 33.5354C8.25189 33.5354 9.79489 31.3327 10.0876 30.8909C10.6767 30.0029 11.2281 29.0124 11.7684 27.8699C13.1292 27.3781 14.5794 27.011 15.985 26.6562L16.4884 26.5283C16.8668 26.4321 17.2601 26.3257 17.6635 26.2153C18.0904 26.0999 18.5296 25.9802 18.976 25.8665C20.4193 26.7844 21.9714 27.3831 23.4851 27.6028C24.7601 27.7883 25.8924 27.6807 26.6589 27.2811C27.3486 26.9219 27.3866 26.3676 27.3706 26.1461ZM30.4755 36.2428C30.4755 38.3932 28.5802 38.5258 28.1978 38.5301H3.74486C1.60224 38.5301 1.47322 36.6218 1.46913 36.2428L1.46884 3.75642C1.46884 1.6039 3.36763 1.4734 3.74457 1.46908H20.263L20.2718 1.4778V7.92396C20.2718 9.21763 21.0539 11.6669 24.0158 11.6669H30.4203L30.4753 11.7218L30.4755 36.2428ZM28.9572 10.1976H24.0169C21.8749 10.1976 21.7453 8.29969 21.7424 7.92417V2.95307L28.9572 10.1976ZM31.9447 36.2428V11.1157L21.7424 0.871022V0.823357H21.6936L20.8742 0H3.74491C2.44954 0 0 0.785336 0 3.75711V36.2435C0 37.5427 0.782956 40 3.74491 40H28.2001C29.4952 39.9997 31.9447 39.2143 31.9447 36.2428Z" fill="#EB5757"/>
                                                </svg>',
                                        ],
                                        'doc' => [
                                            'label' => __("texts.documento") . " Word",
                                            'icon' =>
                                                'http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32px" height="32px" viewBox="0 0 32 32"><defs><linearGradient id="a" x1="4.494" y1="-1712.086" x2="13.832" y2="-1695.914" gradientTransform="translate(0 1720)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#2368c4"/><stop offset="0.5" stop-color="#1a5dbe"/><stop offset="1" stop-color="#1146ac"/></linearGradient></defs><title>file_type_word</title><path d="M28.806,3H9.705A1.192,1.192,0,0,0,8.512,4.191h0V9.5l11.069,3.25L30,9.5V4.191A1.192,1.192,0,0,0,28.806,3Z" style="fill:#41a5ee"/><path d="M30,9.5H8.512V16l11.069,1.95L30,16Z" style="fill:#2b7cd3"/><path d="M8.512,16v6.5L18.93,23.8,30,22.5V16Z" style="fill:#185abd"/><path d="M9.705,29h19.1A1.192,1.192,0,0,0,30,27.809h0V22.5H8.512v5.309A1.192,1.192,0,0,0,9.705,29Z" style="fill:#103f91"/><path d="M16.434,8.2H8.512V24.45h7.922a1.2,1.2,0,0,0,1.194-1.191V9.391A1.2,1.2,0,0,0,16.434,8.2Z" style="opacity:0.10000000149011612;isolation:isolate"/><path d="M15.783,8.85H8.512V25.1h7.271a1.2,1.2,0,0,0,1.194-1.191V10.041A1.2,1.2,0,0,0,15.783,8.85Z" style="opacity:0.20000000298023224;isolation:isolate"/><path d="M15.783,8.85H8.512V23.8h7.271a1.2,1.2,0,0,0,1.194-1.191V10.041A1.2,1.2,0,0,0,15.783,8.85Z" style="opacity:0.20000000298023224;isolation:isolate"/><path d="M15.132,8.85H8.512V23.8h6.62a1.2,1.2,0,0,0,1.194-1.191V10.041A1.2,1.2,0,0,0,15.132,8.85Z" style="opacity:0.20000000298023224;isolation:isolate"/><path d="M3.194,8.85H15.132a1.193,1.193,0,0,1,1.194,1.191V21.959a1.193,1.193,0,0,1-1.194,1.191H3.194A1.192,1.192,0,0,1,2,21.959V10.041A1.192,1.192,0,0,1,3.194,8.85Z" style="fill:url(#a)"/><path d="M6.9,17.988c.023.184.039.344.046.481h.028c.01-.13.032-.287.065-.47s.062-.338.089-.465l1.255-5.407h1.624l1.3,5.326a7.761,7.761,0,0,1,.162,1h.022a7.6,7.6,0,0,1,.135-.975l1.039-5.358h1.477l-1.824,7.748H10.591L9.354,14.742q-.054-.222-.122-.578t-.084-.52H9.127q-.021.189-.084.561c-.042.249-.075.432-.1.552L7.78,19.871H6.024L4.19,12.127h1.5l1.131,5.418A4.469,4.469,0,0,1,6.9,17.988Z" style="fill:#fff"/></svg>',
                                        ],
                                        'docx' => [
                                            'label' => __("texts.documento") . " Word",
                                            'icon' =>
                                            '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32px" height="32px" viewBox="0 0 32 32"><defs><linearGradient id="a" x1="4.494" y1="-1712.086" x2="13.832" y2="-1695.914" gradientTransform="translate(0 1720)" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#2368c4"/><stop offset="0.5" stop-color="#1a5dbe"/><stop offset="1" stop-color="#1146ac"/></linearGradient></defs><title>file_type_word</title><path d="M28.806,3H9.705A1.192,1.192,0,0,0,8.512,4.191h0V9.5l11.069,3.25L30,9.5V4.191A1.192,1.192,0,0,0,28.806,3Z" style="fill:#41a5ee"/><path d="M30,9.5H8.512V16l11.069,1.95L30,16Z" style="fill:#2b7cd3"/><path d="M8.512,16v6.5L18.93,23.8,30,22.5V16Z" style="fill:#185abd"/><path d="M9.705,29h19.1A1.192,1.192,0,0,0,30,27.809h0V22.5H8.512v5.309A1.192,1.192,0,0,0,9.705,29Z" style="fill:#103f91"/><path d="M16.434,8.2H8.512V24.45h7.922a1.2,1.2,0,0,0,1.194-1.191V9.391A1.2,1.2,0,0,0,16.434,8.2Z" style="opacity:0.10000000149011612;isolation:isolate"/><path d="M15.783,8.85H8.512V25.1h7.271a1.2,1.2,0,0,0,1.194-1.191V10.041A1.2,1.2,0,0,0,15.783,8.85Z" style="opacity:0.20000000298023224;isolation:isolate"/><path d="M15.783,8.85H8.512V23.8h7.271a1.2,1.2,0,0,0,1.194-1.191V10.041A1.2,1.2,0,0,0,15.783,8.85Z" style="opacity:0.20000000298023224;isolation:isolate"/><path d="M15.132,8.85H8.512V23.8h6.62a1.2,1.2,0,0,0,1.194-1.191V10.041A1.2,1.2,0,0,0,15.132,8.85Z" style="opacity:0.20000000298023224;isolation:isolate"/><path d="M3.194,8.85H15.132a1.193,1.193,0,0,1,1.194,1.191V21.959a1.193,1.193,0,0,1-1.194,1.191H3.194A1.192,1.192,0,0,1,2,21.959V10.041A1.192,1.192,0,0,1,3.194,8.85Z" style="fill:url(#a)"/><path d="M6.9,17.988c.023.184.039.344.046.481h.028c.01-.13.032-.287.065-.47s.062-.338.089-.465l1.255-5.407h1.624l1.3,5.326a7.761,7.761,0,0,1,.162,1h.022a7.6,7.6,0,0,1,.135-.975l1.039-5.358h1.477l-1.824,7.748H10.591L9.354,14.742q-.054-.222-.122-.578t-.084-.52H9.127q-.021.189-.084.561c-.042.249-.075.432-.1.552L7.78,19.871H6.024L4.19,12.127h1.5l1.131,5.418A4.469,4.469,0,0,1,6.9,17.988Z" style="fill:#fff"/></svg>',
                                        ],
                                        'zip' => [
                                            'label' => __("texts.arquivo") . " ZIP",
                                            'icon' =>
                                                '<svg xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://www.w3.org/2000/svg" xmlns:cc="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" width="32px" height="32px" viewBox="0 0 24 24" version="1.1">
                                                <g transform="translate(0 -1028.4)">
                                                <path d="m5 1030.4c-1.1046 0-2 0.9-2 2v8 4 6c0 1.1 0.8954 2 2 2h14c1.105 0 2-0.9 2-2v-6-4-4l-6-6h-10z" fill="#95a5a6"/>
                                                <path d="m5 1029.4c-1.1046 0-2 0.9-2 2v8 4 6c0 1.1 0.8954 2 2 2h14c1.105 0 2-0.9 2-2v-6-4-4l-6-6h-10z" fill="#bdc3c7"/>
                                                <path d="m21 1035.4-6-6v4c0 1.1 0.895 2 2 2h4z" fill="#95a5a6"/>
                                                <path d="m12 1041.4c-1.105 0-2 0.9-2 2v4c0 1.1 0.895 2 2 2s2-0.9 2-2v-4c0-1.1-0.895-2-2-2zm0 1c0.552 0 1 0.4 1 1 0 0.5-0.448 1-1 1s-1-0.5-1-1c0-0.6 0.448-1 1-1zm0 3c0.552 0 1 0.4 1 1v1c0 0.5-0.448 1-1 1s-1-0.5-1-1v-1c0-0.6 0.448-1 1-1z" fill="#bdc3c7"/>
                                                <path d="m10 1029.4v10c0 1.1 0.895 2 2 2s2-0.9 2-2v-10h-4z" fill="#7f8c8d"/>
                                                <path d="m12 1029.4v1h1v-1h-1zm0 1h-1v1h1v-1zm0 1v1h1v-1h-1zm0 1h-1v1h1v-1zm0 1v1h1v-1h-1zm0 1h-1v1h1v-1zm0 1v1h1v-1h-1zm0 1h-1v1h1v-1zm0 1v1h1v-1h-1zm0 1h-1v1h1v-1zm0 1v1c0.552 0 1-0.5 1-1h-1z" fill="#95a5a6"/>
                                                <path d="m11 1029.4v1h1v-1h-1zm0 2v1h1v-1h-1zm0 2v1h1v-1h-1zm0 2v1h1v-1h-1zm0 2v1h1v-1h-1zm0 2c0 0.5 0.448 1 1 1v-1h-1z" fill="#ecf0f1"/>
                                                <path d="m12 1041.4c-1.105 0-2 0.9-2 2v4c0 1.1 0.895 2 2 2s2-0.9 2-2v-4c0-1.1-0.895-2-2-2zm0 1c0.552 0 1 0.4 1 1 0 0.5-0.448 1-1 1s-1-0.5-1-1c0-0.6 0.448-1 1-1zm0 3c0.552 0 1 0.4 1 1v1c0 0.5-0.448 1-1 1s-1-0.5-1-1v-1c0-0.6 0.448-1 1-1z" fill="#95a5a6"/>
                                                <path d="m12 1040.4c-1.105 0-2 0.9-2 2v4c0 1.1 0.895 2 2 2s2-0.9 2-2v-4c0-1.1-0.895-2-2-2zm0 1c0.552 0 1 0.4 1 1 0 0.5-0.448 1-1 1s-1-0.5-1-1c0-0.6 0.448-1 1-1zm0 3c0.552 0 1 0.4 1 1v1c0 0.5-0.448 1-1 1s-1-0.5-1-1v-1c0-0.6 0.448-1 1-1z" fill="#ecf0f1"/>
                                                </g>
                                                </svg>',
                                        ],
                                    ];
                    
                                    $fileLabel = $fileTypes[$extension]['label'] ?? 'Arquivo';
                                    $fileIcon =
                                        $fileTypes[$extension]['icon'] ??
                                        '<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#828282" viewBox="0 0 24 24"><path d="M6 2a2 2 0 00-2 2v16c0 1.104.896 2 2 2h12a2 2 0 002-2V8l-6-6H6z"/></svg>';
                                @endphp
                    
                                <a href="{{ $fileUrl }}" target="_blank" download
                                    class="flex items-center space-x-3 p-3 border border-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:border-gray-600 transition cursor-pointer w-full max-w-xs"
                                    style="position: relative; z-index: 10;">
                                    {!! $fileIcon !!}
                                    <div>
                                        <p class="font-semibold text-gray-700 truncate max-w-[200px] dark:text-white">{{ $fileLabel }}</p>
                                        <p class="text-xs text-gray-500">Clique para abrir/baixar</p>
                                    </div>
                                </a>
                            @endif
                    <div class="mt-10">
                        <div class="absolute bottom-4 right-4 flex justify-between items-center">
                            {{-- Botões de Like e Delete (à direita) --}}
                            <div class="flex space-x-4 items-center">
                                {{-- Botão de Like --}}
                                <button 
                                    class="like-button_comment text-gray-500 hover:text-white 
                                        hover:bg-red-500 rounded-full w-10 h-10 flex items-center justify-center 
                                        shadow-md hover:shadow-xl transition-all duration-300
                                        {{ $comment->isLikedBy(auth()->user()) ? 'text-red-500' : '' }}"
                                    data-comment-id="{{ $comment->id }}"
                                    data-liked="{{ $comment->isLikedBy(auth()->user()) ? '1' : '0' }}" 
                                    data-like-type="comment"
                                    data-like-count="{{ $comment->likes->count() }}"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" 
                                        fill="currentColor" 
                                        class="like-icon_comment size-6 transition-transform duration-300 ease-out">
                                        <path d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 
                                    25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 
                                    2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 
                                    5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 
                                    0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 
                                    15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 
                                    0 0 1-.704 0l-.003-.001Z" />
                                    </svg>
                                    <span class="like-count_comment ml-1 text-sm font-medium font-sans {{ $comment->isLikedBy(auth()->user()) ? 'block' : 'hidden' }}">
                                        {{ $comment->likes->count() }}
                                    </span>
                                </button>
                        
                                {{-- Botão de Deletar (aparece só se for dono do post) --}}
                                @if (auth()->user()->id == $comment->user_id)
                                <button class="open-delete-modal_comment text-gray-500 hover:text-white hover:bg-red-500 rounded-full w-10 h-10 flex items-center justify-center shadow-md hover:shadow-xl transition-all duration-300"
                                        data-id="{{ $comment->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        fill="currentColor"
                                        class="w-5 h-5 transition-colors duration-300">
                                        <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z"
                                        clip-rule="evenodd" />
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>

            @empty
                <p class="text-gray-600 dark:text-gray-300">{{__("texts.nenhumComment")}}</p>
            @endforelse
        </div>
    
    </div>

    <!-- Adicionar Comentario -->
    <div id="modal-form-comment" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 hidden">
        <!-- Wrapper para detectar clique fora do form -->
        <div id="modal-content-comment" class="w-full sm:w-[90%] md:w-[75%] lg:w-[60%] max-w-3xl mx-auto px-2">
            <form id="form-add-comment" action="{{ route('new_comment_submit') }}" method="POST" enctype="multipart/form-data"
            class="relative max-w-2xl mx-auto dark:bg-gray-900 bg-white shadow-xl rounded-2xl p-4 sm:p-6 md:p-8 space-y-2 max-h-[90vh] overflow-y-auto">
                @csrf

                <svg onclick="closeModal()" id="cancel_delete" xmlns="http://www.w3.org/2000/svg"
                    class="absolute top-3 right-3 w-6 h-6 text-gray-600 dark:text-gray-300 hover:text-red-600 cursor-pointer transition"
                    viewBox="0 0 48 48" fill="currentColor">
                    <path d="M 39.486328 6.9785156 A 1.50015 1.50015 0 0 0 38.439453 7.4394531 L 24 21.878906 L 9.5605469 7.4394531 A 1.50015 1.50015 0 0 0 8.484375 6.984375 A 1.50015 1.50015 0 0 0 7.4394531 9.5605469 L 21.878906 24 L 7.4394531 38.439453 A 1.50015 1.50015 0 1 0 9.5605469 40.560547 L 24 26.121094 L 38.439453 40.560547 A 1.50015 1.50015 0 1 0 40.560547 38.439453 L 26.121094 24 L 40.560547 9.5605469 A 1.50015 1.50015 0 0 0 39.486328 6.9785156 z"/>
                </svg>

                <div class="mb-6">
                    <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200">{{__("texts.addCommentTittle")}}</h2>
                    <p class="text-sm text-gray-500 mt-1 dark:text-gray-200">{{__("texts.addCommentDesc")}}</p>
                </div>

                <div class="mb-6">
                    <textarea name="input_text_comment" id="input_text_comment" rows="6" required placeholder="{{__("texts.addCommentPlaceholder")}}"
                        class="dark:border-gray-800 dark:bg-gray-700 dark:text-gray-200 w-full h-[120px] text-base text-gray-700 placeholder-gray-400 bg-gray-100 border-none rounded-xl px-5 py-4 resize-none focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"></textarea>
                </div>
                <input type="hidden" name="post_id" value="{{ $post->id }}">

                            <!-- Seção de uploads -->
            <h3 class="block text-lg font-semibold text-gray-700 mb-2 dark:text-gray-200">{{__("texts.addPostAnexos")}}</h3>
            <div class="bg-gray-100 dark:bg-gray-700 border border-gray-200 rounded-xl p-6 space-y-3 dark:border-gray-800">
                <!-- Input único para Imagem ou Vídeo -->
                <!-- Imagem/Vídeo -->
                <div class="space-y-2">
                    <label class="block font-medium text-gray-600 dark:text-gray-300">
                      {{__("texts.addPostImg/Video")}}
                    </label>
                  
                    <!-- Botão estilizado -->
                    <label for="input_media" class="cursor-pointer inline-block bg-indigo-500 text-white dark:bg-indigo-500 dark:hover:bg-indigo-600 hover:bg-indigo-600 px-4 py-2 rounded-lg text-sm font-semibold">
                        {{__("texts.addPostEscolherArquivo")}}
                    </label>
                  
                    <!-- Input escondido -->
                    <input type="file" name="input_media" id="input_media"
                           accept="image/*,video/*"
                           class="hidden" />
                  
                    <!-- Preview -->
                    <div id="preview-media" class="mt-3 max-h-48 rounded-lg hidden"></div>
                  </div>
                  

                    <!-- Documento -->
                    <div class="space-y-2">
                        <label class="block font-medium text-gray-600 dark:text-gray-300" for="input_doc">
                        {{__("texts.addPostDocs")}}
                        </label>
                    
                        <!-- Botão estilizado -->
                        <label for="input_doc" class="cursor-pointer inline-block bg-green-500 text-white dark:bg-green-500 dark:hover:bg-green-600 hover:bg-green-600 px-4 py-2 rounded-lg text-sm font-semibold">
                        {{__("texts.addPostEscolherArquivo")}}
                        </label>
                    
                        <!-- Input escondido -->
                        <input type="file" name="input_doc" id="input_doc"
                            accept=".pdf,.doc,.docx,.zip"
                            class="hidden" />
                    </div>
                    
                    <!-- Preview documento -->
                    <div class="flex items-center space-x-2 mt-3">
                        <div id="file-icon-preview" class="hidden"></div>
                        <span id="file-name-doc" class="text-sm text-gray-600"></span>
                    </div>                  
                </div>

                <!-- Botão -->
                <div class="text-right">
                    <button type="submit"
                        class="px-6 py-3 bg-blue-600 text-white text-base font-semibold rounded-xl hover:bg-blue-700 transition duration-200">
                        {{ __("texts.publicar")}}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{asset("js/adicionar_comment.js")}}"></script>
    <script src="{{ asset('js/view_pdf.js') }}" defer></script>


    <!-- like e delete -->
    <script>   
        document.addEventListener('DOMContentLoaded', () => 
        {
            const likeUrl = "{{ route('likes.toggle') }}";//.replace('http://', 'https://');
            console.log(likeUrl); // Verifique no console a URL gerada

            document.querySelectorAll('.like-button_comment').forEach(button => {
                button.addEventListener('click', async (e) => {
                    e.preventDefault();

                    const commentId = button.dataset.commentId;
                    const liked = button.dataset.liked === '1';
                    const likeCountElement = button.querySelector('.like-count_comment');
                    const icon = button.querySelector('.like-icon_comment');

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
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            likeable_type: 'comment',
                            likeable_id: commentId
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
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
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

            const inputMedia = document.getElementById('input_media');
            const previewMedia = document.getElementById('preview-media');
            const inputDoc = document.getElementById('input_doc');


            function limparPreview() {
                previewMedia.innerHTML = '';
                previewMedia.classList.add('hidden');

                inputMedia.value = '';
                inputDoc.value = "";
            }

            inputMedia.addEventListener('change', function() {
                const file = this.files[0];
                if (!file) {
                    previewMedia.innerHTML = '';
                    previewMedia.classList.add('hidden');
                    return;
                }

                const fileType = file.type;

                if (fileType.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewMedia.innerHTML =
                            `<img src="${e.target.result}" alt="Preview da imagem" class="max-h-48 rounded-lg" />`;
                        previewMedia.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } 
                else if (fileType.startsWith('video/')) {
                    const videoURL = URL.createObjectURL(file);
                    previewMedia.innerHTML = `
                    <video controls class="max-h-48 rounded-lg">
                        <source src="${videoURL}" type="${fileType}">
                        Seu navegador não suporta vídeo.
                    </video>`;
                    previewMedia.classList.remove('hidden');

                } else {
                    // Se for outro tipo, esconde preview
                    previewMedia.innerHTML = '';
                    previewMedia.classList.add('hidden');
                }
            });

            //Delete
            const modal_delete = document.getElementById('delete-modal_comment');
            const btnOpenDelete = document.querySelectorAll('.open-delete-modal_comment');
            const modalContentDelete = document.getElementById('delete-modal-content_comment');

            const button_cancel = document.querySelector("#cancel-delete_comment")

            // Abre o modal ao clicar no botão
            btnOpenDelete.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    modal_delete.classList.remove('hidden');

                    const commentId = button.dataset.id;

                    const form = document.getElementById('delete_form_comment');

                    form.action = `{{ url('delete_comment_submit') }}/${commentId}`;
                });
            });
            
            // Fecha modal clicando no botão Cancelar (form)
            button_cancel.addEventListener('click', (e) => {
               modal_delete.classList.add('hidden');
            });

            let click_delete = false;

            modal_delete.addEventListener('mousedown', (e) => 
            {
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
    function goToComment(urlWithHash) {
        // Extrai o hash manualmente
        const [url, hash] = urlWithHash.split('#');

        // Vai para a página SEM o hash, vai para o topo
        window.location = url;

        // Salva o hash temporariamente para usar depois
        sessionStorage.setItem('scrollToCommentHash', '#' + hash);
    }

    document.addEventListener("DOMContentLoaded", function () {
        const hash = sessionStorage.getItem('scrollToCommentHash');

        if (hash && hash.startsWith("#comment-")) {
            sessionStorage.removeItem('scrollToCommentHash');

            // Primeiro rola pro topo
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

                        target.style.transition = "background-color 0.6s ease";
                        //target.style.backgroundColor = "#f9f9f9";

                        setTimeout(() => {
                            target.style.backgroundColor = "";
                        }, 1500);

                        clearInterval(checkExist);
                    }
                };

                const checkExist = setInterval(tryScroll, 100);
                setTimeout(() => clearInterval(checkExist), 3000);
            }, 300);
        }
    });
</script>

<script>
    // Modal de deletar posts
    document.addEventListener("DOMContentLoaded", function () {
        const modal_delete2 = document.getElementById('delete-modal');
        const btnOpenDelete2 = document.querySelectorAll('.open-delete-modal');
        const modalContentDelete2 = document.getElementById('delete-modal-content');
        const button_cancel2 = document.querySelector("#cancel-delete");

        let click_delete = false;

        // Abre o modal ao clicar no botão
        btnOpenDelete2.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                modal_delete2.classList.remove('hidden');

                const postId2 = button.dataset.id;

                // Preenche a ação do formulário
                const form2 = document.getElementById('delete_form');
                form2.action = `{{ url('delete_post_submit') }}/${postId2}`;
            });
        });

        button_cancel2.addEventListener('click', () => {
            modal_delete2.classList.add('hidden');
        });

        // Detecta se o clique foi fora do conteúdo do modal
        modal_delete2.addEventListener('mousedown', (e) => {
            click_delete = modalContentDelete2.contains(e.target);
        });

        modal_delete2.addEventListener("mouseup", (e) => {
            if (!click_delete && e.target === modal_delete2) {
                modal_delete2.classList.add("hidden");
                limparPreview();
            }
        });

        function limparPreview() {
            console.log("Preview limpo.");
        }
    });
</script>



</x-app-layout>
