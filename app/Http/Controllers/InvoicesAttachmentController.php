<?php

namespace App\Http\Controllers;

use App\Models\InvoicesAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InvoicesAttachmentController extends Controller
{
    public function index()
    {
        //
    }
    public function create()
    {
        //
    }
    public  function store(Request $request)
    {
        $this->validate($request, [

            'file_name' => 'mimes:pdf,jpeg,png,jpg',

        ], [
            'file_name.mimes' => 'صيغة المرفق يجب ان تكون   pdf, jpeg , png , jpg',
        ]);

        $image = $request->file('file_name');
        $file_name = $image->getClientOriginalName();
        $attachments =  new InvoicesAttachment();
        $attachments->file_name = $file_name;
        $attachments->invoice_number = $request->invoice_number;
        $attachments->invoice_id = $request->invoice_id;
        $attachments->Created_by = Auth::user()->name;
        $attachments->save();

        // move pic
        $imageName = $request->file_name->getClientOriginalName();
        $request->file_name->move(public_path('Attachments/'. $request->invoice_number), $imageName);

        session()->flash('Add', 'تم اضافة المرفق بنجاح');
        return back();
    }
    public function show(InvoicesAttachment $invoicesAttachment)
    {

    }
    public function edit(InvoicesAttachment $invoicesAttachment)
    {

    }

    public function update(Request $request, InvoicesAttachment $invoicesAttachment)
    {

    }


    public function destroy(InvoicesAttachment $invoicesAttachment){

        $invoicesAttachment->delete();
        $filePath = $invoicesAttachment->invoice_number . '/' . $invoicesAttachment->file_name;
       Storage::disk('public')->delete($filePath);
        return redirect('/invoices');

    }
}
