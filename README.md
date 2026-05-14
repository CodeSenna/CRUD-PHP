# 📘 Sistema de Chamados (Help Desk) — PHP + MySQL

Sistema simples de gerenciamento de chamados (CRUD), desenvolvido com PHP, MySQL e Bootstrap para fins acadêmicos.

---

## 👥 Integrantes

- Matheus Henrique Senna de Sousa
- Gabriel Brochi Julio

---

## 🛠️ Tecnologias utilizadas

- PHP 8+
- MySQL
- PDO (PHP Data Objects)
- Bootstrap 5.3
- HTML, CSS e JavaScript

---

## ⚙️ Requisitos

Antes de executar o projeto, instale:

- [XAMPP](https://www.apachefriends.org/) (Apache + MySQL + PHP)
- Navegador (Chrome recomendado)
- MySQL Workbench (opcional)

---

## 🚀 Como executar o projeto

### 1. Baixar o projeto

Clone o repositório:

```bash
git clone <URL_DO_REPOSITORIO>
```

Ou baixe o ZIP e extraia.

### 2. Colocar na pasta do servidor

Mova a pasta do projeto para dentro de:

```
C:\xampp\htdocs\
```

Exemplo:

```
C:\xampp\htdocs\CRUD_PHP
```

### 3. Iniciar o servidor

Abra o XAMPP e inicie:

- ✅ Apache
- ✅ MySQL

### 4. Criar o banco de dados

Abra o MySQL Workbench ou o terminal e execute o arquivo `database.sql`, ou rode o script abaixo:

```sql
CREATE DATABASE IF NOT EXISTS devdb;
USE devdb;

CREATE TABLE IF NOT EXISTS chamados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL,
    prioridade ENUM('baixa', 'media', 'alta') NOT NULL,
    status ENUM('aberto', 'andamento', 'fechado') DEFAULT 'aberto',
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO chamados (titulo, descricao, prioridade, status) VALUES 
('Erro no Servidor', 'O servidor Apache não está iniciando corretamente.', 'alta', 'aberto'),
('Ajuste de CSS', 'O cabeçalho não está responsivo em telas pequenas.', 'baixa', 'andamento');
```

### 5. Configurar o ambiente

Renomeie o arquivo `.env.example` para `.env` e ajuste as credenciais:

```env
DB_HOST=localhost
DB_PORT=3306
DB_NAME=devdb
DB_USER=root
DB_PASSWORD=
```

> **Nota:** o projeto lê as variáveis do `.env` via função própria em `config/database.php`, sem dependências externas.

### 6. Acessar o sistema

Abra no navegador:

```
http://localhost/CRUD_PHP
```

---

## 📌 Funcionalidades

- ✅ Criar chamados (via modal)
- ✅ Listar chamados em tabela
- ✅ Editar chamados (via modal, reaproveitado)
- ✅ Excluir chamados (com confirmação)
- ✅ Filtrar por status (Aberto / Em Andamento / Fechado)
- ✅ Badges coloridos por prioridade (Alta / Média / Baixa)
- ✅ Aviso na tela quando o banco não estiver conectado
- ✅ Interface responsiva com Bootstrap 5.3

---

## 📁 Estrutura do projeto

```
CRUD_PHP/
├── api/
│   ├── post.php       # Criação de chamado
│   ├── put.php        # Edição de chamado
│   └── delete.php     # Exclusão de chamado
├── config/
│   └── database.php   # Conexão PDO + leitura do .env
├── includes/
│   ├── header.php     # Navbar + Bootstrap CSS
│   └── footer.php     # Rodapé + Bootstrap JS
├── database.sql       # Script de criação do banco
├── index.php          # Página principal (listagem + modais)
└── .env               # Variáveis de ambiente (não versionar)
```

---

## ⚠️ Problemas comuns

**Banco não conecta**
- Verifique se o MySQL está rodando no XAMPP
- Confira as credenciais no `.env`
- Certifique-se de que o banco `devdb` foi criado

**Página não abre**
- Verifique se o projeto está dentro do `htdocs`
- Confirme a URL: `http://localhost/CRUD_PHP`

**Tabela não existe**
- Execute novamente o arquivo `database.sql`

**`.env` não é lido**
- Confirme que o arquivo se chama exatamente `.env` (sem extensão extra)
- Verifique se está na raiz do projeto, ao lado do `index.php`

---

## ✅ Resultado esperado

Após seguir todos os passos, o sistema estará funcionando com:

- ✅ CRUD completo de chamados
- ✅ Banco de dados integrado
- ✅ Interface web funcional e responsiva