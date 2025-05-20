# 📦 Laravel - Guia de Instalação Completo

Este projeto utiliza o framework Laravel. Abaixo estão os passos completos para rodar o ambiente local, indicamos o uso do laradock onde abaixo deixaremos um link de exemplificação de uso, porém pode ser feito uso do laravel sail, docker... O importante é que o projeto seja executado e consiga ser feito as devidas tratativas.

---

## ✅ Requisitos

- PHP >= 8.3;
- Composer;
- MySQL ou PostgreSQL;
- node.js e npm.
- docker
- docker-compose

## 🚀 Instalação - Ambiente Local

### 1. Clonar o repositório

<!-- ```bash
git clone https://github.com/seu-usuario/seu-projeto.git
cd seu-projeto -->

### 2. Copiar o arquivo .env (Configurações ambiente Laravel)

cp .env.example .env (Realize as configurações do .env de acordo com as especifições das tecnologias usadas e suas portas).

### 3. Laradock (caso faça uso)

https://youtu.be/4oO_ZGX3Rbs?si=dFLaG_HvlAOU5uiv (exemplificação de uso) - deixaremos um ".env.laradock.example" solto no projeto para substituir o .env padrão do laradock com as configurações do ambiente já definidas, caso necessário realize ajustes...

Cerifique-se de ter o docker/docker-compose instalado.

Após download do repositório e suas devidas configurações acesse o caminho do laradock pelo terminal, rode o comando "docker-compose up -d postgres nginx".

Rode o comando no terminal "docker-compose exec workspace bash" e siga com os demais comandos abaixo, sempre executando os comandos artisan e npm dentro do workspace.

### 4. Instalar as dependências PHP

composer install

### 4. Rodar as migrations

php artisan migrate

### 5. Rodar as seeders

php artisan db:seed

### 6. Gerar APP Key

php artisan key:generate

### 7. Instalar dependências front-end (executar o npm)

npm install
npm run dev

