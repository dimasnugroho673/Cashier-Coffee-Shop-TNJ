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
        $total_income = Income::sum('price');
        $total_order = Order::sum('total_price');
        $modal = Income::with('typeincome')->where('typeincome_id',1)->sum('price');

        $totalPemasukan = $total_income + $total_order;
        // dd($totalPemasukan);
        $data['purchase'] = 'Rp. ' . number_format($total_purchase,2,',','.');
        $data['income_total'] = 'Rp. ' . number_format($totalPemasukan,2,',','.');
        $data['total_modal'] = 'Rp. ' . number_format($modal,2,',','.');
        $data['order'] = 'Rp. ' . number_format($total_order,2,',','.');
        // dd($modal);





        // $data['income'] = Income::where('price')->count();
        // $data['order'] = Order::where('price')->count();
        // $data['total'] = $order + $income - $purchase;
        // dd($data);


        return view('backend.dashboard.index', $data);
    }
}
