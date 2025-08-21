//Abrir modal de adicionar Post
const modal = document.getElementById('modal-form');
const btnOpen = document.getElementById('botao-add-post');
const modalContent = document.getElementById('modal-content');

const inputMedia = document.getElementById('input_media');
const previewMedia = document.getElementById('preview-media');
const inputDoc = document.getElementById('input_doc');


function limparPreview() {
    // Limpa o conteúdo visual
    previewMedia.innerHTML = '';
    previewMedia.classList.add('hidden');

    // Limpa o input de arquivo (reseta)
    inputMedia.value = '';
    inputDoc.value = "";
}

inputMedia.addEventListener('change', function () {
    const file = this.files[0];
    if (!file) {
        previewMedia.innerHTML = '';
        previewMedia.classList.add('hidden');
        return;
    }

    const fileType = file.type;

    if (fileType.startsWith('image/')) {
        // Preview imagem
        const reader = new FileReader();
        reader.onload = function (e) {
            previewMedia.innerHTML =
                `<img src="${e.target.result}" alt="Preview da imagem" class="max-h-48 rounded-lg" />`;
            previewMedia.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    } else if (fileType.startsWith('video/')) {
        // Preview vídeo
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

//Botao de cancelar
const button_cancel = document.querySelector("#cancel-delete");

// Abre o modal ao clicar no botão
btnOpen.addEventListener('click', () => {
    modal.classList.remove('hidden');
    document.body.classList.add("overflow-hidden");
});

function closeModal() {
    modal.classList.add("hidden");
    document.body.classList.remove("overflow-hidden");
    limparPreview();
}

// Fecha modal clicando fora do conteúdo (form)
let click = false;

modal.addEventListener('mousedown', (e) => {
    click = modalContent.contains(e.target);
});

modal.addEventListener("mouseup", (e) => {
    if (!click && e.target == modal) {
        modal.classList.add("hidden");
        document.body.classList.remove("overflow-hidden");
        limparPreview();
    }
})