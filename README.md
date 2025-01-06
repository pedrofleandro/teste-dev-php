# Como Rodar o Projeto

Este projeto utiliza Laravel para o backend e Vue.js para o frontend. Siga os passos abaixo para configurar e executar o projeto localmente.

---

## Pré-requisitos

Certifique-se de que os seguintes programas estão instalados em sua máquina:

- **PHP** (versão 8.0 ou superior)
- **Composer** (para gerenciamento de dependências do PHP)
- **Node.js** (versão 16 ou superior)
- **NPM** (geralmente instalado junto com o Node.js)
- **MySQL**

---

## Passo a Passo

### 1. Configurar o Banco de Dados

1. Instale o MySQL em sua máquina, se ainda não estiver instalado.
2. Crie um banco de dados chamado `revendamais`. Para isso, você pode usar o MySQL Workbench, phpMyAdmin ou o terminal:

```sql
CREATE DATABASE revendamais;
```

### 2. Configurar o Laravel

1. Acesse a pasta do projeto:

```bash
cd <nome-do-projeto>
```

2. Instale as dependências do Laravel com o Composer:

```bash
composer install
```

3. Copie o arquivo de exemplo de configuração `.env.example` para `.env`:

```bash
cp .env.example .env
```

4. Configure as variáveis de ambiente no arquivo `.env` para conectar ao banco de dados. Certifique-se de que os valores correspondem à sua configuração local. Exemplo:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=revendamais
DB_USERNAME=root
DB_PASSWORD=
```

5. Gere a chave da aplicação:

```bash
php artisan key:generate
```

6. Execute as migrações para criar as tabelas no banco de dados:

```bash
php artisan migrate
```

### 4. Executar o Servidor Backend

Inicie o servidor do Laravel:

```bash
php artisan serve
```

O servidor estará disponível em `http://localhost:8000`.

### 5. Configurar o Frontend

1. Certifique-se de que o Node.js e o NPM estão instalados.
2. Instale as dependências do frontend:

```bash
npm install
```

3. Inicie o servidor de desenvolvimento do Vite:

```bash
npm run dev
```

O frontend estará disponível em `http://localhost:5173/`.

---

## Observações

- Certifique-se de que as portas 8000 (backend) e 5173 (frontend) estão livres.
- Para acessar o sistema, abra `http://localhost:8000` no navegador após seguir os passos acima.
- Se encontrar problemas, verifique os logs do Laravel e do Node.js para diagnóstico.

---

Pronto! O projeto está configurado e pronto para uso.

