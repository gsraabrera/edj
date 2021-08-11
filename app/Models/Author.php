<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    public function scopeAuthor($query)
    {
        return $query->where('type', 'Author');
    }
    public function scopeOfType($query, $type)
    {
        return $query->whereType('Author');
    }
}
