<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\ProductModel;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['data' => ProductModel::with(['category', 'histories'])->get()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $product = new ProductModel();
            $product->product_name = $request->input("product_name");
            $product->product_price = $request->input("product_price");
            $product->id_category = $request->input("id_category");
            $product->save();
            $history = new History([
                'entity_id' => $product->id,
                'entity_type' => 'product',
                'author' => auth()->user()->id,
                'action' => History::$create,
                'changes' => json_encode([
                    'product_name' => $product->getOriginal('product_name') . ' créé '
                ]),
            ]);
            $history->save();
            return response()->json(['data' => $product], 200);
        } catch (Exception $e) {
            throw $e;
            return response()->json(['error' => $e], 403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $product = ProductModel::with('category')->find($id);
            $histories = History::where('entity_id', $id)->where('entity_type', 'Product');
            return response()->json(['data' => $product], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $product = ProductModel::find($id);
            $data = [
                'product_name' => $request->input('product_name') ?? $product->product_name,
                'product_price' => $request->input('product_price') ?? $product->product_price,
                'id_category' => $request->input('id_category') ?? $product->id_category
            ];
            $product->update($data);
            $history = new History([
                'entity_id' => $product->id,
                'entity_type' => 'product',
                'author' => auth()->user()->id,
                'action' => History::$update,
                'changes' => json_encode([
                    'product_name' => $product->getOriginal('product_name') . ' est devenu ' . $product->product_name,
                    'product_price' => $product->getOriginal('product_price') . ' est devenu ' . $product->product_price,
                ]),
            ]);
            $history->save();
            return response()->json(['data' => $product], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @return 'affected row'
     */
    public function destroy($id)
    {
        try {
            $product = ProductModel::findOrFail($id);
            $affectedRow = ProductModel::destroy($id);
            $history = new History([
                'entity_id' => $product->id,
                'entity_type' => 'product',
                'author' => auth()->user()->id,
                'action' => History::$delete,
                'changes' => json_encode([
                    'product_name' => $product->getOriginal('product_name') . ' est supprimé ',
                ]),
            ]);
            return response()->json(['status' => $affectedRow], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        }
    }
}
