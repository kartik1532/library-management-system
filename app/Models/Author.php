<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    use HasFactory;

    /**
     * Fields that can be mass assigned.
     */
    protected $fillable = [
        'name',
        'biography',
    ];

    /**
     * An author can have many books.
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}