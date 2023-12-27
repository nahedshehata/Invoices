@extends('layouts.master')
@section('title')
    تعديل الاقسام
@stop
@section('content')
    <div style="margin-top: 20px; padding-top: 20px;">
        <form method="POST" action="{{ route('sections.update',$section->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="exampleInputEmail1">اسم القسم</label>
                <input type="text" class="form-control" id="section_name" name="section_name" value="{{$section->section_name}}">
            </div>

            <div class="form-group">
                <label for="exampleFormControlTextarea1">ملاحظات</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{$section->description}}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">تعديل</button>
        </form>
    </div>
@endsection

