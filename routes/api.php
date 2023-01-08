<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Models\Income;
use App\Models\Order;
use App\Models\Purchase;
use Illuminate\Support\Facades\Response;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/order', [OrderController::class, 'store'])->name('frontend.order.store');
Route::get('/orders', [OrderController::class, 'listOrder'])->name('frontend.order');
Route::post('user/', [ProfileController::class, 'update'])->name('frontend.user.update');

// Route::middleware(['can:cashier', 'auth'])->group(function () { 
    // Route::get('user/me', [ProfileController::class, 'me']);
// });

Route::get('/rekap', function ()
{
    $date = request('date'); 

    $orders = Order::whereYear('created_at', $date)->get();
    $purchases = Purchase::whereYear('created_at', $date)->get();
    $incomes = Income::whereYear('created_at', $date)->get();

    $newData = [];

    // $tmp = 0;
    foreach ($orders as $key => $order) {
        $newData[$key]['date'] = date('d-M-Y', strtotime($order->created_at));
        $newData[$key]['name'] = 'Pemesanan makanan/minuman, order number: ' . $order->order_number;
        $newData[$key]['debit'] = number_format($order->total_price, 0,',','.');
        $newData[$key]['credit'] = '';
    }

    foreach ($purchases as $key => $purchase) {
        $newData[$key]['date'] = date('d-M-Y', strtotime($purchase->created_at));
        $newData[$key]['name'] = 'Beli ' . $purchase->name . ' - ' . $purchase->quantity;
        $newData[$key]['debit'] = '';
        $newData[$key]['credit'] = number_format($purchase->price, 0,',','.');
    }

    foreach ($incomes as $key => $income) {
        $newData[$key]['date'] = date('d-M-Y', strtotime($income->created_at));
        $newData[$key]['name'] = $income->name_income;
        $newData[$key]['debit'] =  number_format($income->price, 0,',','.');
        $newData[$key]['credit'] = '';
    }

    $newData = json_decode (json_encode ($newData), FALSE);

    $html = '
    <table border="1">
    <tr>
      <th>Tgl</th>
      <th>Nama</th>
      <th>Debit</th>
      <th>Kredit</th>
    </tr>
  
    ';

    foreach ($newData as $d) {
        $html .= '<tr>
            <td>' . $d->date . '</td>
            <td>' . $d->name . '</td>
            <td>' . $d->debit . '</td>
            <td>' . $d->credit . '</td>
        </tr>';
    }

    $html .= '</table>';


    // [
    //     'orders' => $orders,
    //     'purchases' => $purchases,
    //     'incomes' => $incomes
    // ]
    // return Response::json($newData);

    return $html;
});