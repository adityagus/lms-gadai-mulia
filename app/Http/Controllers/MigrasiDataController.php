<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\DocumentRegion;
use App\Models\AksesJabatan;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelFormat;

class MigrasiDataController extends Controller
{
    public function export()
    {
        $data = [
            'documents' => Announcement::all()->toArray(),
            'document_regions' => DocumentRegion::all()->toArray(),
            'akses_jabatan' => AksesJabatan::all()->toArray(),
        ];

        return Excel::download(new class($data) implements \Maatwebsite\Excel\Concerns\WithMultipleSheets {
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

        // Sheet 0: documents
        foreach(array_slice($data[0], 1) as $row) {
            if (empty($row[0])) continue;
            Document::updateOrCreate(['id' => $row[0]], [
                'submenu_id' => $row[1] ?? null,
                'title' => $row[2] ?? null,
                'no_surat' => $row[3] ?? null,
                'url' => $row[4] ?? null,
                'tgl_berlaku' => $row[5] ?? null,
                'menu_order' => $row[6] ?? null,
                'created_by' => $row[7] ?? null,
                'created_at' => $row[8] ?? null,
                'updated_by' => $row[9] ?? null,
                'updated_at' => $row[10] ?? null,
                'deleted_by' => $row[11] ?? null,
                'deleted_at' => $row[12] ?? null,
            ]);
        }
        // Sheet 1: document_regions
        foreach(array_slice($data[1], 1) as $row) {
            if (empty($row[0])) continue;
            DocumentRegion::updateOrCreate([
                'document_id' => $row[0],
                'regional_id' => $row[1],
            ]);
        }
        // Sheet 2: akses_jabatan
        foreach(array_slice($data[2], 1) as $row) {
            if (empty($row[0])) continue;
            AksesJabatan::updateOrCreate(['id' => $row[0]], [
                'document_id' => $row[1] ?? null,
                'kd_jbt' => $row[2] ?? null,
                'user' => $row[3] ?? null,
                'akses' => $row[4] ?? null,
            ]);
        }
        return back()->with('success', 'Import selesai!');
    }
}
