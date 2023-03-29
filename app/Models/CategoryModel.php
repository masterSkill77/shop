<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    use HasFactory;
    public $table = "category";
    protected $fillable = ["category_name"];

    // Retrieve all the products related to category
    public function products()
    {
        return $this->hasMany(ProductModel::class, "id_category");
    }
}
