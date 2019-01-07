<?php

namespace App\Http\Controllers;

use App\Http\Resources\MealResource;
use App\Meal;
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
        $request->validate([
            'table_number' => 'required',
        ]);
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

    public function tablesWitoutActiveMeals()
    {
        $tablesWithActiveMeals = DB::table('restaurant_tables')
            ->whereNotIn('table_number', function ($q) {
                $q->select('table_number')
                    ->from('meals')
                    ->where('state', 'active');
            })
            ->select('table_number')
            ->get();

        return response()->json($tablesWithActiveMeals, 200);
    }
}
