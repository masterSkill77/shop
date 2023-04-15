<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class MenuController extends Controller
{
    public function index()
    {
        return response()->json(Menu::with(['products', 'user'])->get());
    }
    public function show(int $id)
    {
        return response()->json(Menu::where('id', $id)->with(['products', 'user'])->first());
    }
}
