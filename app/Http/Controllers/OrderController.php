<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Order;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('page')) {
            return OrderResource::collection(Order::paginate(5));
        } else {
            return OrderResource::collection(Order::all());
        }
    }

    public function show($id)
    {
        return new OrderResource(Order::find($id));
    }

    public function create(Request $request)
    {
        Order::create([
            'state' => $request['state'],
            'item_id' => $request['item_id'],
            'meal_id' =>$request['meal_id'],
            'responsible_cook_id' =>$request['responsible_cook_id'],
            'start' =>$request['start'],
        ]);
    }
}
