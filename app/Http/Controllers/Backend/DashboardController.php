<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Income;
use App\Models\Order;
use App\Models\Purchase;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data['title'] = 'Dashboard';
        $total_purchase = Purchase::sum('price');
        $data['purchase'] = 'Rp. ' . number_format($total_purchase,2,',','.');

        // $element = 'Rp. ' . number_format($order->total_price, 0,',','.');
        $total_income = Income::sum('price');
        $total_order = Order::sum('total_price');
        $totalPemasukan = $total_income + $total_order;
        $data['income_total'] = 'Rp. ' . number_format($totalPemasukan,2,',','.');
        // dd($totalPemasukan);

        // $data['income'] = Income::where('price')->count();
        // $data['order'] = Order::where('price')->count();
        // $data['total'] = $order + $income - $purchase;
        // dd($data);


        return view('backend.dashboard.index', $data);
    }
}
