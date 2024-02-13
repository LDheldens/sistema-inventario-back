<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'stock',
        'precio',
        'categoria_id',
        'imagen',
    ];
    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }
}
