<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublishedArticle extends Model
{
    use HasFactory;

    public function authors(){
        return $this->hasMany(PublishedArticleAuthor::class);
    }

    public function keywords(){
        return $this->hasMany(PublishedArticleKeyword::class);
    }
}
