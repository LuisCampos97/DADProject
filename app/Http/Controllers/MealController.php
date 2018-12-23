<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $meal = new Meal();
        $meal->fill($request->all());
        $meal->save();
        return response()->json(new MealResource($meal), 201);
    }
}
