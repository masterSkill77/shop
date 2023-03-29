<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;

    public $table = "product";
    protected $fillable = ["product_name", "product_price", "id_category"];

    // Retrieve the category instance of the product
    public function category()
    {
        return $this->belongsTo(CategoryModel::class, "id_category");
    }
}
