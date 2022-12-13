<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $data['title'] = 'Menu';
        return view('backend.menu.index', $data);
    }
}
