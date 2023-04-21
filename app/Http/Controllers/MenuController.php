<?php

namespace App\Http\Controllers;

use App\Events\NewHistory;
use App\Models\History;
use App\Models\Menu;
use App\Models\Recette;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\Response;

class MenuController extends Controller
{
    public function index()
    {
        return response()->json(Menu::with(['products', 'user'])->get());
    }
    public function show(int $id)
    {
        return response()->json(Menu::where('id', $id)->with(['products', 'user', 'histories'])->first());
    }
    public function destroy(int $id)
    {
        $data = Menu::findOrFail($id);
        $history = new History([
            'entity_id' => $data->id,
            'entity_type' => 'menu',
            'author' => auth()->user()->id,
            'action' => History::$delete,
            'changes' => json_encode([
                'menu_name' => $data->getOriginal('menu_name') . ' est supprimé ',
            ]),
        ]);
        $history->save();
        $data->delete();
        event(new NewHistory($history));
        return response()->json(['status' => $data]);
    }
    public function update(Request $request, int $id)
    {
        $menu = Menu::findOrFail($id);
        $menu->menu_name = $request->input('menu_name');
        $history = new History([
            'entity_id' => $menu->id,
            'entity_type' => 'menu',
            'author' => auth()->user()->id,
            'action' => History::$update,
            'changes' => json_encode([
                'menu_name' => $menu->getOriginal('menu_name') . ' est devenu ' . $menu->menu_name,
            ]),
        ]);
        $history->save();
        $menu->save();
        event(new NewHistory($history));
        return response()->json($menu);
    }
    public function store(Request $request)
    {
        $menu = new Menu([
            'menu_name' => $request->input('menu_name'),
            'user_id' => auth()->user()->id
        ]);
        $menu->save();
        foreach ($request->input('recettes') as $recette) {
            $rec = new Recette([
                'menu_id' => $menu->id,
                'product_id' => $recette['selectedProductId'],
                'quantity' => $recette['quantity'],
                'unite' => $recette['unite']
            ]);
            $rec->save();
        }
        $history = new History([
            'entity_id' => $menu->id,
            'entity_type' => 'menu',
            'author' => auth()->user()->id,
            'action' => History::$create,
            'changes' => json_encode([
                'menu_name' => $menu->getOriginal('menu_name') . ' créé '
            ]),
        ]);
        $history->save();
        event(new NewHistory($history));
        return response()->json($menu, Response::HTTP_CREATED);
    }
}
