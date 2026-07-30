<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\Announcement;
use App\Contracts\Repositories\MasterRepositoryInterface;

class DocumentReportController extends Controller
{
    protected $masterRepository;

    public function __construct(MasterRepositoryInterface $masterRepository)
    {
        $this->masterRepository = $masterRepository;
    }

    public function getReport(Request $request)
    {
        $jabatans = Cache::remember('report_master_jabatans', 1800, function () {
            return collect($this->masterRepository->getJabatan())->keyBy('kd_jabatan');
        });

        $wilayahs = Cache::remember('report_master_wilayahs', 1800, function () {
            return collect($this->masterRepository->getWilayah())->keyBy('kd_wilayah');
        });

        $regionsGrouped = DB::table('document_region')
            ->get()
            ->groupBy('document_id');

        $rows = DB::table('documents as d')
            ->leftJoin('submenu as sm', 'd.submenu_id', '=', 'sm.id')
            ->leftJoin('document_position as dp', 'd.id', '=', 'dp.document_id')
            ->select(
                'd.id', 'd.title', 'd.no_surat', 'd.tgl_berlaku', 'd.updated_at', 'd.created_at', 'd.deleted_at',
                'sm.name as ketentuan_dokumen', 'd.type',
                'dp.kd_jbt'
            )
            ->orderBy('d.created_at', 'desc')
            ->orderBy('dp.id', 'asc')
            ->get();

        $ptsCache = [];
        foreach ($regionsGrouped as $docId => $regs) {
            $mappedPts = [];
            foreach ($regs as $reg) {
                $regId = (string) $reg->regional_id;
                $wilayahId = $regId;

                if (!isset($wilayahs[$wilayahId]) && strlen(str_pad($regId, 4, '0', STR_PAD_LEFT)) === 4) {
                    $padded = str_pad($regId, 4, '0', STR_PAD_LEFT);
                    $wilayahId = $padded[1];
                }

                $name = isset($wilayahs[$wilayahId]) ? $wilayahs[$wilayahId]->nm_wilayah : $regId;
                if (!$name || is_numeric($name)) {
                    continue;
                }

                $lower = strtolower($name);
                if ($lower === 'all') {
                    $mappedPts[] = 'All';
                } elseif ($lower === 'jakarta') {
                    $mappedPts[] = 'Jaya';
                } elseif ($lower === 'jawa barat') {
                    $mappedPts[] = 'Jabar';
                } elseif ($lower === 'kepri') {
                    $mappedPts[] = 'Kepri';
                } else {
                    $mappedPts[] = ucwords($lower);
                }
            }
            $ptsCache[$docId] = implode(', ', array_filter(array_unique($mappedPts)));
        }

        $formattedDocs = [];
        foreach ($rows as $row) {
            $docId = $row->id;
            $pts = $ptsCache[$docId] ?? '';
            if (empty($pts)) {
                $pts = '-';
            }

            $kdJbt = $row->kd_jbt;
            $position = '-';
            if ($kdJbt) {
                $position = isset($jabatans[$kdJbt]) ? $jabatans[$kdJbt]->nm_jabatan : $kdJbt;
            }

            $formattedDocs[] = [
                'position' => $position,
                'pt' => $pts,
                'tanggal_upload' => $row->updated_at ?? $row->created_at,
                'ketentuan_dokumen' => $row->ketentuan_dokumen ?? $row->type ?? '-',
                'tanggal_berlaku' => $row->tgl_berlaku,
                'nomor_surat' => $row->no_surat,
                'perihal_judul' => $row->title,
                'status' => is_null($row->deleted_at) ? 'Active' : 'Inactive'
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $formattedDocs
        ]);
    }

    public function exportExcel(Request $request)
    {
        $data = $request->input('data', []);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set Headers
        $headers = ["Jabatan", "PT.", "Tanggal Upload", "Ketentuan Dokumen", "Tanggal Berlaku", "Nomor Surat", "Perihal/Judul", "Status"];
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '1', $header);
            $sheet->getStyle($col . '1')->getFont()->setBold(true);
            $col++;
        }

        // Set Data
        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, $item['position'] ?? '-');
            $sheet->setCellValue('B' . $row, $item['pt'] ?? '-');

            $tglUpload = (isset($item['tanggal_upload']) && $item['tanggal_upload']) ? date('d M Y', strtotime($item['tanggal_upload'])) : '-';
            $sheet->setCellValue('C' . $row, $tglUpload);

            $sheet->setCellValue('D' . $row, $item['ketentuan_dokumen'] ?? '-');

            $tglBerlaku = (isset($item['tanggal_berlaku']) && $item['tanggal_berlaku']) ? date('d M Y', strtotime($item['tanggal_berlaku'])) : '-';
            $sheet->setCellValue('E' . $row, $tglBerlaku);

            $sheet->setCellValue('F' . $row, $item['nomor_surat'] ?? '-');
            $sheet->setCellValue('G' . $row, $item['perihal_judul'] ?? '-');
            $sheet->setCellValue('H' . $row, $item['status'] ?? '-');
            $row++;
        }

        // Auto size columns
        foreach (range('A', 'H') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        $fileName = 'laporan_dokumen_' . time() . '.xlsx';
        $tempFile = tempnam(sys_get_temp_dir(), 'excel');
        $writer->save($tempFile);

        return response()->download($tempFile, $fileName)->deleteFileAfterSend(true);
    }
}
