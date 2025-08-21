let form = document.querySelector("#form-add-post");
let botao = document.querySelector("#botao-add-post");

function add_form() {
    form.style.display = "block";
}

botao.addEventListener('click', add_form);