<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;

class StudentController extends Controller
{
    function welcomeindex(){

        //fetch all data from table
        $students = Student::paginate(5);
        return view('welcome',compact('students'));
    }

    function create(){

        return view('create');
    }

    function store(Request $req){

        // form validation
        $this->validate($req,[
            // 'firstname' => 'required',
            // 'lastname' => 'required',
            // 'email' => 'required',
            // 'phone' => 'required'

            'firstname' => ['required', 'string', 'max:50'],
            'lastname' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255',  'unique:students', 'regex:/(.+)@(.+)\.(.+)/i'],
            'phone' => ['required', 'regex:/(01)[0-9]{9}/',  'unique:students'],
        ]);

        //call student model class
        $student = new Student;

        //insert Data to database
        $student->first_name = $req->firstname;
        $student->last_name = $req->lastname;
        $student->email = $req->email;
        $student->phone = $req->phone;
        $student->save();

        return redirect(route('welcomehome'))->with('successMsg','Student Data Added Succefully');
        
    }

    //data edit
    function edit($id){

        $student = Student::find($id);
        return view('edit', compact('student'));
    }

    function update(Request $req,$id){

         // form validation
         $this->validate($req,[
            // 'firstname' => 'required',
            // 'lastname' => 'required',
            // 'email' => 'required',
            // 'phone' => 'required'

            'firstname' => ['required', 'string', 'max:50'],
            'lastname' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:students', 'regex:/(.+)@(.+)\.(.+)/i'],
            'phone' => ['required', 'regex:/(01)[0-9]{9}/', 'unique:students'],
        ]);

        $student = Student::find($id);

          //update Data to database
          $student->first_name = $req->firstname;
          $student->last_name = $req->lastname;
          $student->email = $req->email;
          $student->phone = $req->phone;
          $student->save();
  
          return redirect(route('welcomehome'))->with('successMsg','Student Data Update Succefully');
    }

    function delete($id){

        try {
            
            Student::find($id)->delete();

        } catch (ModelNotFoundException $exception) {

            return back()->withError($exception->getMessage())->withInput();
        }

        return redirect(route('welcomehome'))->with('successMsg','Student Data Delete Succefully');
    }

    
}

