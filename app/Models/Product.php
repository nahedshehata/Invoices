<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'Product_name',
        'description',
        'section_id',
    ];


    public  static function updateProduct($product, $request){

        $productToUpdate =Product::find($product->id);
        $productToUpdate->update([
            'Product_name' => $request->Product_name,
            'section_id' =>$request->section_id,
            'description' => $request->description,
        ]);

    }

    public function section(){
        return $this->belongsTo(Section::class);
    }

}
