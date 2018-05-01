<?php

namespace App\Models\Project;
use App\Models\Project\Category;
use Illuminate\Database\Eloquent\Model;

class Project extends Model 
{

    protected $fillable = [
        'title',
        'body',
        'category_id',
        'uploads'
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}