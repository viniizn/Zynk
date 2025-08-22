<div class="flex-1 p-3 -ml-5 sm:-ml-3">

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 sm:gap-0">
        <h2 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $post->user->name }}</h2>
        <span class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
    </div>
    <p class="text-sm sm:text-md text-gray-500">{{ '@' . $post->user->username }}</p>


    <hr class="mt-3 mb-2 border-gray-300 dark:border-gray-700">

    <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $post->title }}</h3>

    <p class="text-sm sm:text-base text-gray-700 dark:text-gray-100 leading-relaxed whitespace-pre-wrap 
       break-all sm:break-words hyphens-auto max-w-full sm:max-w-[500px] mt-2 mb-5 line-clamp-2">{{ $post->description }}</p>

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