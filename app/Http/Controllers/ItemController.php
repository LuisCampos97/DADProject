<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;
use App\Item;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('page')) {
            return ItemResource::collection(Item::paginate(5));
        } else {
            return ItemResource::collection(Item::all());
        }
    }

    public function show($id)
    {
        return new ItemResource(Item::find($id));
    }

    public function store(Request $request)
    {
        /* $request->validate([
            'name' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
            'email' => 'required|email|unique:users,email',
            'age' => 'integer|between:18,75',
            'password' => 'min:3',
        ]);
        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($user->password);
        $user->save();
        return response()->json(new UserResource($user), 201); */
    }

    public function update(Request $request, $id)
    {
        /* $request->validate([
            'name' => 'required|min:3|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/',
            'email' => 'required|email|unique:users,email,' . $id,
            'age' => 'integer|between:18,75',
        ]);
        $user = User::findOrFail($id);
        $user->update($request->all());
        return new UserResource($user); */
    }

    public function destroy($id)
    {
        $user = Item::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }
}
