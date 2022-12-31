<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\OrderedMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        $data['title'] = 'Order';
        return view('frontend.order.index', $data);
    }

    public function store(Request $request)
    {
        $orderedMenus = json_decode(json_encode($request->ordered_menus), FALSE);

        $create = Order::create([
            "order_number" => "Rand: " . time(),
            "table_number" => $request->table_number,
            "cashier_name" => "Rand: Andi",
            "customer_number" => "Rand: 0023",
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
