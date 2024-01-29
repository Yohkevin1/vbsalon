<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class C_Dashboard extends Controller
{
    protected $penjualan, $pembelian, $D_PJL, $D_PBL;
    public function __construct()
    {
        $this->penjualan = new Penjualan();
        $this->pembelian = new Pembelian();
    }

    public function index()
    {
        return view('dashboard');
    }

    public function income()
    {
        $tgl1 = date('Y-m-01');
        $tgl2 = date('Y-m-t');
        $trs = Penjualan::whereBetween('created_at', [$tgl1, $tgl2 . ' 23:59:59'])->sum('total_harga');
        return response()->json($trs);
    }

    public function outcome()
    {
        $tgl1 = date('Y-m-01');
        $tgl2 = date('Y-m-t');
        $trs = Pembelian::whereBetween('created_at', [$tgl1, $tgl2 . ' 23:59:59'])->sum('total_harga');
        return response()->json($trs);
    }

    public function jmlhPJL()
    {
        $tgl1 = date('Y-m-01');
        $tgl2 = date('Y-m-t');
        $trs = Penjualan::whereBetween('created_at', [$tgl1, $tgl2 . ' 23:59:59'])->count();
        return response()->json($trs);
    }

    public function TrsByYears(Request $request)
    {
        $tahun = $request->input('tahun');
        $PJL = $this->penjualan->jmlhPJLByYears($tahun);

        $PBL = $this->pembelian->jmlhPBLByYears($tahun);
        $data = [
            "pjl" => $PJL,
            "pbl" => $PBL,
        ];
        return response()->json($data);
    }

    public function incomePrdJasa(Request $request)
    {
        $tahun = $request->input('tahun');
        $bulan = $request->input('bulan');
        if ($bulan == null)
            $bulan = date('n');

        $produkCollection = $this->penjualan->incomeByProduk($tahun, $bulan);
        $jasaCollection = $this->penjualan->incomeByJasa($tahun, $bulan);

        $produk = (int) $produkCollection->first()->Total;
        $jasa = (int) $jasaCollection->first()->Total;

        $data = [
            "prd" => $produk,
            "jas" => $jasa,
        ];

        return response()->json($data);
    }
}
