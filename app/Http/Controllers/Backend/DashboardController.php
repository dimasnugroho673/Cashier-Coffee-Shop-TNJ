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
        // $data['purchase'] = Purchase::where('price')->count();
        // $data['income'] = Income::where('price')->count();
        // $data['order'] = Order::where('price')->count();
        // $data['total'] = $order + $income - $purchase;
        // dd($data);


        return view('backend.dashboard.index', $data);
    }
}
