# Projeto ToDo List Backend com Laravel
Este é um projeto simples de uma lista de tarefas (ToDo List) desenvolvido com Laravel. Ele permite que os usuários criem, visualizem, atualizem e excluam tarefas.

## Requisitos
- PHP >= 8.0
- Composer
- Banco de dados (MySQL, SQLite, etc.)
- Git (opcional, para controle de versão)
- Servidor web (Apache, Nginx, etc.)

## Instalação
### Clone o repositório:
```bash
git clone <repositório>
cd <nome-do-projeto>
cp .env.example .env
composer install
npm install
php artisan key:generate
```
Configure o arquivo `.env` com as credenciais do banco de dados.

### Execute as migrações e seeders:
```bash
php artisan migrate --seed
```
### Inicie o servidor de desenvolvimento:
```bash
php artisan serve
```
### Rodar os testes:
```bash
php artisan test
```
### Testando a aplicação via Curl:

Criar conta:
```bash
curl --location 'http://localhost:8000/api/register' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--data-raw '{
    "name": "Eduardo",
    "email": "eduzenite11@gmail.com",
    "password": "12345678",
    "password_confirmation": "12345678"
}'
```
Login:
```bash
curl --location 'http://localhost:8000/api/login' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--data-raw '{
    "email": "eduzenite11@gmail.com",
    "password": "12345678"
}'
```
Criar tarefa:
```bash
curl --location 'http://localhost:8000/api/todo' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--header 'Authorization: ••••••' \
--data '{
    "title": "Primeira tarefa",
    "description": "Essa aqui é a primeira tarefa que estou fazendo dentro do sistema como teste.",
    "due_date": "2025-08-25 12:00",
    "status": "pending"
}'
```
Listar tarefas:
```bash
curl --location --request GET 'http://localhost:8000/api/todo' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--header 'Authorization: ••••••' \
--data '{
    "status": "in_progress"
}'
```
Pegar tarefa por ID:
```bash
curl --location 'http://localhost:8000/api/todo/3' \
--header 'Accept: application/json' \
--header 'Authorization: ••••••' \
--data ''
```
Atualizar tarefa:
```bash
curl --location --request PUT 'http://localhost:8000/api/todo/1' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--header 'Authorization: ••••••' \
--data '{
    "title": "Primeira tarefa",
    "description": "Essa aqui é a primeira tarefa que estou fazendo dentro do sistema como teste.",
    "due_date": "2025-08-25 12:00",
    "status": "in_progress"
}'
```
Atualizar status da tarefa:
```bash
curl --location --request PUT 'http://localhost:8000/api/todo-status/1' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--header 'Authorization: ••••••' \
--data '{
    "status": "in_progress"
}'
```
Excluir tarefa:
```bash
curl --location --request DELETE 'http://localhost:8000/api/todo/2' \
--header 'Accept: application/json' \
--header 'Authorization: ••••••' \
--data ''
```
## Swagger
A documentação da API está disponível via Swagger. Para acessá-la, inicie o servidor e navegue até `/api/documentation`.

# Projeto ToDo List Backend com Laravel com API

## Tecnologias Utilizadas
- Vue.js — Framework progressivo para a interface do usuário.
- MySQL — Banco de dados relacional.
- Tailwind CSS — Utilitário para estilização rápida e consistente.
- Inertia.js — Ponte entre Laravel e Vue.js, eliminando a necessidade de APIs separadas.
- Axios — Cliente HTTP para requisições assíncronas.

## Configuração do Ambiente
Instale as dependências do frontend:
```bash
npm install
```
No arquivo `.env`, configure as variáveis de ambiente necessárias, como a URL do backend e outras configurações específicas do Vue.js.
Crie um chave de API para autenticação no serviço https://newsapi.org e preencha as variáveis **NEWS_API_URL** e **NEWS_API_TOKEN** no arquivo `.env`:

## Executando o Projeto
ertifique-se de que o servidor Laravel esteja rodando corretamente.
Em seguida, para iniciar o servidor de desenvolvimento do Vue.js, execute:
```bash
npm run dev
```

## Acessando a Aplicação
- Crie uma conta de usuário diretamente pela interface do frontend ou via API.
- Após o cadastro, faça login para acessar todas as funcionalidades da aplicação.
