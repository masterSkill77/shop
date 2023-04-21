<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $histories = History::with('author')->orderBy('created_at', 'desc')->get();
        return response()->json($histories);
    }
}
