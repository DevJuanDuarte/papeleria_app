<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'last_name', 'country_id'];

    //MUCHOS A MUCHOS: Relacion de muchos autores hacia los libros porque cada autor puede escribir muchos libros y a su vez un libro puede ser escritos por muchos autores.
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }

    // Tipo de relación: Esta es una relación de uno a muchos inversa.
    // Descripción: Cada autor (Author) pertenece a un país (Country). Esto implica que en la tabla authors hay una columna country_id que actúa como llave foránea y que referencia a la llave primaria en la tabla countries.
    // Inversa: La relación belongsTo es la inversa de hasMany o hasOne, lo que significa que, aunque un país puede tener muchos autores, cada autor solo pertenece a un país.

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
