<?php

namespace App\Http\Controllers\Admin;

use App\Models\SuratKeluar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuratKeluarController extends Controller
{
    /**
     * Construct for the resource.
     */
    public function __construct(private $name = "Surat Keluar", private $create = 0, private $read = 0, private $update = 0, private $delete = 0, private $verifikasi = 0)
    {
        //
    }

    /**
     * Generate Access for Controller.
     */
    public function get_access_page()
    {
        $userRole = $this->get_access($this->name, auth()->user()->group_id);

        foreach ($userRole as $r) {
            if ($r->page_name == $this->name) {
                if ($r->action == 'Create') {
                    $this->create = $r->access;
                }

                if ($r->action == 'Read') {
                    $this->read = $r->access;
                }

                if ($r->action == 'Update') {
                    $this->update = $r->access;
                }

                if ($r->action == 'Delete') {
                    $this->delete = $r->access;
                }

                if ($r->action == 'Verifikasi') {
                    $this->verifikasi = $r->access;
                }
            }
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->get_access_page();
        if ($this->read == 1) {
            $suratKeluar = SuratKeluar::leftJoin('jenis_surats', 'surat_keluars.js_id', '=', 'jenis_surats.js_id')
                ->leftJoin('prodis', 'surat_keluars.prodi_id', '=', 'prodis.prodi_id')
                ->latest('surat_keluars.created_at')
                ->get();
            return view('admin.surat_keluar.index', [
                'name' => $this->name,
                'pages' =>  $this->get_access($this->name, auth()->user()->group_id),
                'surat' => $suratKeluar
            ]);
        } else {
            return redirect()->back()->with('failed', 'You not Have Authority!');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->get_access_page();
        if ($this->create == 1) {
            return view('admin.surat_keluar.create', [
                'name' => $this->name,
                'jenis' => \App\Models\JenisSurat::all(),
                'prodi' => \App\Models\Prodi::all()
            ]);
        } else {
            return redirect()->back()->with('failed', 'You not Have Authority!');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->get_access_page();
            if ($this->create == 1) {
                $suratKeluar = SuratKeluar::create([
                    'js_id' => $request->input('js_id'),
                    'prodi_id' => $request->input('prodi_id'),
                    'sk_nomor' => $request->input('sk_nomor'),
                    'sk_lampiran' => $request->input('sk_lampiran'),
                    'sk_perihal' => $request->input('sk_perihal'),
                    'sk_tujuan' => $request->input('sk_tujuan'),
                    'sk_tempat' => $request->input('sk_tempat'),
                    'sk_deskripsi' => $request->input('sk_deskripsi'),
                    'sk_tembusan' => $request->input('sk_tembusan'),
                    'sk_tgl' => \Carbon\Carbon::now(),
                ]);

                // Berhasil Simpan surat maka Jenis Surat di Increment untuk mengetahui total surat yang tersimpan
                // di jenis yang sama tertambah 1 terus
                \App\Models\JenisSurat::where('js_id', $suratKeluar->js_id)->increment('js_count');

                return redirect()->to(route('surat_keluar.index'))->with('success', 'Data Saved!');
            } else {
                return redirect()->back()->with('failed', 'You not Have Authority!');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratKeluar $suratKeluar)
    {
        $this->get_access_page();
        if ($this->read == 1) {
            return view('admin.surat_keluar.show', [
                'surat' => $suratKeluar->find(request()->segment(2)),
                'signature' => \App\Models\Signature::where('js_id', $suratKeluar->js_id)->first()
            ]);
        } else {
            return redirect()->back()->with('failed', 'You not Have Authority!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratKeluar $suratKeluar)
    {
        $this->get_access_page();
        if ($this->update == 1) {
            return view('admin.surat_keluar.edit', [
                'name' => $this->name,
                'jenis' => \App\Models\JenisSurat::all(),
                'prodi' => \App\Models\Prodi::all(),
                'surat' => $suratKeluar->find(request()->segment(2))
            ]);
        } else {
            return redirect()->back()->with('failed', 'You not Have Authority!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratKeluar $suratKeluar)
    {
        try {
            $this->get_access_page();
            if ($this->update == 1) {
                $data = $suratKeluar->find(request()->segment(2));
                // Jenis Surat ID lama
                $oldJsId = $data->js_id;

                SuratKeluar::where('sk_id', $data->sk_id)->update([
                    'js_id' => $request->input('js_id'),
                    'prodi_id' => $request->input('prodi_id'),
                    'sk_nomor' => $request->input('sk_nomor'),
                    'sk_lampiran' => $request->input('sk_lampiran'),
                    'sk_perihal' => $request->input('sk_perihal'),
                    'sk_tujuan' => $request->input('sk_tujuan'),
                    'sk_tempat' => $request->input('sk_tempat'),
                    'sk_deskripsi' => $request->input('sk_deskripsi'),
                    'sk_tembusan' => $request->input('sk_tembusan'),
                    'sk_tgl' => \Carbon\Carbon::now(),
                ]);

                // Jenis Surat ID baru
                $newJsId = $request->input('js_id');

                // Cek apakah js_id lama dan baru sama
                if ($oldJsId !== $newJsId) {
                    // Kurangi js_count pada jenis surat lama jika berbeda
                    \App\Models\JenisSurat::where('js_id', $oldJsId)->decrement('js_count');

                    // Tambahkan js_count pada jenis surat baru
                    \App\Models\JenisSurat::where('js_id', $newJsId)->increment('js_count');
                }

                return redirect()->to(route('surat_keluar.index'))->with('success', 'Data Updated!');
            } else {
                return redirect()->back()->with('failed', 'You not Have Authority!');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function verifikasi(Request $request, SuratKeluar $suratKeluar)
    {
        try {
            $this->get_access_page();
            $verify = \App\Models\Verifikasi::where('js_id', $suratKeluar->js_id)->latest('ver_step')->first();
            if ($this->verifikasi == 1) {
                $stepData = null;
                $data = $suratKeluar->find(request()->segment(2));

                if ($request->input('sk_status') == 'Accepted') {
                    $latestVer = \App\Models\Verifikasi::where('js_id', $data->js_id)->latest('ver_step')->first();
                    if ($latestVer->ver_step == $data->sk_step) {
                        $stepData = $data->sk_step;
                    } else {
                        $stepData = $data->sk_step + 1;
                    }

                    SuratKeluar::where('sk_id', $data->sk_id)->update([
                        'sk_status' => $request->input('sk_status'),
                        'sk_step' => $stepData
                    ]);
                } else {
                    $stepData = 1;
                    SuratKeluar::where('sk_id', $data->sk_id)->update([
                        'sk_status' => $request->input('sk_status'),
                        'sk_step' => $stepData
                    ]);
                }

                return redirect()->back()->with('success', 'Data Updated!');
            } else {
                return redirect()->back()->with('failed', 'You not Have Authority!');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratKeluar $suratKeluar)
    {
        try {
            $this->get_access_page();
            if ($this->delete == 1) {
                $data = $suratKeluar->find(request()->segment(2));
                SuratKeluar::destroy($data->sk_id);

                return redirect()->to(route('surat_keluar.index'))->with('success', 'Data Deleted!');
            } else {
                return redirect()->back()->with('failed', 'You not Have Authority!');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }
}
