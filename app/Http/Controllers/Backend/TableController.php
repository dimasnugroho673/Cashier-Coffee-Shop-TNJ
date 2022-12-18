<?php

namespace App\Http\Controllers\Backend;

use App\Models\Tables;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class TableController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $tables = Tables::all();

            return DataTables::of($tables)
                ->addIndexColumn()
                ->make(true);
        }

        $data['title'] = 'Daftar Meja';

        return view('backend.table.index', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'number' => 'required|numeric',
        ]);

        Tables::create([
            'number' => $request->number,
            'desc' => $request->description
        ]);

        $response = [
            "message" => "Data berhasil dibuat",
            "status" => true
        ];

        return Response::json($response, 201);
    }

    public function increaseTable(Request $request)
    {
        $addTables = $request->addTablesCount;

        $getLatest = Tables::orderBy('number', 'desc')->first();

        $number = $getLatest->number + 1;
        for ($i = 1; $i <= $addTables; $i++) {
            Tables::create([
                'number' => $number++,
                'desc' => ''
            ]);
        }

        $response = [
            "message" => "Data berhasil dibuat",
            "status" => true
        ];

        return Response::json($response, 201);
    }

    public function decreaseTable(Request $request)
    {
        $getLatest = Tables::orderBy('number', 'desc')->first();

        $number = $getLatest->number;

        Tables::where('number', $number)->delete();

        $response = [
            "message" => "Meja berhasil dikurangi",
            "status" => true
        ];

        return Response::json($response, 201);
    }

    public function show($id)
    {
        $table = Tables::where('id', $id)->first();

        $response = [
            "status" => true,
            "message" => "",
            "data" => $table
        ];

        return Response::json($response, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'number' => 'required|numeric',
        ]);

        Tables::find($id)->update([
            'number' => $request->number,
            'desc' => $request->description
        ]);

        $response = [
            "message" => "Data berhasil diubah",
            "status" => true
        ];

        return Response::json($response, 201);
    }

    public function delete($id)
    {
        Tables::destroy($id);

        $response = [
            "message" => "Data berhasil dihapus",
            "status" => true
        ];

        return Response::json($response, 201);
    }
}
