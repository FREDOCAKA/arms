<?php

namespace App\Models\Project;

use App\Models\Project\Project;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   
    protected $table ="category";

    protected $fillable = ['name' ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}