<div id="modal-form" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 hidden">
    <div id="modal-content" class="w-full sm:w-[90%] md:w-[75%] lg:w-[60%] max-w-3xl mx-auto px-2">
        <form action="{{ route('new_post_submit') }}" method="POST" enctype="multipart/form-data"
            class="relative max-w-2xl mx-auto dark:bg-gray-900 bg-white shadow-xl rounded-2xl p-4 sm:p-6 md:p-8 space-y-2 max-h-[90vh] overflow-y-auto">
            @csrf

            <svg onclick="closeModal()" id="cancel_delete" xmlns="http://www.w3.org/2000/svg"
              class="absolute top-3 right-3 w-6 h-6 text-gray-600 dark:text-gray-300 hover:text-red-600 cursor-pointer transition"
                  viewBox="0 0 48 48" fill="currentColor">
                <path d="M 39.486328 6.9785156 A 1.50015 1.50015 0 0 0 38.439453 7.4394531 L 24 21.878906 L 9.5605469 7.4394531 A 1.50015 1.50015 0 0 0 8.484375 6.984375 A 1.50015 1.50015 0 0 0 7.4394531 9.5605469 L 21.878906 24 L 7.4394531 38.439453 A 1.50015 1.50015 0 1 0 9.5605469 40.560547 L 24 26.121094 L 38.439453 40.560547 A 1.50015 1.50015 0 1 0 40.560547 38.439453 L 26.121094 24 L 40.560547 9.5605469 A 1.50015 1.50015 0 0 0 39.486328 6.9785156 z"/>
            </svg>
            <!-- Título -->
            <div>
                <label for="input_title" class="block text-lg font-semibold text-gray-700 mb-2 dark:text-gray-200">{{__("texts.addPostTittle")}}</label>
                <input type="text" name="input_title" id="input_title" maxlength="60" required 
                    class="w-full text-base text-gray-700 dark:text-gray-200 placeholder-gray-400 bg-gray-100 border-gray-200 dark:border-gray-900 dark:bg-gray-800 rounded-xl px-5 py-3 resize-none focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"
                    placeholder="{{ __("texts.addPostModalTitlePlaceholder") }}" />
                <p id="char_count_title" class="text-sm text-gray-500 dark:text-gray-400 mt-1">0/60</p>
            </div>

            <!-- Texto -->
            <div>
                <label for="input_text" class="block text-lg font-semibold text-gray-700 mb-2 dark:text-gray-200">{{__("texts.addPostConteudo")}}</label>
                <textarea name="input_text" id="input_text" rows="3" maxlength="1000"
                    class="w-full h-[120px] text-base text-gray-700 dark:text-gray-200 placeholder-gray-400 bg-gray-100 border-gray-200 dark:border-gray-900 dark:bg-gray-800 rounded-xl px-5 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"
                    placeholder="{{ __("texts.addPostModalDescPlaceholder")}}"></textarea>
                <p id="char_count" class="text-sm text-gray-500 dark:text-gray-400 mt-1">0/6000</p>
            </div>

            <!-- Seção de uploads -->
            <h3 class="block text-lg font-semibold text-gray-700 mb-2 dark:text-gray-200">{{__("texts.addPostAnexos")}}</h3>
            <div class="bg-gray-100 dark:border-gray-900 dark:bg-gray-800 rounded-xl p-4 sm:p-6 space-y-3">
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
