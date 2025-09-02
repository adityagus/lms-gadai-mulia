<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentRegion extends Model
{
    use HasFactory;
    
    protected $table = 'document_region'; // Assuming the table name is 'document_regions'
    protected $fillable = [
        'document_id',
        'region_id'
    ];
    
    public function document()
    {
        return $this->belongsTo(Announcement::class, 'document_id', 'id');
    }
    
}
