<?php

namespace App\Http\Controllers;

use App\Events\NewHistory;
use App\Models\Commande;
use App\Models\History;
use App\Models\Menu;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CommandeController extends Controller
{
    public function store(Request $request)
    {
        $menuId = $request->input('menuId');
        $quantity = $request->input('quantity');
        $menu = Menu::findOrFail($menuId);

        $command = new Commande([
            'menu_id' => $menuId,
            'quantity' => $quantity
        ]);
        $command->save();

        $history = new History([
            'entity_id' => $command->id,
            'entity_type' => 'commande',
            'author' => null,
            'action' => History::$create,
            'changes' => json_encode([
                'command_name' => 'Un client a commandé ' . $quantity . " quantité(s) de " . $menu->menu_name
            ]),
        ]);
        $history->save();
        event(new NewHistory($history));

        return response()->json($command, Response::HTTP_CREATED);
    }
}
