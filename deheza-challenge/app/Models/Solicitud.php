<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $fillable = [
        'user_id',
        'categoria_id',
        'titulo',
        'descripcion',
        'estado',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
