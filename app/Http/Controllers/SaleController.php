<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Bonus;
use App\Models\BonusProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'playroom_id' => 'required|exists:playrooms,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:bonus_products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.product_type' => 'required|string'
        ]);

        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        DB::beginTransaction();

        try {
            // 🧾 Crear venta
            $sale = Sale::create([
                'kid_id' => $request->kid_id,
                'playroom_id' => $request->playroom_id,
                'user_id' => $user->id,
                'total' => 0,
            ]);

            $total = 0;

            foreach ($request->items as $item) {
                $product = BonusProduct::findOrFail($item['product_id']);

                $quantity = (int) $item['quantity'];
                $lineTotal = $product->price * $quantity;

                // ➕ Línea de ticket
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'quantity' => $quantity,
                    'unit_price' => $product->price,
                    'total_price' => $lineTotal,
                ]);

                $total += $lineTotal;

                // 🎟️ CREAR SIEMPRE EL BONO
                Bonus::create([
                    'kid_id' => $sale->kid_id,
                    'bonus_product_id' => $product->id,
                    'remaining_minutes' => $product->minutes * $quantity,
                ]);
            }

            $sale->update(['total' => $total]);

            DB::commit();

            return response()->json(
                $sale->load('items'),
                201
            );
        } catch (\Throwable $e) {
            DB::rollBack();

            // 👇 MUY útil en desarrollo
            return response()->json([
                'message' => 'Error procesando la venta',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
