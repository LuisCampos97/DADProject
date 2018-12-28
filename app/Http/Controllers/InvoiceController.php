<?php

namespace App\Http\Controllers;

use App\Http\Resources\InvoiceResource;
use App\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('page')) {
            return InvoiceResource::collection(Invoice::paginate(5));
        } else {
            return InvoiceResource::collection(Invoice::all());
        }
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
}
