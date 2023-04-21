<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductModel extends Model
{
    use HasFactory, SoftDeletes;

    public $table = "product";
    protected $fillable = ["product_name", "product_price", "id_category", "stock"];

    // Retrieve the category instance of the product
    public function category()
    {
        return $this->belongsTo(CategoryModel::class, "id_category");
    }
    public function histories()
    {
        return $this->morphMany(History::class, 'entity');
    }
}
