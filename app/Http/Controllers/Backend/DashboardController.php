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
        $now = Carbon::now();


        //orderan
        $data['OrderWait'] = Order::whereDate('created_at','=',$now)->where('status_payment','waiting')->count();
        $data['OrderFinish'] = Order::whereDate('created_at', '=', $now)->where('status_payment','compelet')->count();
        $data['OrderTotal'] = Order::whereDate('created_at','=',$now)->count();
        //orderan

        //pengeluaran
        $nowPurchase = Purchase::whereDate('created_at','=', $now)->sum('price');
        $data['purchase'] = 'Rp. ' . number_format($nowPurchase,2,',','.');
        //penngeluaran

        //pemasukan
        $nowincome = Income::whereDate('created_at','=',$now)->sum('price');
        $nowOrder = Order::whereDate('created_at','=',$now)->where('status_payment','success')->sum('total_price');
        $data['AllIncomeNow'] ='Rp. ' . number_format($nowincome + $nowOrder,2,',','.') ;
        //pemasukan

        // order yang belm bayar
        $data['UnpaidOrderNow'] = 'Rp. ' . number_format(Order::whereDate('created_at','=',$now)->where('status_payment','waiting')->sum('total_price'),2,',','.');
        // order yang belm bayar

        //total saldo
        $incomeAll = Income::sum('price');
        $purchaseAll = Purchase::sum('price');
        $orderAll = Order::where('status_payment','success')->sum('total_price');
        $data['SaldoTotal'] = 'Rp. ' . number_format($incomeAll + $orderAll - $purchaseAll,2,',','.');
        //total saldo
        // $data['income_total'] = 'Rp. ' . number_format($totalPemasukan,2,',','.');
        // $data['total_modal'] = 'Rp. ' . number_format($modal,2,',','.');
        // $data['order'] = 'Rp. ' . number_format($total_order,2,',','.');

        // //perhari
        // $data['now_purchase'] ='Rp. ' . number_format($nowPurchase,2,',','.'); ;
        // $data['now_order'] ='Rp. ' . number_format($nowOrder,2,',','.'); ;

        return view('backend.dashboard.index', $data);
    }
}
