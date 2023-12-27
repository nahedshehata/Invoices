@extends('layouts.master')
@section('title')
تعديل المنتجات
@stop
@section('content')
    <div style="margin-top: 20px; padding-top: 20px;">
        <form method="POST" action="{{ route('products.update', ['product' => $product->id])}}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="exampleInputEmail1">اسم المنتج :</label>
                <input type="text" class="form-control" id="Product_name" name="Product_name"  value="{{ $product->Product_name }}">
            </div>
            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
{{--            <select name="section_name" id="section_name" class="custom-select my-1 mr-sm-2" required>--}}
{{--                @foreach ($sections as $section)--}}
{{--                    <option>{{ $section->section_name }}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
            <select class="form-control" name="section_id" id="section_id">
                @foreach($sections as $section)
                    <option  value="{{$section->id}}"> {{$section->section_name}} </option>
                @endforeach
            </select>

            <div class="form-group">
                <label for="exampleFormControlTextarea1">ملاحظات :</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{$product->description}}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">تعديل</button>
        </form>
    </div>
@endsection


