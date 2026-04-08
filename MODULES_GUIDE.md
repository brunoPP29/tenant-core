# Guia de Módulos e Expansão do CMS

Este guia detalha como utilizar os módulos existentes e como criar novos módulos seguindo o padrão da arquitetura.

## 📦 Módulos Atuais (Default Configs)

Abaixo estão os arquivos de configuração JSON padrão para registrar os módulos no sistema (tabela `modules`).

### 1. Galeria (`gallery`)
Gerenciamento de fotos e mídias visuais.
```json
{
    "slug": "gallery",
    "layout": "grid",
    "columns": 3,
    "image_ratio": "1:1",
    "show_titles": true,
    "show_description": false,
    "allow_download": false
}
```

### 2. Catálogo de Produtos (`catalog`)
Exibição de produtos com nome, descrição e preço.
```json
{
    "slug": "catalog",
    "layout": "grid",
    "show_prices": true
}
```

### 3. Links (`links`)
Página de links rápidos estilo Linktree.
```json
{
    "slug": "links",
    "layout": "list"
}
```

---

## 🛠️ Como implementar um Novo Módulo

Para criar um novo módulo (ex: "Depoimentos"), siga este padrão:

### 1. Banco de Dados (Migration & Model)
Crie a tabela necessária vinculada ao `user_id`.
```bash
php artisan make:migration create_testimonials_table
php artisan make:model Testimonial
```
Certifique-se de incluir a foreign key para `users`.

### 2. Camada de Serviço (Service)
Crie uma classe em `app/Services/` para lidar com a lógica e segurança.
- Implemente `isModuleActive($module_id)` verificando se o `user_id` do registro `CompanyModule` coincide com `auth()->id()`.

### 3. Validação (Form Request)
Crie um Request para validar os dados de entrada.
```bash
php artisan make:request TestimonialRequest
```

### 4. Controlador (Controller)
Crie o controlador com os métodos CRUD:
- `index`: Lista itens do usuário autenticado.
- `store`: Salva novo item (pegando `user_id` do `auth()->id()`).
- `edit`/`update`/`destroy`: Manipula registros específicos garantindo que pertençam ao usuário.

### 5. Rotas (`routes/web.php`)
Adicione as rotas de gerenciamento dentro do grupo de middleware `auth`:
```php
Route::controller(TestimonialController::class)->group(function () {
    Route::get('/company/manage/testimonials/{id}', 'index')->name('modulesCompany.testimonialsManage');
    Route::post('/company/manage/testimonials', 'store')->name('modulesCompany.testimonialsStore');
    // ... edit, update, destroy
});
```

### 6. Views
Crie a pasta em `resources/views/module_name/` com:
- `manage.blade.php`: Interface de administração.
- `edit.blade.php`: Formulário de edição.
- `index.blade.php`: Visualização pública para o site.

### 7. Registro
Adicione o novo módulo ao `ModuleSeeder.php` e execute o seed para torná-lo disponível globalmente.
