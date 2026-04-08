# Multi-Tenant Modular CMS

Este projeto é um sistema de CMS modular e multi-tenant construído com Laravel, Livewire e Flux. Ele permite que diferentes empresas (tenants) gerenciem seus próprios sites e módulos de forma independente.

## 🚀 Tecnologias

- **PHP 8.2+**
- **Laravel 12**
- **Livewire 4**
- **Livewire Flux** (UI Components)
- **Tailwind CSS**
- **SQLite** (Database default para desenvolvimento)

## 🏗️ Estrutura do Projeto

O projeto utiliza uma arquitetura modular onde as funcionalidades são separadas em módulos globais que podem ser ativados ou desativados para cada empresa.

- `tenant-core/`: Contém todo o código fonte da aplicação Laravel.
  - `app/Models/`: Modelos de dados (User, CompanyModule, Module, Gallery, etc).
  - `app/Http/Controllers/`: Controladores para gerenciar módulos, configurações e galeria.
  - `app/Services/`: Camada de serviço para lógica de negócio (ex: `GalleryService`).
  - `resources/views/`: Templates Blade utilizando componentes de layout.
  - `routes/web.php`: Definições de rotas administrativas e do site.

## ✨ Funcionalidades Principais

- **Gerenciamento de Módulos Globais**: Superusuários podem criar e gerenciar módulos disponíveis no sistema.
- **Configurações de Empresa**: Cada usuário/empresa pode configurar detalhes do seu site.
- **Sistema de Galeria (CRUD)**:
  - Upload de imagens com metadados (título, descrição, alt text).
  - Listagem de fotos por empresa.
  - Edição de informações e substituição de imagens.
  - Exclusão segura de fotos e arquivos físicos.
  - Verificação de propriedade (Security ownership check).

## 🛠️ Instalação e Configuração

1. Clone o repositório.
2. Navegue até a pasta `tenant-core/`.
3. Execute o comando de setup (instala as dependências, gera a chave, migra o banco e builda os assets):
   ```bash
   composer run setup
   ```
4. Inicie o servidor de desenvolvimento:
   ```bash
   composer run dev
   ```

## 📂 Gerenciamento da Galeria

O módulo de galeria permite que as empresas gerenciem seus ativos visuais. As rotas principais são:
- `GET /company/manage/gallery/{id}`: Gerenciar fotos da galeria.
- `GET /site/{company_name}/gallery`: Visualização pública da galeria da empresa.

---
Desenvolvido como uma plataforma robusta e escalável para gerenciamento multi-tenant.
