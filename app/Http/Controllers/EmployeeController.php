<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class EmployeeController extends Controller
{
    public function index(Request $request): EmployeeCollection
    {
        $employees = Employee::all();

        return new EmployeeCollection($employees);
    }

    public function store(EmployeeStoreRequest $request)
    {
        return DB::transaction(function () use ($request) {

            /* ───────────── 1. USER ───────────── */
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'DNI' => $request->input('DNI'),
                'firstSurname' => $request->input('firstSurname'),
                'secondSurname' => $request->input('secondSurname'),
                'password' => Hash::make($request->input('password')),
            ]);

            /* ───────────── 2. EMPLOYEE ───────────── */
            $employee = Employee::create([
                'user_id' => $user->id,
                'position' => $request->input('position'),
                'salary' => $request->input('salary'),
                'bank_account' => $request->input('bank_account'),
            ]);

            /* ───────────── 3. ADDRESS (1‑a‑1) ───────────── */
            if ($request->has('address')) {
                $user->address()->create([
                    'street' => $request->input('address.street'),
                    'municipality' => $request->input('address.municipality'),
                    'locality' => $request->input('address.locality'),
                    'zip_code' => $request->input('address.zip_code'),
                    'country' => $request->input('address.country'),
                    'province' => $request->input('address.province'),
                ]);
            }

            /* ───────────── 4. PHONES (1‑a‑N) ───────────── */
            if ($request->has('phones')) {
                $user->phones()->createMany($request->input('phones'));
            }

            /* ───────────── 5. RESPUESTA ───────────── */
            return new EmployeeResource(
                $employee->load(['user.address', 'user.phones'])
            );        });
    }

    public function show(Request $request, Employee $employee): EmployeeResource
    {
        return new EmployeeResource($employee);
    }

    public function update(EmployeeUpdateRequest $request, Employee $employee): EmployeeResource
    {
        $employee->update($request->validated());

        return new EmployeeResource($employee);
    }

    public function destroy(Request $request, Employee $employee): Response
    {
        $employee->delete();

        return response()->noContent();
    }
}
