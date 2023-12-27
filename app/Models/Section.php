<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;


class Section extends Model
{
    use HasFactory;
    protected $fillable = [
        'section_name',
        'description',
        'Created_by',
    ];
   public static function createSection(){
       return self::create([
           'section_name' => request()->section_name,
           'description' => request()->description,
           'Created_by' => (Auth::user()->name),

       ]);
   }
   public static  function updateSection($section){

       $sec = $section::find($section->id);
       $sec->update([
           'section_name' => request()->section_name,
           'description' => request()->description,
       ]);
   }
}
