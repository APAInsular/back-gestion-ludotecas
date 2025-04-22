<?php

namespace App\Http\Controllers;

use App\Models\Ludoteca;
use App\Models\Playroom;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleUserLudotecaController extends Controller
{
    public function attach(Playroom $ludoteca, User $user, Role $role)
    {
        $ludoteca->users()
            ->syncWithoutDetaching([
                $user->id => ['role_id' => $role->id]
            ]);

        return response()->json([
            'message' => "Rol {$role->name} asignado a Usuario {$user->id} en Ludoteca {$ludoteca->id}"
        ], 200);
    }

    public function detach(Playroom $ludoteca, User $user, Role $role)
    {
        // quitamos solo esa combinación (user+ludoteca+rol)
        $ludoteca->users()
            ->newPivotStatement()
            ->where('user_id',$user->id)
            ->where('playroom_id',$ludoteca->id)
            ->where('role_id',$role->id)
            ->delete();

        return response()->json([
            'message' => "Rol {$role->name} retirado de Usuario {$user->id} en Ludoteca {$ludoteca->id}"
        ], 200);
    }
}
