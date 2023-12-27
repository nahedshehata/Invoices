<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\Section;
use Illuminate\Http\Request;

class CustomersReportController extends Controller
{
    public function index()
    {
        $sections = Section::all();
        return view('reports.customers_report', compact('sections'));
    }
    public function searchCustomers(Request $request)
    {
        if ($request->Section && $request->product && $request->start_at == '' && $request->end_at == '') {
            $invoices = invoices::select('*')->where('section_id', '=', $request->Section)->where('product', '=', $request->product)->get();
            $sections = Section::all();
            return view('reports.customers_report', compact('sections'))->withDetails($invoices);
        } else {
            $start_at = date($request->start_at);
            $end_at = date($request->end_at);
            $invoices = Invoices::whereBetween('invoice_Date', [$start_at, $end_at])->where('section_id', '=', $request->Section)->where('product', '=', $request->product)->get();
            $sections = Section::all();
            return view('reports.customers_report', compact('sections'))->withDetails($invoices);
        }
    }
}
