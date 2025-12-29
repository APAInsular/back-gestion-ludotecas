<?php

namespace App\Http\Controllers;

use App\Models\Kid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Attendance;

class KidController extends Controller
{
    /**
     * GET /api/kids
     * Lista niños visibles para el usuario logueado
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Kid::query()
            ->with('dni');

        // 🔹 Filtrar por ludoteca si viene
        if ($request->has('playroom_id')) {
            $query->where('playroom_id', $request->playroom_id);
        }

        // 🔹 Filtrar por DNI si viene
        if ($request->has('dni')) {
            $query->whereHas('dni', function ($q) use ($request) {
                $q->where('dni', $request->dni);
            });
        }

        // 🔐 (Opcional) aquí puedes comprobar rol tutor/monitor
        // según tu sistema de roles + pivots

        return response()->json(
            $query->orderBy('name')->get()
        );
    }

    public function bonus($kidId)
    {
        // 1️⃣ MINUTOS COMPRADOS (DESDE VENTAS)
        $minutesPurchased = DB::table('sale_items')
            ->join('products', 'products.id', '=', 'sale_items.product_id')
            ->join('sales', 'sales.id', '=', 'sale_items.sale_id')
            ->where('sales.kid_id', $kidId)
            ->where('products.type', 'BONUS')
            ->sum(DB::raw('products.minutes * sale_items.quantity'));

        // 2️⃣ MINUTOS CONSUMIDOS (DESDE ASISTENCIAS)
        $minutesUsed = Attendance::where('kid_id', $kidId)
            ->whereNotNull('exit_time')
            ->sum('minutes_used');

        // 3️⃣ MINUTOS RESTANTES
        return response()->json(
            max(0, $minutesPurchased - $minutesUsed)
        );
    }
}
