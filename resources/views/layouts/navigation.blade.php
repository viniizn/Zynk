<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 dark:bg-gray-900 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-25">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ asset('logo/logo_home_branco.png') }}" alt="Logo" class="sm:w-[48px] w-[32px] text-center" id="logo">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link class="dark:text-white" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('texts.foryou') }}
                    </x-nav-link>

                    <x-nav-link class="dark:text-white" :href="route('following')" :active="request()->routeIs('following')">
                        {{ __('texts.seguindo') }}
                    </x-nav-link>
                </div>
            </div>
              

            <!-- Settings Dropdown -->
            

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="relative m-4 cursor-pointer">
                    <a href="{{ route('notifications') }}" class="relative inline-flex items-center">
                        @php
                            $unreadCount = auth()->user()->unreadNotifications->count();
                        @endphp
                
                        {{-- Badge de notificações --}}
                        @if ($unreadCount > 0)
                            <span class="absolute -top-2 -right-2 text-xs font-bold text-white bg-red-500 rounded-full px-1.5 py-0.5 shadow">
                                {{ $unreadCount }}
                            </span>
                        @endif
                
                        {{-- Ícone do sino --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600 dark:text-gray-400 hover:text-gray-800 transition duration-150 ease-in-out" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022
                                     c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"/>
                        </svg>
                    </a>
                </div>
                
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 dark:bg-gray-900">
                        @if (!Auth::user()->profile_photo)
                        <!-- Avatar genérico -->
                        <div
                            class="w-12 h-12 bg-blue-500 mr rounded-full flex items-center justify-center text-white font-bold text-lg">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        @endif

                        {{-- Sempre inclui a imagem, com src condicional --}}
                        <img id="" src="{{ Auth::user()->profile_photo ? asset("storage/" . Auth::user()->profile_photo) : '' }}" 
                        alt="Foto de perfil" 
                        class="w-12 h-12 object-cover rounded-full {{ Auth::user()->profile_photo ? '' : 'hidden' }}" />
                        
                        <div class="m-3 dark:text-gray-200">{{ Auth::user()->username }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.my_profile')">
                            {{ __('texts.profile') }}
                        </x-dropdown-link>

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('texts.config') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('texts.sair') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                <button class="theme-toggle" class="hidden sm:inline-flex p-2 rounded-md transition hover:bg-gray-200 dark:hover:bg-gray-700">
                </button>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <div class="cursor-pointer inline-flex items-center justify-center p-2">
                    <a href="{{ route('notifications') }}" class="relative inline-flex items-center">
                        @php
                            $unreadCount = auth()->user()->unreadNotifications->count();
                        @endphp
                
                        {{-- Badge de notificações --}}
                        @if ($unreadCount > 0)
                            <span class="absolute -top-2 -right-2 text-xs font-bold text-white bg-red-500 rounded-full px-1.5 py-0.5 shadow">
                                {{ $unreadCount }}
                            </span>
                        @endif
                
                        {{-- Ícone do sino --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600 dark:text-gray-400 hover:text-gray-800 transition duration-150 ease-in-out" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022
                                     c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"/>
                        </svg>
                    </a>
                </div>
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('texts.foryou') }} 
            </x-responsive-nav-link>
        
            <x-responsive-nav-link :href="route('following')" :active="request()->routeIs('following')">
                {{ __('texts.seguindo') }} 
            </x-responsive-nav-link>
        
            <!-- Botão de tema para mobile -->
            <div class="sm:hidden px-4 pt-2">
                <button class="theme-toggle w-full flex items-center gap-2 p-2 rounded-md transition hover:bg-gray-200 dark:hover:bg-gray-700">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-200">Tema</span>
                    <span class="icon-container"></span> <!-- Ícone será inserido via JS -->
                </button>
            </div>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <x-responsive-nav-link :href="route('profile.my_profile')">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500 dark:text-gray-600">{{"@" . Auth::user()->username }}</div>
                </div>
            </x-responsive-nav-link>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('texts.config') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                            this.closest('form').submit();">
                    {{ __('texts.sair') }}
                </x-responsive-nav-link>
                </form>                
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const toggleBtns = document.querySelectorAll('.theme-toggle'); // Corrigido
  const htmlEl = document.documentElement;
  const logoImg = document.getElementById("logo");

  const sunIcon = `
      <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 36 36">
          <path fill="#FFAC33" d="M16 2s0-2 2-2s2 2 2 2v2s0 2-2 2s-2-2-2-2V2zm18 14s2 0 2 2s-2 2-2 2h-2s-2 0-2-2s2-2 2-2h2zM4 16s2 0 2 2s-2 2-2 2H2s-2 0-2-2s2-2 2-2h2zm5.121-8.707s1.414 1.414 0 2.828s-2.828 0-2.828 0L4.878 8.708s-1.414-1.414 0-2.829c1.415-1.414 2.829 0 2.829 0l1.414 1.414zm21 21s1.414 1.414 0 2.828s-2.828 0-2.828 0l-1.414-1.414s-1.414-1.414 0-2.828s2.828 0 2.828 0l1.414 1.414zm-.413-18.172s-1.414 1.414-2.828 0s0-2.828 0-2.828l1.414-1.414s1.414-1.414 2.828 0s0 2.828 0 2.828l-1.414 1.414zm-21 21s-1.414 1.414-2.828 0s0-2.828 0-2.828l1.414-1.414s1.414-1.414 2.828 0s0 2.828 0 2.828l-1.414 1.414zM16 32s0-2 2-2s2 2 2 2v2s0 2-2 2s-2-2-2-2v-2z"/><circle cx="18" cy="18" r="10" fill="#FFAC33"/>
      </svg>
      `;

  const moonIcon = `
      <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-gray-500" viewBox="0 0 16 16"><g fill="currentColor"><path d="M6 .278a.768.768 0 0 1 .08.858a7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277c.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316a.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71C0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278zM4.858 1.311A7.269 7.269 0 0 0 1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.316 7.316 0 0 0 5.205-2.162c-.337.042-.68.063-1.029.063c-4.61 0-8.343-3.714-8.343-8.29c0-1.167.242-2.278.681-3.286z"/><path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"/></g></svg>`;

      const lightLogo = "{{ asset('logo/logo_home_azul.png') }}";
  const darkLogo = "{{ asset('logo/logo_home_branco.png') }}";

  function updateUI(isDark) {
      toggleBtns.forEach(btn => {
          btn.innerHTML = isDark ? sunIcon : moonIcon;
      });
      if (logoImg) {
          logoImg.src = isDark ? darkLogo : lightLogo;
      }
  }

  function applyStoredTheme() {
      const stored = localStorage.getItem('theme');
      const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
      const isDark = stored === 'dark' || (!stored && prefersDark);

      htmlEl.classList.toggle('dark', isDark);
      updateUI(isDark);
  }

  toggleBtns.forEach(btn => {
      btn.addEventListener('click', () => {
          const isDark = htmlEl.classList.toggle('dark');
          localStorage.setItem('theme', isDark ? 'dark' : 'light');
          updateUI(isDark);
      });
  });

  applyStoredTheme();
});
</script>