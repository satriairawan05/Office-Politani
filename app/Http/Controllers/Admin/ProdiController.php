<?php

namespace App\Http\Controllers\Admin;

use App\Models\Prodi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProdiController extends Controller
{
    /**
     * Construct for the resource.
     */
    public function __construct(private $name = "Program Studi", private $create = 0, private $read = 0, private $update = 0, private $delete = 0)
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
            $prodi = Prodi::leftJoin('jurusans','prodis.jurusan_id','=','jurusans.jurusan_id')->latest('prodis.prodi_id')->get();
            return view('admin.setting.prodi.index', [
                'name' => $this->name,
                'prodi' => $prodi,
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
            return view('admin.setting.prodi.create', [
                'name' => $this->name,
                'jurusan' => \App\Models\Jurusan::all()
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
                $validate = \Illuminate\Support\Facades\Validator::make($request->all(),[
                    'prodi_name' => ['required'],
                    'prodi_jenjang' => ['required'],
                    'jurusan_id' => ['required'],
                ]);

                if(!$validate->fails()){
                    Prodi::create([
                        'prodi_name'=>$request->input('prodi_name'),
                        'prodi_jenjang'=>$request->input('prodi_jenjang'),
                        'jurusan_id'=>$request->input('jurusan_id'),
                    ]);
    
                    return redirect()->to(route('prodi.index'))->with('success','Data Saved!');
                } else {
                    return redirect()->back()->with('failed',$validate->getMessageBag());
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
    public function show(Prodi $prodi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prodi $prodi)
    {
        $this->get_access_page();
        if ($this->update == 1) {
            return view('admin.setting.prodi.edit', [
                'name' => $this->name,
                'prodi' => $prodi->find(request()->segment(2)),
                'jurusan' => \App\Models\Jurusan::all()
            ]);
        } else {
            return redirect()->back()->with('failed', 'You not Have Authority!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prodi $prodi)
    {
        $this->get_access_page();
        if ($this->update == 1) {
            try {
                $validate = \Illuminate\Support\Facades\Validator::make($request->all(),[
                    'prodi_name' => ['required'],
                    'prodi_jenjang' => ['required'],
                    'jurusan_id' => ['required'],
                ]);

                if(!$validate->fails()){
                    Prodi::where('prodi_id',$prodi->prodi_id)->update([
                        'prodi_name'=>$request->input('prodi_name'),
                        'prodi_jenjang'=>$request->input('prodi_jenjang'),
                        'jurusan_id'=>$request->input('jurusan_id'),
                    ]);
    
                    return redirect()->to(route('prodi.index'))->with('success','Data Updated!');
                } else {
                    return redirect()->back()->with('failed',$validate->getMessageBag());
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
    public function destroy(Prodi $prodi)
    {
        $this->get_access_page();
        if ($this->create == 1) {
            try {
                $data = $prodi->find(request()->segment(2));
                Prodi::destroy($data->prodi_id);

                return redirect()->back()->with('success', 'Data Deleted!');
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->with('failed', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('failed', 'You not Have Authority!');
        }
    }
}
