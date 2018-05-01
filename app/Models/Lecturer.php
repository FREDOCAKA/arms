<?php
/**
 * Lecturer model
 */
namespace App\Models;

 use Illuminate\Database\Eloquent\Model;

 class Lecturer extends  Model
 {
     protected $fillable = [
        'name',
        'email',
        'password',
        'status'
     ];

 }