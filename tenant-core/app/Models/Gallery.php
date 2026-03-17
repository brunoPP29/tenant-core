<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    // Define explicitamente o nome da tabela
    protected $table = 'gallery';

    protected $fillable = [
        'user_id',
        'path',
        'title',
        'description',
        'alt_text',
        'mime_type',
        'size',
    ];

    /**
     * Relacionamento com o usuário
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}