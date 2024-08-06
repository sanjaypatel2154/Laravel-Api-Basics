<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    //
    function list(){
        return Student::all();
    }

    function addStudent(Request $request){

        $rules=array(
            'name'=>'required | min:2 | max:10',
            'email'=>'email | required',
            'phone' => 'required | min:10 | max:12'
        );
        $validation = Validator::make($request->all(), $rules);

        if($validation->fails()){
            return $validation->errors();
        }else{
            $student = new Student();
            $student->name=$request->name;
            $student->email=$request->email;
            $student->phone=$request->phone;
            if($student->save()){
                return ["result" => "Student added"];
            }else{
                return ["result" => "Operation failed"];
            }
        }
       
    }

    function updateStudent(Request $request){
      //  return "Update Student";
        $student = Student::find($request->id);
        $student->name=$request->name;
        $student->email=$request->email;
        $student->phone=$request->phone;
        if($student->save()){
            return ["result" => "Student Updated"];
        }else{
            return ["result" => "Operation not updated"];
        }
    }

    function deleteStudent($id){
        $student = Student::destroy($id);
        if($student){
            return ["result" => "Student Deleted"];
        }else{
            return ["result" => "Operation not deleted"];
        }
    }

    function searchStudent($name){
       $student = Student::where('name','like',"%$name")->get();
       if($student){
        return ["result"=>$student];
       }else{
        return ["result"=>"no record found"];
       }
    }
}
