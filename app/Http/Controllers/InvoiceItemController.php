<?php

namespace App\Http\Controllers;

use App\Http\Resources\InvoiceItemResource;
use App\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceItemController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('page')) {
            return InvoiceItemResource::collection(InvoiceItem::paginate(5));
        } else {
            return InvoiceItemResource::collection(InvoiceItem::all());
        }
    }

    public function show($id)
    {
        return new InvoiceItemResource(InvoiceItem::find($id));
    }

    public function create(Request $request)
    {
        $invoiceItem = InvoiceItem::create([
            'invoice_id' => $request['invoice_id'],
            'item_id' => $request['item_id'],
            'quantity' => $request['quantity'],
            'unit_price' => $request['unit_price'],
            'sub_total_price' => $request['sub_total_price'],
        ]);

        return new InvoiceItemResource($invoiceItem);
    }
}
