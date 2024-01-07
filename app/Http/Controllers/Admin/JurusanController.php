<?php

namespace App\Http\Controllers\Admin;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JurusanController extends Controller
{
    /**
     * Construct for the resource.
     */
    public function __construct(private $name = "Jurusan", private $create = 0, private $read = 0, private $update = 0, private $delete = 0)
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
            return view('admin.setting.jurusan.index', [
                'name' => $this->name,
                'jurusan' => Jurusan::latest()->get(),
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
            return view('admin.setting.jurusan.create', [
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
                Jurusan::create([
                    'jurusan_name' => $request->input('jurusan_name')
                ]);

                return redirect()->to(route('jurusan.index'))->with('success','Data Saved!');
            } catch(\Illuminate\Database\QueryException $e){
                return redirect()->back()->with('failed', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('failed', 'You not Have Authority!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Jurusan $jurusan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jurusan $jurusan)
    {
        $this->get_access_page();
        if ($this->update == 1) {
            return view('admin.setting.jurusan.edit', [
                'name' => $this->name,
                'jurusan' => $jurusan->find(request()->segment(2))
            ]);
        } else {
            return redirect()->back()->with('failed', 'You not Have Authority!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jurusan $jurusan)
    {
        $this->get_access_page();
        if ($this->update == 1) {
            try {
                Jurusan::where('js_id', $jurusan->js_id)->update([
                    'jurusan_name' => $request->input('jurusan_name')
                ]);

                return redirect()->to(route('jurusan.index'))->with('success','Data Updated!');
            } catch(\Illuminate\Database\QueryException $e){
                return redirect()->back()->with('failed', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('failed', 'You not Have Authority!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jurusan $jurusan)
    {
        $this->get_access_page();
        if ($this->delete == 1) {
            try {
            $data = $jurusan->find(request()->segment(2));
            Jurusan::destroy($data->jurusan_id);

            return redirect()->back()->with('success', 'Data Deleted!');
            } catch(\Illuminate\Database\QueryException $e){
                return redirect()->back()->with('failed', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('failed', 'You not Have Authority!');
        }
    }
}
