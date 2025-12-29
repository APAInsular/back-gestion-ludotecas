<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Bonus;
use App\Models\BonusUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Registrar ENTRADA
     */
    public function entry(Request $request)
    {
        $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'playroom_id' => 'required|exists:playrooms,id',
            'time' => 'nullable|date_format:H:i',
        ]);

        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $openAttendance = Attendance::where('kid_id', $request->kid_id)
            ->whereNull('exit_time')
            ->first();

        if ($openAttendance) {
            return response()->json([
                'message' => 'El niño ya tiene una entrada activa'
            ], 409);
        }

        $attendance = Attendance::create([
            'kid_id' => $request->kid_id,
            'playroom_id' => $request->playroom_id,
            'user_id' => $user->id,
            'date' => now()->toDateString(),
            'entry_time' => $request->time ?? now()->format('H:i'),
        ]);

        return response()->json($attendance, 201);
    }

    /**
     * Registrar SALIDA
     */
    public function exit(Request $request)
    {
        $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'time' => 'nullable|date_format:H:i',
        ]);

        $attendance = Attendance::where('kid_id', $request->kid_id)
            ->whereNull('exit_time')
            ->latest()
            ->first();

        if (!$attendance) {
            return response()->json(['message' => 'No active entry'], 409);
        }

        DB::beginTransaction();

        try {
            // ⏱ calcular minutos usados
            $entry = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $attendance->date->format('Y-m-d') . ' ' . $attendance->entry_time
            );

            $exit = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $attendance->date->format('Y-m-d') . ' ' .
                    ($request->time ?? now()->format('H:i:s'))
            );

            $minutesUsed = $entry->diffInMinutes($exit);
            $remainingToDiscount = $minutesUsed;
            $totalDiscounted = 0;

            // 🔄 consumir bonos FIFO
            $bonuses = Bonus::where('kid_id', $attendance->kid_id)
                ->where('remaining_minutes', '>', 0)
                ->orderBy('created_at')
                ->lockForUpdate()
                ->get();

            foreach ($bonuses as $bonus) {
                if ($remainingToDiscount <= 0) break;

                $usable = min($remainingToDiscount, $bonus->remaining_minutes);

                $bonus->decrement('remaining_minutes', $usable);

                BonusUsage::create([
                    'bonus_id' => $bonus->id,
                    'attendance_id' => $attendance->id,
                    'minutes_used' => $usable,
                ]);

                $remainingToDiscount -= $usable;
                $totalDiscounted += $usable;
            }

            // 🚪 cerrar asistencia
            $attendance->update([
                'exit_time' => $request->time ?? now()->format('H:i'),
            ]);

            DB::commit();

            return response()->json([
                'attendance' => $attendance,
                'minutes_used' => $minutesUsed,
                'minutes_discounted' => $totalDiscounted,
                'minutes_without_bonus' => max(0, $minutesUsed - $totalDiscounted),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Asistencia actual
     */
    public function current($kidId)
    {
        $attendance = Attendance::where('kid_id', $kidId)
            ->whereNull('exit_time')
            ->latest()
            ->first();

        return response()->json($attendance);
    }
}
