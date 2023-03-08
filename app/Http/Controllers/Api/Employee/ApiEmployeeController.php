<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApiEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sortBy = $request->query('sortBy', 'id');
        $sortAsc = $request->query('sortAsc', true);
        $perPage = $request->query('per_page', 15);
        $search = $request->query('search', '');
        $employees = Employee::with(['user'])
            ->whereHas('user',function($query) use ($search) {
                if ($search) {
                    $query->where('name', 'LIKE', '%'.$search.'%')
                        ->orWhere('email', 'LIKE', '%'.$search.'%');
                }
            })
            ->orderBy($sortBy, $sortAsc ? 'ASC' : 'DESC')
            ->paginate($perPage);
    
        return EmployeeResource::collection($employees);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users', 'email')->whereNull('deleted_at')],
           
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
 
        ]);
        $user->assignRole('Employee');

        $employee = Employee::create([
            'user_id' => $user->id
        ]);

        return response()->json( ['message' => 'Employee Create successfully'], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        $employee->load('user');
        return new EmployeeResource($employee);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($employee->user->id)->whereNull('deleted_at')],
            'profile_picture' => 'nullable|image|mimes:jpeg,png',
        ]);

        $employee->user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
        ]);
                // Return a success response
                return response()->json([
                    'message' => 'Employee updated successfully',
                ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $this->authorize('delete', $employee);

        User::find($employee->user_id)->delete();
        $employee->delete();

        return response()->json(['message' => 'Record Deleted Successfully'], 200);
    }
}
