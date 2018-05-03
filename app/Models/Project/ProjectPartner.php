<?php
namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectPartner extends Model
{
    protected $table = 'project_partner';

    protected $fillable = ['first_id','second_id'];

}