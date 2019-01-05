<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemRequest;
use App\Http\Resources\ItemResource;
use App\Item;
use Illuminate\Http\Request;

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

    public function register(ItemRequest $request)
    {
        $item = new Item();
        $item->fill($request->all());
        $item->save();

        return response()->json(new ItemResource($item), 201);
    }

    public function update(ItemRequest $request, $id)
    {
        $item = Item::findOrFail($id);
        $item->update($request->all());
        return new ItemResource($item);
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        return response()->json(null, 204);
    }
}
