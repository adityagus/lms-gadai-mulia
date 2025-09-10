<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\AksesJabatan;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Models\DocumentRegion;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Excel as ExcelFormat;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MigrasiDataController extends Controller
{
    public function export()
    {
        $data = [
            'documents' => Announcement::all()->toArray(),
            'document_regions' => DocumentRegion::all()->toArray(),
            'akses_jabatan' => AksesJabatan::all()->toArray(),
        ];

        return Excel::download(new class($data) implements WithMultipleSheets {
            private $data;
            public function __construct($data) { $this->data = $data; }
            public function sheets(): array {
                return [
                    new class($this->data['documents']) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithTitle {
                        private $arr; public function __construct($arr) { $this->arr = $arr; }
                        public function array(): array { return $this->arr; }
                        public function title(): string { return 'documents'; }
                    },
                    new class($this->data['document_regions']) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithTitle {
                        private $arr; public function __construct($arr) { $this->arr = $arr; }
                        public function array(): array { return $this->arr; }
                        public function title(): string { return 'document_regions'; }
                    },
                    new class($this->data['akses_jabatan']) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithTitle {
                        private $arr; public function __construct($arr) { $this->arr = $arr; }
                        public function array(): array { return $this->arr; }
                        public function title(): string { return 'akses_jabatan'; }
                    },
                ];
            }
        }, 'migrasi_data.xlsx', ExcelFormat::XLSX);
    }

    // IMPORT dari Excel
    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls']);
        $data = Excel::toArray([], $request->file('file'));

        // dd(array_slice($data[0], 1));
        // Sheet 0: documents
        foreach(array_slice($data[0], 1) as $row) {
            if (empty($row[0])) continue;
            $tgl_berlaku = null;
            if (!empty($row[4])) {
              if (is_numeric($row[4])) {
                $tgl_berlaku = Date::excelToDateTimeObject($row[4])->format('Y-m-d');
              } else {
                $tgl_berlaku = Carbon::parse($row[4])->format('Y-m-d');
              }
          }
            $announcemment = Announcement::updateOrCreate(['id' => $row[0]], [
                'submenu_id' => $row[1] == 'Memo' ? 1 : null,
                'title' => $row[2] ?? null,
                'no_surat' => $row[3] ?? null,
                'tgl_berlaku' => $tgl_berlaku ?? null,
                'url' => $row[2] . '/' . $row[5] ?? null,
                'menu_order' => $row[6] ?? null,
                'created_by' => $row[7] ?? null,
                'created_at' => "Create By Migrasi Data",
                'updated_by' => $row[9] ?? null,
                'updated_at' => $row[10] ?? null,
                'deleted_by' => $row[11] ?? null,
                'deleted_at' => $row[12] ?? null,
            ]);
            $idMap[$row[0]] = $announcemment->id;
        }

      foreach (array_slice($data[1], 1) as $row) {
        $newDocId = $idMap[$row[0]] ?? null;
        if ($newDocId) {
          if ($row[1] == 999) {
            foreach (Cabang::all() as $cabang) {
              DocumentRegion::updateOrCreate([
                'document_id' => $newDocId,
                'regional_id' => $cabang->id,
              ]);
            }
          } else {
            DocumentRegion::updateOrCreate([
              'document_id' => $newDocId,
              'regional_id' => $row[1],
            ]);
          }
        }
      }

      foreach (array_slice($data[2], 1) as $row) {
        if (empty($row[0]))
          continue;
        if ($row[2] == 999) {
          foreach (Jabatan::all() as $jabatan) {
            AksesJabatan::updateOrCreate([
              'document_id' => $row[1] ?? null,
              'kd_jbt' => $jabatan->id,
              'user' => $row[3] ?? null,
              'akses' => 1,
            ]);
          }
        } else {
          AksesJabatan::updateOrCreate([
            'document_id' => $row[1] ?? null,
            'kd_jbt' => $row[2] ?? null,
            'user' => $row[3] ?? null,
            'akses' => 1,
          ]);
        }
      }
        
        
        // // Sheet 1: document_regions
        // foreach(array_slice($data[1], 1) as $row) {
        //     $newDocId = $idMap[$row[0]] ?? null;
        //     if($newDocId){
        //         DocumentRegion::updateOrCreate([
        //             'document_id' => $newDocId,
        //             'regional_id' => $row[1],
        //         ]);
        //     }
        // }
        // // Sheet 2: akses_jabatan
        // // dd(array_slice($data[2], 1));
        // foreach(array_slice($data[2], 1) as $row) {
        //     if (empty($row[0])) continue;
        //     dd($row);
            
        //     AksesJabatan::updateOrCreate(['id' => $row[0]], [
        //         'document_id' => $row[1] ?? null,
        //         'kd_jbt' => $row[2] ?? null,
        //         'user' => $row[3] ?? null,
        //         'akses' => 1,
        //     ]);
        // }
        return back()->with('success', 'Import selesai!');
    }
}
