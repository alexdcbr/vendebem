# 🛒 Sistema de Vendas Web (PHP + MySQL)

Projeto de um sistema de vendas web desenvolvido em **PHP puro e MySQL**, com foco em aprendizado prático e evolução progressiva até um **mini e-commerce completo com painel administrativo**.

---

## 📌 Objetivo

Construir um sistema completo de vendas inspirado em um modelo desktop (Delphi), adaptado para ambiente web, aplicando boas práticas de desenvolvimento e arquitetura.

---

## 🚀 Funcionalidades

### 👤 Cliente
- Cadastro de usuário
- Login com autenticação segura
- Completar cadastro (onboarding obrigatório)
- Navegação de produtos (loja/vitrine)
- Carrinho de compras
- Alterar quantidade de itens
- Remover itens do carrinho
- Checkout completo
- Simulação de pagamento:
  - PIX (com QR Code)
  - Cartão de crédito
- Histórico de compras

---

### 🛍️ E-commerce
- Vitrine de produtos com imagens
- Cards modernos e responsivos
- Controle de estoque automático
- Baixa e reposição de estoque
- Fluxo completo de compra

---

### 🔒 Controle de Acesso
- Separação de perfis:
  - Cliente
  - Administrador
- Proteção de rotas
- Menu dinâmico por perfil

---

### 📦 Administrativo
- Painel de pedidos
- Visualização detalhada de pedidos
- Status de pagamento

---

### 📊 Dashboard (BI)
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
- Chart.js (gráficos)

---

## 📂 Estrutura do Projeto

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


---

## ⚙️ Instalação

### 1. Clonar o projeto

```bash
git clone https://github.com/seu-usuario/seu-repo.git
2. Configurar ambiente
Utilize:
Laragon / XAMPP / WAMP
3. Criar banco de dados
CREATE DATABASE sistema_vendas;
4. Importar tabelas principais
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
5. Configurar conexão

Arquivo:

/config/database.php
6. Executar

Acesse:

http://localhost/sistema-vendas/public/
🔐 Usuário Admin

Defina manualmente no banco:

UPDATE clientes 
SET tipo = 'admin' 
WHERE id = 1;
📈 Roadmap / Melhorias Futuras
 Integração com gateway de pagamento (Mercado Pago / Stripe)
 Frete e cálculo automático
 Endereço com CEP automático
 Upload múltiplo de imagens
 Sistema de cupons
 Avaliação de produtos
 API REST
 Autenticação JWT
🧠 Aprendizados

Este projeto aborda:

CRUD completo
Sessões e autenticação
Controle de acesso (RBAC)
Modelagem de banco
Fluxo de e-commerce
Dashboard com BI
Integração frontend + backend
📌 Status do Projeto

🚧 Em evolução contínua (projeto educacional)

👨‍💻 Autor

Projeto desenvolvido para fins de aprendizado e evolução em desenvolvimento web.

📄 Licença

Este projeto é de uso livre para estudos.


---

# 🧠 RESULTADO

Você agora tem:

✔ README profissional  
✔ Estrutura de projeto clara  
✔ Documentação pronta para GitHub  
✔ Padrão de mercado  

---

# 🚀 PRÓXIMO PASSO (OPCIONAL)

Se quiser elevar ainda mais:

- README com imagens do sistema
- GIF demonstrando fluxo
- Deploy online (Heroku / VPS)

---

# 👉 Me diga:

- **“Quero adicionar prints no README”**
- **“Quero subir esse projeto online”**
- **“Quero transformar em portfólio profissional”**

Agora seu projeto já está com **cara de produto real no GitHub** 🚀