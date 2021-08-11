<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function authors(){
        return $this->hasMany(Author::class);
    }

    public function keywords(){
        return $this->hasMany(ArticleKeyword::class);
    }

    public function actions(){
        return $this->hasMany(Action::class);
    }

    public function reviewers(){
        return $this->hasMany(Reviewer::class);
    }

    public function subject_matter_editor_recommendations(){
        return $this->hasMany(SubjectMatterEditorRecommendation::class);
    }

    public function editor_in_chief_decisions(){
        return $this->hasMany(EditorInChiefDecision::class);
    }
    

    // public function author()
    // {
    // 	return $this->belongsTo(Author::class);
    // }
}
