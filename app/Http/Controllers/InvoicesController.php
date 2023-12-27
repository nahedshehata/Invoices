<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\InvoicesAttachment;
use App\Models\InvoicesDetails;
use App\Models\Section;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class InvoicesController extends Controller
{

    public function index()
    {
        $invoices = invoices::all();
        return view('invoices.index', ['invoices'=>$invoices]);
    }

    public function create()
    {
        $section = Section::all();
        return view('invoices.add', ['section' => $section]);

    }
    public function store(Request $request)
    {
        Invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
        ]);
        $invoice_id = invoices::latest()->first()->id;
        InvoicesDetails::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'section_id' => 1,
            'Amount_collection' => $request->Amount_collection,
            'Due_date' => $request->Due_date,
            'note' => $request->note,
            'Total' => $request->Total,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'invoice_Date' => $request->invoice_Date,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
        ]);
        if ($request->hasFile('pic')) {
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            InvoicesAttachment::create([
                'file_name' => $file_name,
                'invoice_number' => $request->invoice_number,
                'invoice_id' =>$invoice_id,
                'created_by' => Auth::user()->name,
            ]);
            $image->move(public_path('Attachments/' . $request->invoice_number), $file_name);
        }
        $user = User::get();
        $invoices = Invoices::latest()->first();
        Notification::send($user, new \App\Notifications\AddInvoices($invoices->id));
        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return redirect('/invoices');

    }
    public function show(Invoices $invoice)
    {
        $invoiceId = $invoice->id;
        $details = InvoicesDetails::where('id_Invoice', $invoice->id)->get();
        $attachments = InvoicesAttachment::where('invoice_id', $invoice->id)->get();
        return view('invoices.details_invoice', ['invoices' => $invoice, 'attachments' => $attachments, 'details' => $details]);
    }

    public function edit(Invoices $invoice){
        $sections=Section::all();
        return view('invoices.edit_invoice', ['invoice' => $invoice, 'sections' => $sections]);

    }
    public function update(Request $request, $invoice)
    {
        $invoice = Invoices::findOrFail($invoice);

        $invoice->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);

        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return back();
    }

    public function destroy(Request $request, Invoices $invoice)
    {
        if (Gate::allows('owner')) {
            $invoice->delete();
            return redirect('/invoices');
        } else {
            abort(403, 'Unauthorized');
        }
    }
    public function getproducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("Product_name", "id");
        return json_encode($products);
    }

    public function showStatusUpdate(Invoices $invoice){

        if (Gate::allows('owner')) {
            return view('invoices.status_update', ['invoice' => $invoice]);
        }else {
            abort(403,);
        }
    }

    public function statusUpdate(Invoices  $invoice)
    {

        $formattedPaymentDate = Carbon::createFromFormat('m/d/Y', str_replace(' ', '', request()->Payment_Date))->format('Y-m-d');
        if (request()->Status === 'مدفوعة') {
            $invoice->update([
                'Value_Status' => 1,
                'Status' => request()->Status,
                'Payment_Date' =>$formattedPaymentDate,
            ]);
            InvoicesDetails::create([
                'id_Invoice' => $invoice->id,
                'invoice_number' => request()->invoice_number,
                'product' => request()->product,
                'section_id' => request()->section_id,
                'Status' => request()->Status,
                'Value_Status' => 1,
                'Amount_collection' =>request()->Amount_collection,
                'Amount_Commission'=>request()->Amount_Commission,
                'Discount' => request()->Discount,
                'Total' =>request()->Total,
                'Value_VAT' => request()->Value_VAT,
                'Rate_VAT' => request()->Rate_VAT,
                'note' => request()->note,
                'Payment_Date' => $formattedPaymentDate,

            ]);
        }
        else {
            $invoice->update([
                'Value_Status' => 3,
                'Status' => request()->Status,
                'Payment_Date' => request()->Payment_Date,
            ]);
            InvoicesDetails::create([
                'id_Invoice' => $invoice->id,
                'invoice_number' => request()->invoice_number,
                'product' => request()->product,
                'section_id' => request()->section_id,
                'Amount_Commission'=>request()->Amount_Commission,
                'Status' => request()->Status,
                'Value_Status' => 3,
                'note' => request()->note,
                'Payment_Date' => $formattedPaymentDate,
            ]);
        }
        session()->flash('Status_Update');
        return redirect('/invoices');
    }

}
