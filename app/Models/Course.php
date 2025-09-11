<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'slug', 'students', 'details', 'thumbnail', 'tagline', 'description', 'category_id', 'is_popular'
    ];
    
    // Menambahkan metode untuk mengelola upload file
    public static function uploadThumbnail($file)
    {
      // menyimpan di folder storage/app/public/aktif/uploads/courses
        $path = $file->store('uploads/courses', 'aktif');
        return $path;
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function contents()
    {
        return $this->hasMany(Content::class,'course_id','id');
    }
    
    
}
