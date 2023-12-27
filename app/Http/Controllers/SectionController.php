<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $section=Section::all();
        return view('sections.section',compact('section'));
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
        $validatedData = $request->validate([
            'section_name' => 'required|unique:sections|max:255',
        ], [
            'section_name.required' => 'يرجي ادخال اسم القسم',
            'section_name.unique' => 'اسم القسم مسجل مسبقا',
        ]);
        Section::createSection();
        session()->flash('Add', 'تم اضافة القسم بنجاح ');
        return redirect('/sections');
    }
    public function show(Section $section)
    {
        return view('sections.section',compact('section'));

    }

    public function edit(Section $section)
    {
        return view('sections.edit',compact('section'));
    }

    public function update(Section $section)
    {

        Section::updateSection($section);
        session()->flash('edit','تم التعديل بنجاح');
        return redirect('/sections');

    }
    public function destroy(Section $section,Request $request)
    {

        $section->delete();
        session()->flash('delete','تم حذف القسم بنجاح');
        return redirect('/sections');
    }
}
