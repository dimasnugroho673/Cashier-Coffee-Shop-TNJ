<?php

namespace App\Http\Controllers\Backend;

use PDF;
use App\Models\Order;
use App\Models\OrderedMenu;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $orders = Order::latest('created_at');

            if (request('date_from') != "" && request('date_to') != "") {
                $orders = $orders->whereBetween(DB::raw('DATE(created_at)'), [request('date_from'), request('date_to')]);
            }

            $orders = $orders->get();
            // $orders->map(function($order)
            // {
            //     $order->ordered_menus =
            //    return $order;
            // });

            return DataTables::of($orders)
                ->addIndexColumn()
                ->addColumn('total_price', function($order) {
                    $element = 'Rp. ' . number_format($order->total_price, 0,',','.');
                    return $element;
                })
                ->addColumn('order_number', function($order) {
                    $element = '<code>' . $order->order_number . '</code>';
                    return $element;
                })
                ->addColumn('action', function($row) {
                    $btn = '
            <a href="javascript:void(0)" class="btn btn-sm btn-invoice me-1" data-detail="' . htmlspecialchars($row) . '"  data-id=' . $row->id . '>Invoice</a>
            ';
                    return $btn;
                })
                ->rawColumns(['total_price', 'order_number', 'action'])
                ->make(true);
        }

        $data['title'] = "Order";

        return view('backend.order.index', $data);
    }

    public function invoice($orderNumber)
    {
        $data['title'] = "Invoice";
        $orderID = Order::where('order_number', $orderNumber)->first()->id;
        $data['company'] = 'Dummy Company';
        $data['orders'] = OrderedMenu::join('orders', 'orders.id', '=', 'ordered_menus.order_id')->where('ordered_menus.order_id', $orderID)->get();

        $data['orders']->order = $data['orders'][0]->order;
        // dd($data['orders']);
        // $data['orders']->map(function ($data)
        // {
        //     $this->_formatData($data);

        //     return $data;
        // });

        // return view('guest.invoice', $data);
        $pdf = PDF::loadView('guest.invoice', $data)->setPaper('a6', 'potrait');
        return $pdf->stream();
    }

    private function _formatData($d)
    {
        $d->menus = $d->menu;

        return $d;
    }
}
