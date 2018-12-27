<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Order;
use Illuminate\Http\Request;

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

    public function ordersByCook($responsible_cook_id)
    {
        //Get orders
        $orders = Order::where('responsible_cook_id', $responsible_cook_id)
        ->orderBy('start', 'asc')
        ->orderBy('state', 'desc')
        ->get();

        //Return collection of orders as a resource
        return OrderResource::collection($orders);
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
