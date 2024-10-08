# Game of Life Laravel Application

![Game of Life](https://github.com/user-attachments/assets/6d716df0-5cfe-4150-9277-69b607a90f7e)

Bem-vindo ao **Game of Life**! Esta aplicação web implementa o famoso Jogo da Vida de Conway usando o framework Laravel, proporcionando uma interface interativa e visualmente atraente para experimentar as regras deste autômato celular.

## 🚀 **Índice**

-   [Pré-requisitos](#pré-requisitos)
-   [Instalação](#instalação)
-   [Configuração](#configuração)
-   [Execução](#execução)
-   [Uso](#uso)
-   [Contribuição](#contribuição)
-   [Licença](#licença)

## 📝 **Pré-requisitos**

Antes de começar, certifique-se de que você tem os seguintes itens instalados em sua máquina:

-   **PHP** (versão 8.0 ou superior)
-   **Composer** (gerenciador de dependências do PHP)
-   **Node.js e NPM** (opcional, se você precisar compilar assets)
-   **Banco de Dados**: MySQL, PostgreSQL, SQLite ou outro suportado pelo Laravel
-   **Git** (para clonar o repositório)

## 📦 **Instalação**

Siga os passos abaixo para configurar a aplicação localmente.

### 1. **Clonar o Repositório**

Abra o terminal e execute o seguinte comando para clonar o repositório:

```bash
git clone https://github.com/SHJordan/game-of-life.git
```

### 2. **Navegar para o Diretório do Projeto**

```bash
cd game-of-life
```

### 3. **Instalar as Dependências PHP**

Use o Composer para instalar as dependências do Laravel:

```bash
composer install
```

### 4. **Instalar as Dependências JavaScript (Opcional)**

Se você precisar compilar assets (CSS, JavaScript), instale as dependências com NPM:

```bash
npm install
```

E, em seguida, compile os assets:

```bash
npm run dev
```

## ⚙️ **Configuração**

### 1. **Configurar as Variáveis de Ambiente**

Copie o arquivo de exemplo `.env.example` para `.env`:

```bash
cp .env.example .env
```

Abra o arquivo `.env` em seu editor de texto preferido e configure as seguintes variáveis:

-   **App Key:** Gere uma chave de aplicação com o comando:

    ```bash
    php artisan key:generate
    ```

-   **Configuração do Banco de Dados:** Atualize as seguintes linhas com as credenciais do seu banco de dados:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nome_do_banco_de_dados
    DB_USERNAME=seu_usuario
    DB_PASSWORD=sua_senha
    ```

    > **Dica:** Se preferir usar SQLite para desenvolvimento, você pode configurar assim:

    ```env
    DB_CONNECTION=sqlite
    DB_DATABASE=/caminho/para/seu/database.sqlite
    ```

    E crie o arquivo SQLite se ainda não existir:

    ```bash
    touch database/database.sqlite
    ```

### 2. **Migrar o Banco de Dados**

Execute as migrações para criar as tabelas necessárias:

```bash
php artisan migrate
```

## 🏃‍♂️ **Execução**

### 1. **Iniciar o Servidor de Desenvolvimento do Laravel**

Execute o seguinte comando para iniciar o servidor local:

```bash
php artisan serve
```

Por padrão, o servidor estará disponível em [http://localhost:8000](http://localhost:8000).

### 2. **Acessar a Aplicação no Navegador**

Abra o seu navegador favorito e navegue até:

```
http://localhost:8000/
```

> **Nota:** Certifique-se de que a rota `/game-of-life` está corretamente configurada no arquivo de rotas (`routes/web.php`). Se estiver usando uma rota diferente, ajuste conforme necessário.

## 🎮 **Uso**

1. **Interagir com o Grid:**

    - **Clicar nas Células:** Clique nas células do grid para alternar entre estados vivos (preenchidos) e mortos (vazios).
    - **Visualização:** Células vivas serão destacadas com uma cor diferente e animações suaves ao serem ativadas ou desativadas.

2. **Gerar a Próxima Geração:**

    - **Botão "Next Generation":** Após configurar o estado inicial das células, clique no botão "Next Generation" para aplicar as regras do Jogo da Vida e gerar a próxima geração.
    - **Atualização Suave:** As mudanças no grid ocorrerão com transições suaves sem a necessidade de recarregar a página.

3. **Repetir o Processo:**
    - Você pode continuar clicando no botão para avançar através das gerações, observando como o padrão evolui de acordo com as regras estabelecidas.

## 🤝 **Contribuição**

Contribuições são bem-vindas! Sinta-se à vontade para abrir issues ou enviar pull requests para melhorar esta aplicação.

### **Passos para Contribuir:**

1. **Fork o Repositório**
2. **Crie uma Branch para sua Feature ou Correção de Bug**
3. **Commit suas Mudanças**
4. **Push para a Branch**
5. **Abra um Pull Request**

## 📄 **Licença**

Este projeto está licenciado sob a [MIT License](LICENSE).

---

<div align="center">
  <p>Desenvolvido com ❤️ por [SHJordan](https://github.com/SHJordan)</p>
</div>

---

## 🧰 **Recursos Adicionais**

-   **Documentação do Laravel:** [https://laravel.com/docs](https://laravel.com/docs)
-   **TailwindCSS:** [https://tailwindcss.com/](https://tailwindcss.com/)
-   **Conway's Game of Life:** [https://en.wikipedia.org/wiki/Conway%27s_Game_of_Life](https://en.wikipedia.org/wiki/Conway%27s_Game_of_Life)

---

**Dúvidas?** Sinta-se à vontade para abrir uma issue ou entrar em contato diretamente.

---

<!-- Optional: Include badges for license, GitHub stars, etc. -->

![License](https://img.shields.io/github/license/SHJordan/game-of-life?style=flat-square)
![Build Status](https://img.shields.io/github/workflow/status/SHJordan/game-of-life/CI.yml?branch=main&style=flat-square)
![Code Coverage](https://img.shields.io/codecov/c/github/SHJordan/game-of-life?style=flat-square)
![PHP Version](https://img.shields.io/packagist/php-v/SHJordan/game-of-life?style=flat-square)
![Laravel Version](https://img.shields.io/badge/Laravel-11.x-blue?style=flat-square)
![GitHub Stars](https://img.shields.io/github/stars/SHJordan/game-of-life?style=flat-square&label=Stars)
![GitHub Forks](https://img.shields.io/github/forks/SHJordan/game-of-life?style=flat-square&label=Forks)
![GitHub Issues](https://img.shields.io/github/issues/SHJordan/game-of-life?style=flat-square&label=Issues)
![Latest Release](https://img.shields.io/github/v/release/SHJordan/game-of-life?style=flat-square)
![Maintenance](https://img.shields.io/badge/Maintained-Yes-green.svg?style=flat-square)

---
