<?php

namespace App\Http\Controllers\api;

use session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WizardController extends Controller
{
  public function saveStep(Request $request, $step)
  {
    // Simpan ke session dengan key sesuai step
    session(['wizard.' . $step => $request->all()]);
    return response()->json(['message' => 'Step saved']);
  }

  public function getSession()
  {
    return response()->json([
      'wizard' => session('wizard', [])
    ]);
  }

  public function finish()
  {
    $wizard = session('wizard');
    var_dump($wizard);
    // Simpan $wizard ke database sesuai kebutuhan
    // ...proses simpan ke tabel pengumuman, akses_wilayah, akses_jabatan

    // Bersihkan session
    session()->forget('wizard');
    return response()->json(['message' => 'Wizard completed']);
  }
}
