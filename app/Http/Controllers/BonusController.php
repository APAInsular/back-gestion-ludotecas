<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use App\Models\Kid;
use Illuminate\Http\Request;

class BonusController extends Controller
{
    /**
     * Comprar un bono
     */
    public function store(Request $request)
    {
        $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'minutes' => 'required|integer|min:1',
        ]);

        $bonus = Bonus::create([
            'kid_id' => $request->kid_id,
            'total_minutes' => $request->minutes,
            'remaining_minutes' => $request->minutes,
        ]);

        return response()->json($bonus, 201);
    }

    /**
     * Minutos restantes de un niño
     */
    public function remaining($kidId)
    {
        return Bonus::where('kid_id', $kidId)
            ->sum('remaining_minutes');
    }
}
