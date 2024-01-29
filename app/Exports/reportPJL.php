<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class reportPJL implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
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

        $sheet->getStyle('A1:H' . ($sheet->getHighestRow()))->applyFromArray($styleArray);

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
        $results = DB::table('penjualan')
            ->select(
                'penjualan.no_penjualan',
                'penjualan.created_at',
                'penjualan.telp_pelanggan',
                'p.nama as nama_pegawai',
                'penjualan.total_harga'
            )
            ->leftJoin('pegawai as p', 'p.no_pegawai', '=', 'penjualan.no_pegawai')
            ->whereBetween('penjualan.created_at', [$this->tgl1, $this->tgl2 . ' 23:59:59'])
            ->orderBy('penjualan.created_at', 'asc')
            ->get();

        $output = [];

        foreach ($results as $result) {
            $produk = DB::table('detail_produk as dp')
                ->select('produk.merek', 'dp.jumlah', 'dp.subtotal')
                ->leftJoin('produk', 'dp.kode_produk', '=', 'produk.kode_produk')
                ->where('dp.no_penjualan', $result->no_penjualan)
                ->get();

            $jasa = DB::table('detail_jasa as dj')
                ->select('jasa.nama_jasa', 'dj.jumlah', 'dj.subtotal')
                ->leftJoin('jasa', 'dj.id_jasa', '=', 'jasa.id_jasa')
                ->where('dj.no_penjualan', $result->no_penjualan)
                ->get();

            // Menambahkan hasil penjualan
            if (count($produk) > 0) {
                $output[] = [
                    $result->no_penjualan,
                    $result->created_at,
                    $result->telp_pelanggan ?: 'null',
                    $result->nama_pegawai,
                    $produk[0]->merek, $produk[0]->jumlah, $produk[0]->subtotal,
                    $result->total_harga
                ];
                // Menambahkan produk
                for ($i = 1; $i < count($produk); $i++) {
                    $p = $produk[$i];
                    $output[] = [
                        '', '', '', '', $p->merek, $p->jumlah, $p->subtotal, ''
                    ];
                }
                foreach ($jasa as $j) {
                    $output[] = [
                        '', '', '', '', $j->nama_jasa, $j->jumlah, $j->subtotal, ''
                    ];
                }
            } else {
                $output[] = [
                    $result->no_penjualan,
                    $result->created_at,
                    $result->telp_pelanggan ?: 'null',
                    $result->nama_pegawai,
                    $jasa[0]->nama_jasa, $jasa[0]->jumlah, $jasa[0]->subtotal,
                    $result->total_harga
                ];
                // Menambahkan jasa
                for ($i = 1; $i < count($jasa); $i++) {
                    $j = $jasa[$i];
                    $output[] = [
                        '', '', '', '', $j->nama_jasa, $j->jumlah, $j->subtotal, ''
                    ];
                }
            }
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
        return ["Nota", 'Tgl. tranksaksi', 'Telp. Pelanggan', 'Nama Pegawai', 'Produk / Jasa', 'Jumlah', 'Subtotal', 'Total Harga'];
    }
}
