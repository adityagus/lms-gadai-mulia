<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'slug', 'thumbnail', 'about', 'category_id', 'is_popular'
    ];
}
