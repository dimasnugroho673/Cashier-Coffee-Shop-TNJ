<?php

namespace App\Http\Controllers\Backend;

use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables as DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $categori = Categories::latest()->get();
            return DataTables::of($categori)
                ->addIndexColumn()
                ->addColumn('action',function($row) {
                    $btn = '<a href="javascript:void(0)" class="btn btn-outline-primary btn-sm btn-edit me-1" data-id=' . $row->id . '>Edit</a>
                            <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm btn-delete" data-id=' . $row->id . '>Delete</a>';
                    return $btn;
                })
                ->rawColumn('action')
                ->make('true');
        }
        $data['title'] = 'Kategori Table';
        return view('backend.categories.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $categori = Categories::create([
            'name' => $request->name,
        ]);

        $response = [
            "message" => "Data berhasil dibuat",
            "status" => true
        ];

        return Response::json($response,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categori = Categories::findorFail($id);

        $response = [
            'status'=>true,
            'message'=>"",
            'data' => $categori
        ];
        return Response::json($response,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $categori = Categories::findorFail($id);
        $categori->name =$request->name;
        $categori->save();
        $response = [
            "message" => "Data berhasil diubah",
            "status" => true
        ];

        return Response::json($response,201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Categories::destroy($id);
        $response = [
            "message" => "Data berhasil dihapus",
            "status" =>true
        ];
        return Response::json($response,201);
    }
}
