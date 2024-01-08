<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Construct for the resource.
     */
    public function __construct(private $name = "Dashboard")
    {
        //
    }

    /**
     * Display data for the resource.
     */
    public function home()
    {
        $suratKeluar = \App\Models\SuratKeluar::leftJoin('jenis_surats', 'surat_keluars.js_id', '=', 'jenis_surats.js_id')
            ->select('jenis_surats.js_name as jenis', \Illuminate\Support\Facades\DB::raw('COUNT(jenis_surats.js_id) as total'))
            ->whereMonth('surat_keluars.created_at', date('m'))
            ->groupBy('surat_keluars.js_id', 'jenis_surats.js_name')
            ->orderBy('total')
            ->get();

        $nama_surat = [];
        $total_surat = [];
        foreach ($suratKeluar as $surat) {
            $nama_surat[] = $surat->jenis;
            $total_surat[] = $surat->total;
        }

        return view('admin.home', [
            'name' => $this->name,
            'nama_surat' => $nama_surat,
            'total_surat' => $total_surat
        ]);
    }

    /**
     * Display data surat keluar in archive when data is accepted.
     */
    public function archive()
    {
        if (!request()->prodi_id) {
            return view('admin.archive.archives', [
                'name' => 'Archive',
                'prodi' => \App\Models\Prodi::all()
            ]);
        } else {
            $suratKeluar = \App\Models\SuratKeluar::where('surat_keluars.prodi_id', request()->prodi_id)->where('surat_keluars.sk_status', 'Accepted')->get();
            $latestVer = null;
            foreach ($suratKeluar as $surat) {
                $verifikasi = \App\Models\Verifikasi::where('js_id', $surat->js_id)->latest('ver_step')->first();
                if ($verifikasi != null) {
                    $latestVer = $verifikasi->ver_step;
                }
            }
            return view('admin.archive.archive', [
                'name' => 'Archive',
                'surat' => \App\Models\SuratKeluar::leftJoin('jenis_surats', 'surat_keluars.js_id', '=', 'jenis_surats.js_id')
                    ->where('surat_keluars.prodi_id', request()->prodi_id)
                    ->where('surat_keluars.sk_step', $latestVer)
                    ->where('surat_keluars.sk_status', 'Accepted')
                    ->latest('surat_keluars.created_at')
                    ->get(),
                'prodi' => \App\Models\Prodi::where('prodi_id',request()->prodi_id)->first()
            ]);
        }
    }
}
