<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

namespace App\Exports;

use App\Models\Pegawai;
use App\Models\Pembelian;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class reportPBL implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $tgl1;
    protected $tgl2;

    public function __construct($tgl1, $tgl2)
    {
        $this->tgl1 = $tgl1;
        $this->tgl2 = $tgl2;
    }

    /**
     * @return \Illuminate\Support\Collection
     */

    public function styles(Worksheet $sheet)
    {
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        $sheet->getStyle('A1:F' . ($sheet->getHighestRow()))->applyFromArray($styleArray);

        $styleArray = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'font' => ['bold' => true],
        ];

        $sheet->getStyle('A1:H1')->applyFromArray($styleArray);
    }
    public function collection()
    {
        $results = Pembelian::whereBetween('created_at', [$this->tgl1, $this->tgl2 . ' 23:59:59'])->orderBy('created_at', 'DESC')->get();
        foreach ($results as $item) {
            $pegawai = Pegawai::where('no_pegawai', $item->no_pegawai)->first();
            $item['nama_pegawai'] = $pegawai->nama;
            unset($item['no_pegawai']);
        }

        $output = [];

        foreach ($results as $result) {
            $output[] = [
                $result->no_pembelian,
                $result->created_at,
                $result->total_harga,
                $result->nama_pegawai,
                $result->kode_produk ? $result->kode_produk : 'null',
                $result->keterangan ? $result->keterangan : 'null',
            ];
        }

        return collect($output);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["Nota", 'Tgl. tranksaksi', 'Total_Harga', 'Nama Pegawai', 'Kode Produk', 'Keterangan'];
    }
}
