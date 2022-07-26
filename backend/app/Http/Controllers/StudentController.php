<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        return Student::all();
    }

    public function store(Request $request)
    {
        $data = $request->only(['name','batch_name','department_id']);
        $data['user_id'] = auth()->id();
        Student::create($data);
        return response()->json(['success' => true, 'message' => 'Student Successfully created.']);
    }

    public function show(Student $students, $student){
        $student = Student::where('id', $student)->where('user_id', auth()->id())->first();
        if($student)
            return $student;
        return response()->json(['success' => false, 'message' => 'Student is not found.'], 412);
    }

    public function update(Request $request, Student $students, $student){
        $student = Student::where('id', $student)->where('user_id', auth()->id())->first();
        if($student === null)
            return response()->json(['success' => false, 'message' => 'Student is not found.'], 412);

        $data = $request->only(['name']);
        $student->update($data);
        return response()->json(['success' => true, 'message' => 'Student Successfully updated.']);
    }

    public function destroy(Student $students, $student)
    {
        $student = Student::where('id', $student)->where('user_id', auth()->id())->first();
        if($student === null)
            return response()->json(['success' => false, 'message' => 'Student is not found.'], 412);

        $student->delete();
        return response()->json(['success' => true, 'message' => 'Student Successfully deleted.']);
    }

    public function getDepartment(){
        $data = Department::all();
        return $data;
    }
}
