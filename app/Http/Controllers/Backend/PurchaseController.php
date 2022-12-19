<?php

namespace App\Http\Controllers\Backend;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class PurchaseController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $purchases = Purchase::query();

            return DataTables::of($purchases)
                ->addIndexColumn()
                ->addColumn('price', function ($row) {
                    return $row->price;
                })
                ->addColumn('action', function ($row) {
                    $btn = '
                    <a href="javascript:void(0)" class="btn btn-outline-info btn-sm btn-detail me-1" data-detail="' . htmlspecialchars($row) . '" data-id=' . $row->id . ' data-bs-toggle="modal" data-bs-target="#detailModal">Detail</a>
                    <a href="javascript:void(0)" class="btn btn-outline-primary btn-sm btn-edit me-1" data-detail="' . htmlspecialchars($row) . '" data-id=' . $row->id . '>Edit</a>
                    <a href="javascript:void(0)" class="btn btn-outline-danger btn-sm btn-delete" data-id=' . $row->id . '>Delete</a>
            ';
                    return $btn;
                })
                ->rawColumns(['action', 'price'])
                ->make(true);
        }

        $data['title'] = 'Pengeluaran';

        return view('backend.purchase.index', $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'name_item' => 'required',
            'quantity' => 'required',
            'price' => 'required|numeric',
        ]);

        if ($request->hasFile('photo_invoice')) {
            $request->validate([
                'photo_invoice' => 'image|mimes:jpg,png,jpeg|max:4096'
            ]);
        }

        $save = Purchase::create([
            'date' => $request->date,
            'name_item' => $request->name_item,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'desc' => $request->desc,
            'photo_invoice' => '',
            'user_id' => auth()->user()->id
        ]);

        if ($save && $request->hasFile('photo_invoice')) {
            $imageName = time() . "_" . $request->file('photo_invoice')->getClientOriginalName();
            $path = 'images/purchase_invoices/' . $imageName;
            Storage::disk('public')->put($path, File::get($request->file('photo_invoice')));

            Purchase::find($save->id)->update(['photo_invoice' => $path]);
        }

        $response = [
            "message" => "Data berhasil dibuat",
            "status" => true
        ];

        return Response::json($response, 201);
    }

    public function show($id)
    {
        $purchase = Purchase::where('id', $id)->first();

        $response = [
            "message" => "",
            "status" => true,
            "data" => $purchase
        ];

        return Response::json($response, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required',
            'name_item' => 'required',
            'quantity' => 'required',
            'price' => 'required|numeric',
        ]);

        if ($request->hasFile('photo_invoice')) {
            $request->validate([
                'photo_invoice' => 'image|mimes:jpg,png,jpeg|max:4096'
            ]);
        }

        $save = Purchase::where('id', $id)->update([
            'date' => $request->date,
            'name_item' => $request->name_item,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'desc' => $request->desc,
            'user_id' => auth()->user()->id
        ]);

        if ($request->hasFile('photo_invoice')) {
            $imageName = time() . "_" . $request->file('photo_invoice')->getClientOriginalName();
            $path = 'images/purchase_invoices/' . $imageName;
            Storage::disk('public')->put($path, File::get($request->file('photo_invoice')));

            Purchase::find($id)->update(['photo_invoice' => $path]);
        }

        $response = [
            "message" => "Data berhasil diubah",
            "status" => true
        ];

        return Response::json($response, 201);
    }

    public function delete($id)
    {
        $invoice = Purchase::where('id', $id)->first();

        if (file_exists(public_path() . '/' . 'storage/' . $invoice->photo_invoice_raw)) {
            unlink(public_path() . '/' . 'storage/' . $invoice->photo_invoice_raw);
            Purchase::destroy($id);
        }

        $response = [
            "message" => "Data berhasil dihapus",
            "status" => true
        ];

        return Response::json($response, 201);
    }
}
