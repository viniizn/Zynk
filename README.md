# ⚡ ZYNK
Uma rede social onde você pode publicar seus projetos e interagir com outros usuários.  
Este projeto foi desenvolvido como parte do meu portfólio para demonstrar habilidades fullstack.

---

## Site hospedado

[https://zynk-production.up.railway.app/]

Por ser o plano gratuito do railway, algumas coisas podem não funcionar, como enviar videos e arquivos pesados.

---

## 🎥 Vídeo

[Assista ao vídeo no YouTube](https://youtu.be/c7LA3PCb8SI)

---

## ✨ Sobre o projeto
**Zynk** é um site que permite usuários publiquem conteúdos diversos (vídeos, textos, arquivos, etc.) e interajam com outras pessoas através de curtidas, comentários e seguidores.

### 🧩 Funcionalidades principais
- Publicação de textos, documentos, fotos, vídeos e arquivos `.ZIP`  
- Sistema de curtidas e comentários em posts  
- Sistema de seguidores  
- Notificações para curtidas e comentários  
- Modo escuro  
- Alteração de idioma (Inglês e Português Brasil)  
- Autenticação completa (login, cadastro, recuperação de senha) via Laravel Breeze  
- Perfil de usuário com foto e biografia  
- Alteração da foto de fundo no perfil do usuário  

> Este projeto foi desenvolvido para demonstrar minhas habilidades em **PHP/Laravel**, **JavaScript** e **desenvolvimento fullstack**.

---

## 🚧 Ajustes e Melhorias Futuras
Apesar do projeto não estar em desenvolvimento ativo, aqui estão melhorias que eu ou qualquer pessoa pode implementar futuramente:
- Sistema de busca (usuários e publicações)  
- Responder comentários  
- Organização e otimização do código  
- Marcar usuários  
- Bate papo (Chat)  

---

## ✅ Pré-requisitos
Se quiser rodar o projeto localmente, é necessário:  
- PHP >= 8.1  
- XAMPP, Laragon, ou equivalente  
- Node.js (>= 16)  
- Composer  

---

## 🚀 Como iniciar o projeto

```bash
# Clone o repositório
git clone https://github.com/viniizn/Zynk.git

# Acesse a pasta do projeto
cd zynk

# Instale as dependências PHP
composer install

# Instale as dependências do frontend
npm install

# Crie o arquivo .env
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate

# Crie a pasta onde serão salvos arquivos dos usuários
php artisan storage:link

# Ajuste os dados do .env para o seu ambiente (DB, mail, etc.)

# Rode as migrations (se tiver)
php artisan migrate

# Compile os assets
npm run dev

# Inicie o servidor
php artisan serve
```

Ou, se estiver usando **Laragon**, coloque o projeto na pasta `www` e acesse via `localhost/zynk`.

---

## 🧠 Tecnologias utilizadas
- PHP 8.1  
- Laravel  
- Laravel Breeze  
- MySQL  
- Node.js  
- Vite  
- TailwindCSS  
- JavaScript  

---

## 🤝 Contribuições
Este é um projeto pessoal, mas se quiser contribuir com melhorias ou sugestões, fique à vontade.

---

## 📫 Contato
Você pode falar comigo por:  
📧 **jovini1303@gmail.com**  
🔗 **www.linkedin.com/in/joão-vinicios-465936290**  

---

## 📄 Licença
Este projeto foi criado para fins educacionais e de portfólio.  
Não possui finalidade comercial, mas você pode usá-lo como base para estudos ou ideias.

---

## ⭐ Apoie
Se curtir o projeto, deixa uma **estrela aqui no GitHub!**  
Ajuda demais! 😃
