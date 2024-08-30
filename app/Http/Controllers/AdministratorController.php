<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdministratorAddUpdateRequest;
use App\Models\Classroom;
use App\Models\Administrator;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdministratorController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
       // $administrator = Administrator::with('classroom')->Paginate(10);

        return view('student.index',compact('Administrators'));
    }

    
    public function create()
    {
        //$classrooms = Classroom::all();
        return view('student.view', compact('classrooms'));
    }

    
    public function store(AdministratorAddUpdateRequest $request)
    {
        try {
            // Safely perform set of DB related queries if fail rollback all.
            DB::transaction(function () use ($request){
                Administrator::insert([
                    //'administrator_id' => $this->generateStudentNumber(),
                    'administrator_name' => $request->get('administrator_name'),
                    'administrator_email' => $request->get('parent_phone_number'),
                    'administrator_phone' => $request->get('administrator_phone'),
                    'administrator_password' => $request->get('administrator_password'),
                ]);
            });
        } catch (\Exception $exception){
            // Back to form with errors
            return redirect('/administrator/create')
                ->withErrors($exception->getMessage());
        }
        return redirect('/administrator')->with('success', 'A New Administrator Added Successfully.');
    }

   
    public function show(Administrator $administrator)
    {
        //
    }

   
    public function edit(int $id)
    {
        //$classrooms = Classroom::all();
        $administrator = Administrator::findOrFail($id);
        return view('student.view', compact('student', 'classrooms' ));
    }

   
    public function update(AdministratorAddUpdateRequest $request, int $id)
    {
        $administrator = Administrator::findOrFail($id);
        $this->validate($request, [
            'administrator_name' => 'required|max:30',
            'administrator_email' => 'required|email|unique:doctors,email',
           
            'administrator_phone'=> 'required|regex:/(0)[0-9]{10}/',
            'administrator_password' => 'required',
        ]);
        try {
            // Safely perform set of DB related queries if fail rollback all.
            DB::transaction(function () use ($request, $student){
                //$administrator->administrators_id = $request->administrators_id;
                $administrator->administrator_name = $request->administrator_name;
                $administrator->administrator_email = $request->administrator_email;
                $administrator->administrator_phone = $request->administrator_phone;
                $administrator->administrator_password = $request->administrator_password;
                $administrator->save();
            });
        } catch (\Exception $exception){
            // Back to form with errors
            return redirect('/administrator/edit/'.$id)
                ->withErrors($exception->getMessage());
        }
        return redirect('/administrator')->with('success', 'A New Student Added Successfully.');
    }

    public function destroy(int $id)
    {
        try {
            Administrator::destroy($id);
        } catch (\Exception $exception){
            echo $exception->getMessage();
        }
        return redirect('/administrator');
    }

    //Todo: Marge generateTeacherNumber with generateStudentNumber to be one generic function.
  /*  public function generateStudentNumber(): int
    {
        return (int)intege('STDN-')->append($this->getLastTCID());
    }
    function getLastTCID()
    {
        $last = Administrator::query()->orderByDesc('student_num')->first('student_num');
        if($last != null){
            $lastNum = (int)Str::of($last)->after('-');
            return sprintf("%06d", (int)$lastNum +1);
        } else
            return sprintf("%06d", 1);
    }

    */
}
