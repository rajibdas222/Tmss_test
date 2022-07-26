<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class DepartmentController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }


    public function index(){
        return Department::all();
    }

    public function store(Request $request)
    {
        $data = $request->only(['name']);
        $data['user_id'] = auth()->id();
        Department::create($data);
        return response()->json(['success' => true, 'message' => 'Department Successfully created.']);
    }

    public function show(Department $departments ,$department){

        $department = Department::where('id', $department)->where('user_id', auth()->id())->first();
        if($department)
            return $department;
        return response()->json(['success' => false, 'message' => 'Department is not found.'], 412);
    }

    public function update(Request $request, Department $departments ,$department)
    {
        $department = Department::where('id', $department)->where('user_id', auth()->id())->first();
        if($department === null)
            return response()->json(['success' => false, 'message' => 'Department is not found.'], 412);

        $data = $request->only(['name']);
        $department->update($data);
        return response()->json(['success' => true, 'message' => 'Department Successfully updated.']);
    }

    public function destroy(Department $departments ,$department)
    {
        $department = Department::where('id', $department)->where('user_id', auth()->id())->first();
        if($department === null)
            return response()->json(['success' => false, 'message' => 'Department is not found.'], 412);

        $department->delete();
        return response()->json(['success' => true, 'message' => 'Department Successfully deleted.']);
    }
}
