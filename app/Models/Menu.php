<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['menu_name', 'user_id'];

    public function products()
    {
        return $this->belongsToMany(ProductModel::class, 'recettes', 'menu_id', 'product_id')->withPivot(['quantity', 'unite']);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function recettes()
    {
        return $this->hasMany(Recette::class, 'menu_id');
    }
}
