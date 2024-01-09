<?php

namespace App\Http\Controllers\Admin;

use App\Models\Verifikasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VerifikasiController extends Controller
{
    /**
     * Construct for the resource.
     */
    public function __construct(private $name = "Verifikasi", private $create = 0, private $read = 0, private $update = 0, private $delete = 0)
    {
        //
    }

    /**
     * Generate Access for Controller.
     */
    private function get_access_page()
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
            if (request()->prodi_id && request()->js_id) {
                return view('admin.setting.verifikasi.index3', [
                    'name' => $this->name,
                    'pages' => $this->get_access($this->name, auth()->user()->group_id),
                    'verifikasi' => Verifikasi::where('prodi_id', request()->prodi_id)->where('js_id', request()->js_id)->get(),
                    'jenis' => \App\Models\JenisSurat::all(),
                    'user' => \App\Models\User::all(),
                    'selectJenis' => request()->js_id,
                    'selectProdi' => request()->prodi_id
                ]);
            } else {
                if (request()->prodi_id) {
                    return view('admin.setting.signature.index2', [
                        'name' => $this->name,
                        'prodi' => \App\Models\Prodi::where('prodi_id', request()->prodi_id)->first(),
                        'jenis' => \App\Models\JenisSurat::all()
                    ]);
                } else {
                    return view('admin.setting.verifikasi.index', [
                        'name' => $this->name,
                        'prodi' => \App\Models\Prodi::all(),
                    ]);
                }
            }
        } else {
            return redirect()->back()->with('failed', 'You not Have Authority!');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->get_access_page();
            if ($this->create == 1) {
                Verifikasi::create([
                    'ver_step' => $request->input('ver_step'),
                    'js_id' => $request->input('jenis'),
                    'prodi_id' => $request->input('prodi'),
                    'user_id' => $request->input('user_id'),
                ]);

                return redirect()->back()->with('success', 'Data Saved!');
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
    public function show(Verifikasi $verifikasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Verifikasi $verifikasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Verifikasi $verifikasi)
    {
        try {
            $this->get_access_page();
            if ($this->update == 1) {
                Verifikasi::where('ver_id', $verifikasi->ver_id)->update([
                    'ver_step' => $request->input('ver_step'),
                    'js_id' => $request->input('jenis'),
                    'prodi_id' => $request->input('prodi'),
                    'user_id' => $request->input('user_id'),
                ]);

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
    public function destroy(Verifikasi $verifikasi)
    {
        try {
            $this->get_access_page();
            if ($this->delete == 1) {
                $data = $verifikasi->find(request()->segment(2));
                Verifikasi::destroy($data->ver_id);

                return redirect()->to(route('verifikasi.index'))->with('success', 'Data Deleted!');
            } else {
                return redirect()->back()->with('failed', 'You not Have Authority!');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }
}
