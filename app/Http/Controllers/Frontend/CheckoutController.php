<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Table;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Checkout', [
            "orderedMenus" => request('ordered_menus'),
            "userLoggedIn" => auth()->user(),
            "tables" => Table::orderBy('number', 'asc')->get()
        ]);
    }
}
