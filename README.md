# 📘 API RESTful de Gerenciamento de Usuários

Projeto de API RESTful em **PHP** com **CodeIgniter 3**, para operações de CRUD (Create, Read, Update, Delete) em registros de usuários. Os dados são armazenados em um banco **MySQL** e as respostas são retornadas em formato **JSON**.

Desenvolvido para demonstrar:
- Criação de endpoints REST.
- Manipulação de banco de dados.
- Validação de entrada.
- Tratamento de erros.

---

## 📑 Índice

- [🚀 Funcionalidades](#-funcionalidades)
- [🛠 Tecnologias Utilizadas](#-tecnologias-utilizadas)
- [⚙️ Instalação e Configuração](#️-instalação-e-configuração)
- [🔗 Endpoints da API](#-endpoints-da-api)
- [🔐 Segurança e Boas Práticas](#-segurança-e-boas-práticas)

---

## 🚀 Funcionalidades

A API permite:

- ✅ Listar todos os usuários
- 🔍 Buscar usuário por ID
- ➕ Criar novo usuário
- ✏️ Atualizar usuário
- ❌ Deletar usuário

---

## 🛠 Tecnologias Utilizadas

- **PHP** 7+
- **CodeIgniter 3**
- **MySQL**
- **[CodeIgniter RestServer](https://github.com/chriskacerguis/codeigniter-restserver)**
- **Apache** (recomendado)
- **Ambiente local**: XAMPP, WAMP, Docker, etc.

---

## ⚙️ Instalação e Configuração

### 📥 1. Clone o repositório

```bash
git clone https://github.com/pradovolnei/users-conectala.git
cd users-conectala
```

---

### 🗄 2. Banco de Dados

1. Crie o banco de dados:

```sql
CREATE DATABASE `api_rest_ci3`;

USE `api_rest_ci3`;

CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
```

2. Configure `application/config/database.php`:

```php
'hostname' => 'localhost',
'username' => 'seu_usuario',
'password' => 'sua_senha',
'database' => 'api_rest_ci3',
'dbdriver' => 'mysqli',
```

---

### 🛠 3. Configuração do CodeIgniter

- **Autoload**:
  No arquivo `application/config/autoload.php`, carregue automaticamente a biblioteca de banco de dados:

  ```php
  $autoload['libraries'] = array('database');
  ```

- **Rotas**:
  Em `application/config/routes.php`, defina:

  ```php
  $route['users/(:num)'] = 'users/index/$1';
  $route['users'] = 'users';
  ```

- **.htaccess** (na raiz):

  ```apache
  RewriteEngine on
  RewriteCond $1 !^(index\.php|assets|robots\.txt)
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteRule ^(.*)$ index.php/$1 [L,QSA]
  ```

---

### 🧩 4. REST Server

Inclua os seguintes arquivos no projeto:

- `application/libraries/RestController.php`
- `application/libraries/Format.php`
- `application/config/rest.php`
- `application/language/english/rest_controller_lang.php`

No seu controlador `Users.php`, use:

```php
require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

use chriskacerguis\RestServer\REST_Controller;
use chriskacerguis\RestServer\Format;

class Users extends REST_Controller {
    // ...
}
```

---

## 🔗 Endpoints da API

| Método | Endpoint       | Ação                  | Parâmetros (Body)             |
|--------|----------------|-----------------------|-------------------------------|
| GET    | `/users`       | Lista todos os usuários | —                             |
| GET    | `/users/{id}`  | Busca usuário por ID    | —                             |
| POST   | `/users`       | Cria novo usuário       | `name`, `email`, `password`   |
| PUT    | `/users/{id}`  | Atualiza usuário        | Campos opcionais              |
| DELETE | `/users/{id}`  | Deleta usuário          | —                             |

### 🧪 Exemplo de Requisição POST

- **URL**: `http://localhost/users-conectala/users`
- **Método**: POST
- **Body (JSON)**:

```json
{
  "name": "João da Silva",
  "email": "joao.silva@email.com",
  "password": "senha_segura123"
}
```

---

## 🔐 Segurança e Boas Práticas

- **🔒 Criptografia de Senhas**  
  Utiliza `password_hash()` para armazenar senhas de forma segura.

- **🧼 Validação de Entrada**  
  Utiliza o `form_validation` do CodeIgniter para evitar SQL Injection e inconsistências.

- **📦 Respostas Padronizadas**  
  Utiliza códigos HTTP adequados e mensagens JSON para facilitar a integração com front-ends.

---

## 📫 Contato

Desenvolvido por [Volnei Prado](https://github.com/pradovolnei)  
📧 Em caso de dúvidas ou sugestões, sinta-se à vontade para entrar em contato!

---