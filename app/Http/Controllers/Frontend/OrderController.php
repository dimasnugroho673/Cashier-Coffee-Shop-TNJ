<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Menu;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\OrderedMenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if (!request('ordered_menus')) {
            $menus = Menu::get();

            return Inertia::render('Order', [
                'menus' =>  $menus->map(function ($m) {
                   return [
                    'id' => $m->id,
                    'name' => $m->name,
                    'price' => $m->price
                   ];
                }),
                'orderedMenu' => null,
            ]);
        } else {
            $menus = Menu::get();
            $orderedMenus = request('ordered_menus');

            return Inertia::render('Order', [
                'menus' =>  $menus->map(function ($m) {
                   return [
                    'id' => $m->id,
                    'name' => $m->name,
                    'price' => $m->price
                   ];
                }),
                'orderedMenu' => $orderedMenus
            ]);
        }
       
    }

    public function listOrder()
    {
        
    }

    // public function index()
    // {
    //     $data['title'] = 'Order';
    //     return view('frontend.order.index', $data);
    // }

    public function store(Request $request)
    {
        $orderedMenus = json_decode(json_encode($request->ordered_menus), FALSE);

        $orderNumber = Order::whereDate('created_at', Carbon::today())->latest('created_at')->get();

        $create = Order::create([
            "order_number" => date('Y') . date('m') . date('d') . sprintf('%03d', count($orderNumber) + 1),
            "table_number" => $request->table_number,
            "cashier_name" => $request->cashier_name,
            "customer_number" => count($orderNumber) + 1,
            "desc" => $request->desc,
            "total_price" => $request->total_price
        ]);

        if ($create) {
            foreach ($orderedMenus as $order) {
                OrderedMenu::create([
                    "order_id" => $create->id,
                    "quantity" => $order->quantity,
                    "menu_id" => $order->menu_id
                ]);
            }

            $response = [
                "status" => true,
                "message" => "Order berhasil dibuat",
                "data" => $orderedMenus[0]->quantity
            ];

            return Response::json($response, 201);
        }
    }
}
