<?php

namespace App\Http\Controllers;

use App\Models\BonusProduct;

class BonusProductController extends Controller
{
    /**
     * Bonos disponibles de una ludoteca
     */
    public function index($playroomId)
    {
        return BonusProduct::where('playroom_id', $playroomId)
            ->where('active', true)
            ->orderBy('minutes')
            ->get();
    }
}
