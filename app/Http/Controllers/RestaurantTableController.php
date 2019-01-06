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

    public function register(Request $request)
    {
        $table = RestaurantTable::create([
            'table_number' => $request['table_number'],
        ]);

        return new RestaurantTableResource($table);
    }

    public function delete($table_number)
    {
        $meals = DB::table('meals')->where('table_number', $table_number)->get()->toArray();

        //VER CHAVES ESTRANGEIRAS NAS TABELAS PARA APAGAR
        foreach($meals as $meal) {
            DB::table('meals')->where('table_number', $meal->table_number)->delete();
        }

        DB::table('restaurant_tables')->where('table_number', $table_number)->delete();

        return response()->json(null, 204);
    }
}
