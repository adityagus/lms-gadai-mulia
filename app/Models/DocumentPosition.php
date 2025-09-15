<?php

namespace App\Models;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentPosition extends Model
{
    use HasFactory;
    
    protected $table = 'document_position';
    protected $fillable = [
        'document_id',
        'kd_jbt',
    ];
    
    public $timestamps = false;
    
    
    
    public function announcement()
    {
        return $this->belongsTo(Announcement::class, 'document_id', 'id');
    }
}
