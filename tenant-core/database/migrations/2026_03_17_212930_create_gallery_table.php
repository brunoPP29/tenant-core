<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gallery', function (Blueprint $table) {
            $table->id();
            
            // Relacionamento: ID do usuário dono da foto
            $table->foreignId('user_id')
                  ->constrained() // Procura a tabela 'users' por padrão
                  ->onDelete('cascade'); // Se o user for apagado, as fotos também serão

            // Caminho do arquivo (ex: 'uploads/galeria/foto1.jpg')
            $table->string('path');

            // Campos informativos (opcionais, mas recomendados)
            $table->string('title')->nullable();    // Legenda da foto
            $table->string('alt_text')->nullable(); // Texto para SEO/Acessibilidade
            $table->string('description')->nullable();

            // Metadados técnicos
            $table->string('mime_type')->nullable(); // Ex: image/jpeg, image/png
            $table->unsignedInteger('size')->nullable(); // Tamanho do arquivo em bytes

            $table->timestamps(); // create_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery');
    }
};