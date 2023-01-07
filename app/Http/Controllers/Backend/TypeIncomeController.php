<?php

namespace App\Http\Controllers\Backend;

use App\Models\Categories;
use App\Models\TypeIncome;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class TypeIncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = TypeIncome::latest()->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" class="btn btn-outline-primary btn-sm btn-edit me-1" data-id='. $row->id . '>Edit</a>
                            <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm btn-delete" data-id=' . $row->id . '>Delete</a>';
                    return $btn;
            })
            ->rawColumns(['action'])
            ->make('true');
        }
        $data['title'] = 'Tipe Pemasukan';
        // $data['typeincome'] = TypeIncome::first();
        return view('backend.typeincome.index',$data);
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
        $typeincome = TypeIncome::create([
            'name' => $request->name
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
        $typeincome = TypeIncome::find($id);
        dd($typeincome);

        return view('backend.typeincome.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $typeincome = TypeIncome::find($id);
        $response = [
            'status'=>true,
            'message'=>"",
            'data' => $typeincome,
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
        $typeincome = TypeIncome::find($id);
        $typeincome->name = $request->name;
        $typeincome->save();
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
        TypeIncome::destroy($id);
        $response = [
            "message" => "Data berhasil dihapus",
            "status" =>true
        ];
        return Response::json($response,201);
    }
}
