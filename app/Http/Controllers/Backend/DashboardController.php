<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Income;
use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{


    public function index()
    {
        $data['title'] = 'Dashboard';
        $total_purchase = Purchase::sum('price');
        $total_income = Income::sum('price');
        $total_order = Order::sum('total_price');
        $modal = Income::with('typeincome')->where('typeincome_id',1)->sum('price');
        $now = Carbon::now();
        // dd($now);
        $nowPurchase = Purchase::whereDate('created_at','=', $now)->sum('price');
        $nowOrder = Order::where('created_at','=',$now)->sum('total_price');
        // dd($nowPurchase);

        // keseluruhan
        $totalPemasukan = $total_income + $total_order;
        $data['purchase'] = 'Rp. ' . number_format($total_purchase,2,',','.');
        $data['income_total'] = 'Rp. ' . number_format($totalPemasukan,2,',','.');
        $data['total_modal'] = 'Rp. ' . number_format($modal,2,',','.');
        $data['order'] = 'Rp. ' . number_format($total_order,2,',','.');

        //perhari
        $data['now_purchase'] ='Rp. ' . number_format($nowPurchase,2,',','.'); ;
        $data['now_order'] ='Rp. ' . number_format($nowOrder,2,',','.'); ;

        return view('backend.dashboard.index', $data);
    }
}
