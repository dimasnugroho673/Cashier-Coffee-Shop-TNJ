<?php

namespace App\Http\Controllers\Backend;

use App\Models\Income;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Blade;
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
            ->addColumn('action', function($row) {
                return Blade::render('<a href="javascript:void(0)" class="btn btn-sm btn-edit me-1" data-bs-toggle="modal" data-bs-target="#tambah-data-modal" data-detail="' . htmlspecialchars($row) . '" data-id=' . $row->id . '>Edit</a>
                <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm btn-delete" data-detail="' . htmlspecialchars($row) . '"  data-id= ' . $row->id . ' >Delete</a>'
                , ['row'=>$row]);
            })
            ->addColumn('typeincome', function($row) {
                return $row->typeincome->name;
            })
            ->addColumn('date', function($row){
                return $row->date->format('d-M-Y');
            })
            ->rawColumns(['action','typeincome'])
            ->make(true);
        }
        $data['title'] = 'Pemasukan Dari luar order';
        // dd($income);
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
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
