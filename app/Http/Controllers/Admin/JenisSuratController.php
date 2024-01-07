<?php

namespace App\Http\Controllers\Admin;

use App\Models\JenisSurat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JenisSuratController extends Controller
{
    /**
     * Construct for the resource.
     */
    public function __construct(private $name = "Jenis Surat", private $create = 0, private $read = 0, private $update = 0, private $delete = 0)
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
            return view('admin.setting.surat.index', [
                'name' => $this->name,
                'surat' => JenisSurat::latest()->get(),
                'pages' => $this->get_access($this->name, auth()->user()->group_id)
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
            return view('admin.setting.surat.create', [
                'name' => $this->name
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
        $this->get_access_page();
        if ($this->create == 1) {
            try {
                $validate = \Illuminate\Support\Facades\Validator::make($request->all(), [
                    'js_name' => ['required', 'string', 'max:255'],
                ]);

                if (!$validate->fails()) {
                    JenisSurat::create([
                        'js_name' => $request->input('js_name')
                    ]);

                    return redirect()->to(route('jenis_surat.index'))->with('success', 'Data Saved!');
                } else {
                    return redirect()->back()->with('failed',$validate->errors());
                }
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->with('failed', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('failed', 'You not Have Authority!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisSurat $jenisSurat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisSurat $jenisSurat)
    {
        $this->get_access_page();
        if ($this->update == 1) {
            return view('admin.setting.surat.edit', [
                'name' => $this->name,
                'surat' => $jenisSurat->find(request()->segment(2))
            ]);
        } else {
            return redirect()->back()->with('failed', 'You not Have Authority!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisSurat $jenisSurat)
    {
        $this->get_access_page();
        if ($this->update == 1) {
            try {
                $validated = \Illuminate\Support\Facades\Validator::make($request->all(), [
                    'js_name' => ['required', 'string', 'max:255'],
                ]);

                if (!$validated->fails()) {
                    JenisSurat::where('js_id',$jenisSurat->js_id)->update([
                        'js_name' => $request->input('js_name')
                    ]);

                    return redirect()->to(route('jenis_surat.index'))->with('success', 'Data Saved!');
                } else {
                    return redirect()->back()->with('failed',$validated->errors());
                }
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->with('failed', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('failed', 'You not Have Authority!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisSurat $jenisSurat)
    {
        $this->get_access_page();
        if ($this->delete == 1) {
            try {
                $data = $jenisSurat->find(request()->segment(2));
                JenisSurat::destroy($data->js_id);

                return redirect()->back()->with('success', 'Data Deleted!');
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->with('failed', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('failed', 'You not Have Authority!');
        }
    }
}
