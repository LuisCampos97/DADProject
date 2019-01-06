<?php

namespace App\Http\Controllers;

use App\Http\Resources\RestaurantTableResource;
use App\RestaurantTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function register()
    {
        $tables = DB::table('restaurant_tables')->orderBy('table_number', 'desc')->get()->toArray();
        $lastId = $tables[0]->table_number;
        $table = RestaurantTable::create([
            'table_number' => $lastId+1,
        ]);

        return new RestaurantTableResource($table);
    }

    public function delete($table_number)
    {
        $table = RestaurantTable::where('table_number', $table_number);
        $table->delete();

        return response()->json(null, 204);
    }
}
