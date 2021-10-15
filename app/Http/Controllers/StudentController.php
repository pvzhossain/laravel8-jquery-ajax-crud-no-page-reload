<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        return view('students.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'course' => 'required'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $new_student = new Student();
            $new_student->name = $request->input('name');
            $new_student->email = $request->input('email');
            $new_student->phone = $request->input('phone');
            $new_student->course = $request->input('course');
            $new_student->save();
            return response()->json([
                'status' => 200,
                'success' => 'Student Created Successfull'
            ]);
        }
    }

    public function show()
    {
        $student_data = Student::all();
        return response()->json([
            'students' => $student_data
        ]);
    }

    public function edit($id)
    {
        $student_data = Student::find($id);
        if ($student_data) {
            return response()->json([
                'status' => 200,
                'student' => $student_data
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "Student Not Found !!"
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'course' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $student_data = Student::find($id);
            if ($student_data) {
                $student_data->name = $request->input('name');
                $student_data->email = $request->input('email');
                $student_data->phone = $request->input('phone');
                $student_data->course = $request->input('course');
                $student_data->save();

                return response()->json([
                    'status' => 200,
                    'success' => "Student Update Successfull"
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => "Student Not Found !!"
                ]);
            }
        }
    }

    public function delete($id)
    {
        $student = Student::find($id);
        $student->delete();
        return response()->json([
            'status' => 200,
            'message' => "Student Delete Successfull"
        ]);
    }
}
