<?php

namespace App\Http\Controllers;

use App\Http\Resources\InvoiceResource;
use App\Invoice;
use App\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = DB::table('meals')
        ->select("invoices.*","meals.table_number","meals.responsible_waiter_id", "users.name as responsible_waiter_name")
        ->leftjoin('invoices', 'invoices.meal_id', '=', 'meals.id')
        ->leftjoin('users', 'users.id', '=', 'meals.responsible_waiter_id')
        ->where('invoices.state', 'paid')
        ->orderBy('date', 'desc')
        ->paginate(15);

        return $invoices;
    }

    public function show($id)
    {
        return new InvoiceResource(Invoice::find($id));
    }

    public function mealForInvoice()
    {
        $invoices = DB::table('meals')
        ->select("invoices.*","meals.table_number","meals.responsible_waiter_id", "users.name as responsible_waiter_name")
        ->leftjoin('invoices', 'invoices.meal_id', '=', 'meals.id')
        ->leftjoin('users', 'users.id', '=', 'meals.responsible_waiter_id')
        ->where('invoices.state', 'pending')
        ->get();

        return $invoices;
    }

    public function invoiceDetails($id) 
    {
        $invoice = DB::table('meals')
        ->select("invoices.*","meals.table_number","meals.responsible_waiter_id", "users.name as responsible_waiter_name")
        ->leftjoin('invoices', 'invoices.meal_id', '=', 'meals.id')
        ->leftjoin('users', 'users.id', '=', 'meals.responsible_waiter_id')
        ->where('invoices.id', $id)
        ->get();

        return $invoice;
    }

    public function invoiceItems($id) 
    {
        $invoiceItems = DB::table('invoice_items')
        ->select("invoice_items.*","items.name")
        ->leftjoin('items', 'invoice_items.item_id', '=', 'items.id')
        ->where('invoice_items.invoice_id', $id)
        ->get();

        return $invoiceItems;
    }

    public function payInvoice(Request $request, $id)
    {
        $request->validate([
            'nif' => 'required|digits:9',
            'name' => 'required|regex:/^[A-Za-záàâãéèêíóôõúçÁÀÂÃÉÈÍÓÔÕÚÇ ]+$/'
        ]);

        $invoice = Invoice::findOrFail($id);
        $invoice->update($request->all());

        $invoice->state = 'paid';
        $invoice->save();

        $meal = Meal::findOrFail($id);
        $meal->state = 'paid';
        $meal->save();

        return new InvoiceResource($invoice);
    }

    public function notPaid(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->state = 'not paid';
        $invoice->save();

        $meal = Meal::findOrFail($id);
        $meal->state = 'not paid';
        $meal->save();

        return new InvoiceResource($invoice);
    }

    public function create(Request $request)
    {
        $invoice = Invoice::create([
            'state' => $request['state'],
            'meal_id' => $request['meal_id'],
            'date' => $request['date'],
            'total_price' => $request['total_price'],
        ]);

        return new InvoiceResource($invoice);
    }
}
