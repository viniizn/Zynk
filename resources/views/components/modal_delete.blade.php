<div id="delete-modal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 hidden">
    <!-- Wrapper para detectar clique fora do form -->
    <div id="delete-modal-content" class="sm:w-[60%] w-full max-w-3xl mx-auto">
        <form id="delete_form" method="POST"
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
                <button type="button" id="cancel-delete"
                    class="px-4 py-2 w-[40%] bg-gray-200 hover:bg-gray-300 rounded-lg">{{ __("texts.cancel")}}</button>
                <button type="submit"
                    class="px-4 py-2 w-[40%] text-red-600 border border-red-600 hover:bg-red-600 hover:text-white rounded-lg">{{ __("texts.excluir")}}</button>
            </div>
        </form>
    </div>
</div>