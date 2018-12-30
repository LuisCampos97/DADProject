<?php

namespace App\Http\Controllers;

use App\Http\Resources\MealResource;
use App\Meal;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MealController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('page')) {
            return MealResource::collection(Meal::paginate(5));
        } else {
            return MealResource::collection(Meal::all());
        }
    }

    public function show($id)
    {
        return new MealResource(Meal::find($id));
    }

    public function create(Request $request)
    {
        Meal::create([
            'state' => $request['state'],
            'table_number' => $request['table_number'],
            'start' => $request['start'],
            'responsible_waiter_id' => $request['responsible_waiter_id'],
            'total_price_preview' => $request['total_price_preview'],
        ]);
    }

    public function updateTotal(Request $request, $id, $total)
    {
        $meal = Meal::findOrFail($id);
        
        $meal->total_price_preview += $total;

        $meal->save();

        return new MealResource($meal);
    }

    public function terminate(Request $request, $id)
    {
        $meal = Meal::findOrFail($id);
        
        $meal->state = "terminated";

        $meal->save();

        return new MealResource($meal);
    }
}
