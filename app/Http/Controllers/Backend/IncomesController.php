<?php

namespace App\Http\Controllers\Backend;

use App\Models\Income;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class IncomesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $income = Income::with('typeincome')->latest()->get();
    if ($request->ajax()) {
        $data = Income::with('typeincome')->latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row){
                return Blade::render(
                    '
                <a href="javascript:void(0)" class="btn btn-sm btn-edit me-1" data-bs-toggle="modal" data-bs-target="#incomeModal" data-detail="' . htmlspecialchars($row) . '" data-id=' . $row->id . '>Edit</a>
                <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm btn-delete" data-detail="' . htmlspecialchars($row) . '"  data-id= ' . $row->id . ' >Delete</a>',
                    ['row' => $row]
                );
            })
            ->addColumn('typeincome', function ($row) {
                return $row->typeincome->name;
            })
            ->rawColumns(['action','typeincome'])
            ->make(true);
    }
        // dd($income);
        $data['title'] = 'Pemasukan Dari luar order';
        return view('backend.income.index',$data);
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
            'date' => 'required|date',
            'name' => 'required',
            'typeincome_id' => 'required',
            'price' => 'required',
            'desc' => 'required'
        ]);
        $income = Income::create([
            'date' => $request->date,
            'name' => $request->name,
            'typeincome_id' => $request->typeincome_id,
            'price' => $request->price,
            'desc' => $request->desc,
        ]);

        $response = [
            'message' => "Data Berhasil Ditambahkan",
            'status' => true,
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
        $income = Income::find($id);

        $response = [
            'message' => "",
            'status' => true,
            'data' => $income
        ];

        return Response::json($response,201);
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
            'date' => 'required|date',
            'name' => 'required',
            'typeincome_id' => 'required',
            'price' => 'required',
            'desc' => 'required'
        ]);
        $income = Income::find($id);
        $income->date = $request->date;
        $income->name = $request->name;
        $income->typeincome_id = $request->typeincome_id;
        $income->price = $request->price;
        $income->desc = $request->desc;
        $income->save();

        $response = [
            'message' => 'Data berhasil diupdate',
            'status' => true,
        ];

        return Response::json($response,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Income::destroy($id);
        $response = [
            'message' => "Data berhasil dihapus",
            'status' => true,
        ];
        return Response::json($response,201);
    }
}
