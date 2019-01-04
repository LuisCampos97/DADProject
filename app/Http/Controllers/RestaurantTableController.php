<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\RestaurantTableResource;
use App\RestaurantTable;

class RestaurantTableController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('page')) {
            return RestaurantTableResource::collection(RestaurantTable::paginate(5));
        } else {
            return RestaurantTableResource::collection(RestaurantTable::all());
        }
    }

    public function register(Request $request)
    {
        $table = RestaurantTable::create([
            'table_number' => $request['table_number'],
        ]);

        return new RestaurantTableResource($table);
    }
}
