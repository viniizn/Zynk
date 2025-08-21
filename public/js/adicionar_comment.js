const modal = document.getElementById('modal-form-comment');
const btnOpen = document.getElementById('botao-add-comment');
const modalContent = document.getElementById('modal-content-comment');

const inputImage = document.getElementById('input_image_comment');
const fileName = document.getElementById('file-name_comment');
const imagePreview = document.getElementById('image-preview_comment');

const button_cancel = document.querySelector("#cancel-delete")

console.log("teste")

// Abre o modal ao clicar no botão
btnOpen.addEventListener('click', () => {
    modal.classList.remove('hidden');
    document.body.classList.add("overflow-hidden");
});

// Fecha modal clicando fora do conteúdo (form)
let click = false;

modal.addEventListener('mousedown', (e) => 
{
    click = modalContent.contains(e.target);
});

modal.addEventListener("mouseup", (e) => {
    if (!click && e.target == modal) {
        modal.classList.add("hidden");
        document.body.classList.remove("overflow-hidden");
        limparPreview();
    }
})

function closeModal() {
    modal.classList.add("hidden");
    document.body.classList.remove("overflow-hidden");
    limparPreview();
}


// Mostra nome e preview da imagem selecionada
inputImage.addEventListener('change', function () {
    if (this.files && this.files[0]) {
        const file = this.files[0];
        fileName.textContent = file.name;

        const reader = new FileReader();
        reader.onload = function (e) {
            imagePreview.src = e.target.result;
            imagePreview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    } else {
        limparPreview();
    }
});

// Função para limpar nome e preview da imagem
function limparPreview() {
    fileName.textContent = '';
    imagePreview.src = '';
    imagePreview.classList.add('hidden');
    inputImage.value = ''; // limpa seleção do input file
}