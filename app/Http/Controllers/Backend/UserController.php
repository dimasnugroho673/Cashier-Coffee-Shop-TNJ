<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $users = User::select('users.*', 'role_users.*')
                ->join('role_users', 'role_users.user_id', '=', 'users.id')
                // ->join('roles', 'roles.id', '=', 'users.id')
                ->get();

            $users->map(function ($user) {
                $user->role = $user->role;
                return $user;
            });

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('role', function($row) {
                    $role = '';

                    if ($row->role->name == 'admin') {
                        $role = '<span class="badge rounded-pill bg-warning shadow-sm"><strong>' . ucwords($row->role->name) . '</strong></span>';
                    } else if ($row->role->name == 'cashier') {
                        $role = '<span class="badge rounded-pill bg-gray shadow-sm"><strong>' . ucwords($row->role->name) . '</strong></span>';
                    }

                    return $role;
                })
                ->addColumn('action', function($row) {
                    $btn = '
            <a href="javascript:void(0)" class="btn btn-outline-primary btn-sm btn-edit me-1" data-detail="' . htmlspecialchars($row) . '"  data-id=' . $row->id . '>Edit</a>
            <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm btn-delete" data-detail="' . htmlspecialchars($row) . '"  data-id=' . $row->id . '>Delete</a>
            ';
                    return $btn;
                })
                ->rawColumns(['action', 'role'])
                ->make(true);
        }

        $data['roles'] = Role::all();
        $data['title'] = 'User';

        return view('backend.user.index', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role_id' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'photo' => ''
        ]);

        if ($user) {
            RoleUser::create([
                'user_id' => $user->id,
                'role_id' => $request->role_id
            ]);
        }

        $response = [
            "message" => "Data berhasil dibuat",
            "status" => true
        ];

        return Response::json($response, 201);
    }

    public function show($id)
    {
        $user = User::select('users.*', 'role_users.*')
            ->join('role_users', 'role_users.user_id', '=', 'users.id')
            ->where('users.id', $id)
            ->first();

        $response = [
            "status" => true,
            "message" => "",
            "data" => $user
        ];

        return Response::json($response, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role_id' => 'required'
        ]);

        $user = User::find($id);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password != "") {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        if ($user) {
            RoleUser::where('user_id', $id)->update([
                'user_id' => $id,
                'role_id' => $request->role_id
            ]);
        }

        $response = [
            "message" => "Data berhasil diubah",
            "status" => true
        ];

        return Response::json($response, 201);
    }

    public function delete($id)
    {
        User::destroy($id);

        $response = [
            "message" => "Data berhasil dihapus",
            "status" => true
        ];

        return Response::json($response, 201);
    }
}
