<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $sections = Section::all();
        return view('products.product', compact('products', 'sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Product::create([
            'Product_name' => $request->Product_name,
            'section_id' => $request->section_id,
            'description' =>$request->description,
        ]);
        session()->flash('Add', 'تم اضافة المنتج بنجاح ');
        return redirect('/products');
    }

    public function show(Product $product)
    {
    }

    public function edit(Product $product)
    {

        $sections = Section::all();
        return view('products.edit',['product'=> $product, 'sections'=>$sections]);

    }

    public function update(Request $request, Product $product)
    {

        $product->update([
            'Product_name' => $request->input('Product_name'),
            'description' => $request->input('description'),
            'section_id' => $request->input('section_id'),
        ]);

        session()->flash('Edit', 'تم تعديل المنتج بنجاح');
        return redirect('/products');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        session()->flash('delete', 'تم حذف القسم بنجاح');
        return redirect('/products');
    }
}
