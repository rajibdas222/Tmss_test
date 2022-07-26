<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{

    public function index(){
        //$id = Auth::user()->id;
        $data = Result::with(['student'])->get();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $data = $request->only(['date','gpa','student_id']);
        $data['user_id'] = auth()->id();
        Result::create($data);
        return response()->json(['success' => true, 'message' => 'Result Successfully created.']);
    }

    public function show(int $id){
        $result = Result::where('id', $id)->where('user_id', auth()->id())->first();
        if($result)
            return $result;
        return response()->json(['success' => false, 'message' => 'Result is not found.'], 412);
    }

    public function update(Request $request, int $id)
    {
        $result = Result::where('id', $id)->where('user_id', auth()->id())->first();
        if($result === null)
            return response()->json(['success' => false, 'message' => 'Result is not found.'], 412);

        $data = $request->only(['date','gpa','student_id']);
        $result->update($data);
        return response()->json(['success' => true, 'message' => 'Result Successfully updated.']);
    }

    public function destroy(int $id){
        $result = Result::where('id', $id)->where('user_id', auth()->id())->first();
        if($result === null)
            return response()->json(['success' => false, 'message' => 'Result is not found.'], 412);

        $result->delete();
        return response()->json(['success' => true, 'message' => 'Result Successfully deleted.']);
    }

    public function getStudents(){
        $data = Student::all();
        return $data;
    }


    public function searchResult(Request $request){

        $search = $request->get('search');
        $result = Result::where('name','LIKE','%'.$search.'%')
            ->orWhere('gpa','LIKE','%'.$search.'%')
            ->get();

        return response()->json($result);
    }

    public function resultSearch(Request $request){
        $search = $request->get('search');


    }





}
