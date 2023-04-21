<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    public static $create = "CREATE";
    public static $update = "UPDATE";
    public static $delete = "DELETE";
    use HasFactory;
    protected $fillable = ['entity_type', 'changes', 'entity_id', 'action', 'author'];

    public function author()
    {
        return $this->belongsTo(User::class, 'author');
    }
}
