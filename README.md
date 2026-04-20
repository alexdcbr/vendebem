Perfeito — segue o **README.md completo**, pronto para você copiar e colar no seu repositório (arquivo `README.md`):

---

```markdown
# 🛒 Sistema de Vendas Web (PHP + MySQL)

Projeto de um sistema de vendas web desenvolvido em **PHP puro e MySQL**, com foco em aprendizado prático e evolução progressiva até um **mini e-commerce completo com painel administrativo e dashboard BI**.

---

## 📌 Objetivo

Construir um sistema completo de vendas inspirado em aplicações desktop, adaptado para ambiente web, aplicando boas práticas de desenvolvimento, autenticação, controle de acesso e visualização de dados.

---

## 🚀 Funcionalidades

### 👤 Área do Cliente
- Cadastro de usuário
- Login com autenticação segura (password_hash)
- Onboarding (completar cadastro obrigatório)
- Navegação de produtos (loja)
- Carrinho de compras
- Alterar quantidade de itens
- Remover itens do carrinho
- Checkout completo
- Simulação de pagamento:
  - PIX (QR Code)
  - Cartão de crédito
- Histórico de compras

---

### 🛍️ E-commerce
- Vitrine de produtos com imagens
- Cards responsivos e modernos
- Controle de estoque automático
- Baixa de estoque na venda
- Fluxo completo de compra

---

### 🔒 Controle de Acesso
- Separação de perfis:
  - Cliente
  - Administrador
- Proteção de rotas
- Menu dinâmico por tipo de usuário

---

### 📦 Administrativo
- Painel de pedidos
- Visualização detalhada de pedidos
- Status de pagamento

---

### 📊 Dashboard BI
- KPIs:
  - Total de pedidos
  - Faturamento
  - Ticket médio
- Gráfico de pedidos por dia
- Gráfico de faturamento
- Filtro por período (7 / 30 dias)
- Top produtos vendidos

---

## 🧱 Tecnologias Utilizadas

- PHP (puro)
- MySQL
- HTML5
- CSS3
- JavaScript
- Chart.js

---

## 📂 Estrutura do Projeto

```

/public
├── index.php
├── login.php
├── register.php
├── loja.php
├── carrinho.php
├── checkout.php
├── pagamento.php
├── admin_dashboard.php
├── admin_pedidos.php
├── cliente_completar.php
├── uploads/
├── css/
└── partials/

/config
└── database.php

````

---

## ⚙️ Instalação

### 1. Clonar o projeto

```bash
git clone https://github.com/seu-usuario/seu-repositorio.git
````

---

### 2. Configurar ambiente

Use um servidor local como:

* Laragon
* XAMPP
* WAMP

---

### 3. Criar banco de dados

```sql
CREATE DATABASE sistema_vendas;
```

---

### 4. Criar tabelas

```sql
CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    cpf VARCHAR(20),
    senha VARCHAR(255),
    tipo VARCHAR(20) DEFAULT 'cliente',
    cadastro_completo TINYINT DEFAULT 0,
    email VARCHAR(100),
    telefone VARCHAR(20),
    endereco VARCHAR(255)
);

CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    valor DECIMAL(10,2),
    estoque INT,
    imagem VARCHAR(255)
);

CREATE TABLE vendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT,
    data DATETIME,
    status VARCHAR(20),
    pagamento VARCHAR(50),
    status_pagamento VARCHAR(20)
);

CREATE TABLE itens_venda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venda_id INT,
    produto_id INT,
    quantidade INT,
    valor DECIMAL(10,2)
);

CREATE TABLE carrinho (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT,
    produto_id INT,
    quantidade INT
);
```

---

### 5. Configurar conexão

Editar o arquivo:

```
/config/database.php
```

---

### 6. Executar o sistema

Acesse no navegador:

```
http://localhost/sistema-vendas/public/
```

---

## 🔐 Usuário Administrador

Defina manualmente no banco:

```sql
UPDATE clientes 
SET tipo = 'admin' 
WHERE id = 1;
```

---

## 🔄 Fluxo do Sistema

```
Cadastro → Login → Completar Cadastro → Loja → Carrinho → Checkout → Pagamento → Pedido
```

---

## 📈 Roadmap (Melhorias Futuras)

* [ ] Integração com pagamento real (Stripe / Mercado Pago)
* [ ] Frete automático
* [ ] Endereço com CEP automático
* [ ] Upload múltiplo de imagens
* [ ] Avaliação de produtos
* [ ] API REST
* [ ] Autenticação JWT
* [ ] Painel administrativo avançado

---

## 🧠 Aprendizados

Este projeto cobre:

* CRUD completo
* Sessões e autenticação
* Controle de acesso (RBAC)
* Modelagem de banco de dados
* Fluxo de e-commerce
* Dashboard com BI
* Integração frontend + backend

---

## 📌 Status do Projeto

🚧 Em desenvolvimento contínuo (projeto educacional)

---

## 👨‍💻 Autor

Desenvolvido como projeto prático para aprendizado de desenvolvimento web.

---

## 📄 Licença

Uso livre para fins educacionais.
