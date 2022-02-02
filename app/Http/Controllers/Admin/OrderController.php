<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller

{
    public function show()
    {
        $order=Order::all();
        return view('admin.order.order1',compact('order'));
    }   
}

