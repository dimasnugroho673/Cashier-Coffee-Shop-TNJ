<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index()
    {
        // $users = User::paginate();
        $data['title'] = 'User';
        // $data['users'] = User::paginate();

        return view('backend.user.index', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'photo' => ''
        ]);

        $response = [
            "message" => "Data berhasil dibuat",
            "status" => true
        ];

        return Response::json($response, 201);
    }

    public function json()
    {
        $users = User::select('users.*', 'role_users.*')
        ->join('role_users', 'role_users.user_id', '=', 'users.id')
        // ->join('roles', 'roles.id', '=', 'users.id')
        ->get();

        // $users = User::get();

        $users->map(function($user)
        {
            $user->role = $user->role;
            return $user;
        });
        
        return DataTables::of($users)
        ->addIndexColumn()
        ->addColumn('role', function($row) {
            $role = '';

            if ($row->role->name == 'admin') {
                $role = '
                <span class="badge rounded-pill bg-warning shadow-sm"><strong>' . ucwords($row->role->name) . '</strong></span>
            ';
            } else if ($row->role->name == 'cashier') {
                $role = '
                <span class="badge rounded-pill bg-gray shadow-sm"><strong>' . ucwords($row->role->name) . '</strong></span>
            ';
            }

            return $role;
        }) 
        ->addColumn('aksi', function($row){
            $btn = '
            <a href="javascript:void(0)" class="btn btn-outline-primary btn-sm btn-edit me-1" data-id=' . $row->id . '>Edit</a>
            <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm btn-delete" data-id=' . $row->id . '>Delete</a>
            ';
            return $btn;
        })
        ->rawColumns(['aksi', 'role'])
        ->make(true);
    }

    public function destroy($id)
    {
        User::destroy($id);

        $response = [
            "message" => "Data berhasil dihapus",
            "status" => true
        ];

        return Response::json($response, 201);
    }
}
