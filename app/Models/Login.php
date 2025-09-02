<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
  use HasFactory;
  protected $connection = 'db2';
  protected $table = 'tbluser';

  protected $fillable = [
    'username',
    'fk_cabang_user', // dst...
  ];
  /**
   * Cek login user dengan join ke tabel karyawan dan jabatan
   */
  public static function cekLogin($user)
  {
    // Asumsi koneksi db2 sudah di-setup di config/database.php
    $query = \DB::connection('db2')
      ->table('tbluser as a')
      ->select('a.username', 'a.password', 'b.nm_depan', 'b.nm_belakang', 'c.kd_jabatan', 'nm_jabatan', 'a.fk_cabang_user')
      ->join('tblkaryawan as b', 'a.fk_karyawan', '=', 'b.npk')
      ->join('tbljabatan as c', 'b.fk_jabatan', '=', 'c.kd_jabatan')
      ->where('a.active', 't')
      ->where('a.username', 'like', "%" . $user . "%")
      ->get();
    // $query = [
    //   (object)[
    //     'username' => 'aditya.gustian',
    //     'password' => '',
    //     'nama' => 'Nama',
    //     'nm_depan' => 'Nama',
    //     'nm_belakang' => 'Belakang',
    //     'kd_jabatan' => 'JBT-032',
    //     'fk_cabang_karyawan' => 'CAB-001'
    //   // Tambahkan data dummy lainnya jika perlu
    //   ]
    // ];
    
    return $query;
  }
}
