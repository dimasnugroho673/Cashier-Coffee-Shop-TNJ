<?php

namespace App\Http\Controllers\Frontend;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class ProfileController extends Controller
{
    public function index()
    {
        return Inertia::render('Profile', []);
    }

    public function me()
    {
        return Response::json([
            'status' => true,
            'data' => [
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'role' => [
                    'name' => 'Kasir',
                ],
                'joined_at' => date('Y', strtotime(auth()->user()->created_at)) 
            ]
        ], 200);
    }
}
