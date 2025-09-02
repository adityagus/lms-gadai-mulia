<?php

namespace App\Models;

use App\Models\AksesCabang;
use App\Models\AksesJabatan;
use App\Models\DocumentRegion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{
    use HasFactory, SoftDeletes;
    public $table = 'documents';
    
    protected $fillable = [
      'title',
      'submenu_id',
      'url', 
      'type',
      'content',
      'no_surat',
      'file',
      'tgl_berlaku',
      'regional_id',
    ];
    
    protected static function booted()
  {
    static::creating(function ($model) {
      $model->created_by = session('auth.user');
    });

    static::updating(function ($model) {
      $model->updated_by = session('auth.user');
    });

    static::deleting(function ($model) {
      $model->deleted_by = session('auth.user');
      $model->save();
    });
  }
    
    public $casts = [
      'created_at' => 'datetime',
      'updated_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];
    // Relasi: Announcement punya satu Menu
    
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'submenu_id', 'id');
    }
    
    public function akses_jabatan()
    {
        return $this->hasMany(AksesJabatan::class, 'document_id', 'id');
    }
    
    public function akses_cabang(){
        return $this->hasMany(AksesCabang::class, 'document_id', 'id');
    }
    
    public function document_regional()
    {
        return $this->hasMany(DocumentRegion::class, 'document_id', 'id');
    }
    
    public function mst_area() {
        $data = \DB::table('mst_area')->get();
        return $data;
    }

  }