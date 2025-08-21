<section class="mt-6">
    <header>
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
            {{ __('texts.selectLanguage') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
            {{ __('texts.choosetextLanguage') }}
        </p>
    </header>

    <form id="langForm" action="" method="get" class="mt-4">
        <div class="relative w-48">
            <select name="lang" id="langSelect"
                class="w-full cursor-pointer bg-white dark:bg-gray-800 dark:text-white border border-gray-300 dark:border-gray-600 rounded-md py-2 pl-3 pr-10 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-300 transition">
                <option value="pt-br" {{ app()->getLocale() == 'pt-br' ? 'selected' : '' }}>Português</option>
                <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
            </select>

            <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-gray-400 pointer-events-none"
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.293l3.71-4.06a.75.75 0 111.08 1.04l-4.25 4.65a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z"
                    clip-rule="evenodd" />
            </svg>
        </div>
    </form>
</section>

<script>
    document.getElementById('langSelect').addEventListener('change', function() {
        const lang = this.value;
        window.location.href = "{{ url('lang') }}/" + lang;
    });
</script>
