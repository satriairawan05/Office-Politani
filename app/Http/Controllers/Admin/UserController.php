<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Construct for the resource.
     */
    public function __construct(private $name = "User", private $create = 0, private $read = 0, private $update = 0, private $delete = 0)
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
            try {
                if (auth()->user()->group_id == 1) {
                    $user = User::leftJoin('groups', 'users.group_id', '=', 'groups.group_id')->get();
                } else {
                    $user = User::leftJoin('groups', 'users.group_id', '=', 'groups.group_id')->where('users.id', auth()->user()->id)->get();
                }

                return view('admin.setting.account.index', [
                    'name' => $this->name,
                    'users' => $user,
                    'pages' => $this->get_access($this->name, auth()->user()->group_id)
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->with('failed', $e->getMessage());
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
        $this->get_access_page();
        if ($this->create == 1) {
            try {
                return view('admin.setting.account.create', [
                    'name' => $this->name,
                    'group' => \App\Models\Group::all(),
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->with('failed', $e->getMessage());
            }
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
                $validated = \Illuminate\Support\Facades\Validator::make($request->all(), [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:3', 'confirmed']
                ]);

                if (!$validated->fails()) {
                    User::create([
                        'name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'password' => bcrypt($request->input('password')),
                    ]);

                    return redirect()->to(route('user.index'))->with('success', 'Data Saved!');
                } else {
                    return redirect()->back()->with('failed',$validated->getMessageBag());
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
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
         $this->get_access_page();
        if ($this->update == 1) {
            try {
                return view('admin.setting.account.edit', [
                    'name' => $this->name,
                    'user' => $user->find(request()->segment(2)),
                    'group' => \App\Models\Group::all(),
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->with('failed', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('failed', 'You not Have Authority!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->get_access_page();
        if ($this->update == 1) {
            try {
                $validated = \Illuminate\Support\Facades\Validator::make($request->all(), [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255'],
                    'password' => ['required', 'string', 'min:3', 'confirmed']
                ]);

                if (!$validated->fails()) {
                    User::where('id', $user->id)->update([
                        'name' => $request->input('name'),
                        'email' => $request->input('email'),
                        'password' => bcrypt($request->input('password')),
                    ]);

                    return redirect()->to(route('user.index'))->with('success', 'Data Updated!');
                } else {
                    return redirect()->back()->with('failed',$validated->getMessageBag());
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
    public function destroy(User $user)
    {
        $this->get_access_page();
        $dataUser = $user->find(request()->segment(2));
        if ($this->delete == 1 && $dataUser->id != 1) {
            try {
                $data = $user->find(request()->segment(2));
                User::destroy($data->id);

                return redirect()->back()->with('success', 'Data Deleted!');
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect()->back()->with('failed', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('failed', 'You not Have Authority!');
        }
    }

    /**
     * Show the form for editing the specified resource for change password.
     */
    public function formChangePassword(User $user)
    {
        return view('admin.setting.account.change',[
            'name' => $this->name,
            'user' => $user->find(request()->segment(2))
        ]);
    }

    /**
     * Update the specified resource in storage for change password.
     */
    public function changePassword(Request $request, User $user)
    {
        try {
            $validated = \Illuminate\Support\Facades\Validator::make($request->all(), [
                'password' => ['required', 'string', 'min:3', 'confirmed']
            ]);

            if (!$validated->fails()) {
                User::where('id', $user->id)->update([
                    'password' => bcrypt($request->input('password')),
                ]);

                return redirect()->to(route('user.index'))->with('success', 'Data Updated!');
            } else {
                return redirect()->back()->with('failed',$validated->getMessageBag());
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('failed', $e->getMessage());
        }
    }
}
