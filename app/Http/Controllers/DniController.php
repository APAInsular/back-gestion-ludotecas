<?php

namespace App\Http\Controllers;

use App\Models\Dni;
use Illuminate\Http\Request;

class DniController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'dni' => 'required|string',
            'name' => 'required|string',
            'surname' => 'required|string',
        ]);

        $dni = Dni::firstOrCreate(
            ['dni' => $request->dni],
            $request->only('dni', 'name', 'surname', 'phone', 'email')
        );

        return response()->json($dni, 201);
    }

    public function kids($dni)
    {
        $dni = Dni::where('dni', $dni)->with('kids')->firstOrFail();
        return response()->json($dni->kids);
    }
}
