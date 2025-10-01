# Gestor de Grupo de Oração

Este é um sistema de gerenciamento para grupos de oração, projetado para ser uma solução white-label robusta e escalável. O objetivo é fornecer uma ferramenta completa para administrar membros, ministérios, eventos e a comunicação interna de uma organização religiosa.

## Visão Geral

O projeto está sendo construído com o **Laravel 12**, seguindo as melhores práticas de desenvolvimento de software, incluindo uma arquitetura bem definida com camadas de Serviço e Repositório (Service and Repository Patterns), e um forte foco em código limpo e testável.

## Arquitetura e Design

- **Backend:** Laravel 12
- **Frontend (Painel Admin):** AdminLTE (a ser implementado)
- **Banco de Dados:** Suporte para MySQL, PostgreSQL e SQLite.
- **Padrões de Projeto:**
  - **Repository Pattern:** Para abstrair a camada de acesso a dados, tornando o código mais limpo, testável e de fácil manutenção.
  - **Service Layer:** Para encapsular a lógica de negócio, mantendo os controllers enxutos e focados em lidar com as requisições HTTP.
- **Qualidade de Código:** Foco em PSR-12, código limpo e documentado.

## Estrutura do Banco de Dados

O sistema foi modelado para suportar múltiplas organizações (multi-empresa), com as seguintes entidades principais:

- **Organizations:** A entidade central que permite o funcionamento multi-empresa.
- **Users:** Usuários administradores do sistema (Admin, Gestor).
- **Members:** Membros do grupo de oração (Servos, Participantes, etc.).
- **Ministries:** Os ministérios aos quais os membros podem pertencer.
- **Events:** Eventos, reuniões e formações organizados pelo grupo.
- **Event Attendance:** Controle de presença dos membros nos eventos.

## Como Começar (Ambiente de Desenvolvimento)

1.  **Clone o repositório:**
    ```bash
    git clone [URL_DO_REPOSITORIO]
    cd gestor-incricoes-app
    ```

2.  **Instale as dependências:**
    ```bash
    composer install
    npm install
    ```

3.  **Configure o ambiente:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Configure o banco de dados** no arquivo `.env` e execute as migrations:
    ```bash
    php artisan migrate
    ```

5.  **Inicie o servidor de desenvolvimento:**
    ```bash
    php artisan serve
    ```

## Próximos Passos

Consulte o TODO list para ver o progresso atual e os próximos passos no desenvolvimento.
