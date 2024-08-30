<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use mysql_xdevapi\Exception;
use Illuminate\Validation\Validator;
use App\Http\Requests\DoctorAddUpdateRequest;
//use Illuminate\Http\Request;
use App\Models\Doctor;
//use Illuminate\Http\RedirectResponse;


class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index() {
        $doctors = Doctor::with('subjects')->Paginate(10);

        return view('doctor.index',compact('doctors'));
    }


    public function create()
    {
        //$classrooms = Classroom::all();
        return view('doctor.view',compact('classrooms'));
        //لح يعرض الفورم يلي لح ناخد منه البيانات
    }
    /*public function doctors($id)
    {


        $products = product::where('user_id',$id)->get();
        // $product=product::find($id);
        if($id != Auth::id()) //Auth::id() Is The Token That Came
        {
            return $this->sendError('YOU DONT HAVE RIGHTS');
        }
        return $this->sendResponse(productResources::collection($products), 'all product sent elderly user');
    }*/

    public function store(DoctorAddUpdateRequest $request): RedirectResponse
    {
        // Validate the request...
 
        try {
            // Safely perform set of DB related queries if fail rollback all.
            DB::transaction(function () use ($request){
                Doctor::insert([
                    //'teacher_num' => $this->generateTeacherNumber(),
                    'doctor_name' => $request->get('doctor_name'),
                    'doctor_email' => $request->get('doctor_email'),
                    'doctor_phone' => $request->get('doctor_phone'),
                    'doctor_password' => $request->get('doctor_password'),

                ]);
            });
        }catch (\Exception $exception){
            // Back to form with errors
            return redirect('/doctor/create')
                ->withErrors($exception->getMessage());
        }
        return redirect('/doctor')->with('success', 'A New Doctor Added Successfully.');//بعد ما خزن المعلومات بدي روح على الصفحة يلي
    }
 
        

    public function show(string $id): View
    {
        /*return view('doctor.profile', [
            'doctor' => Doctor::findOrFail($id)
        ]);*/
    }
    public function edit($id) {
        
        //$classrooms = Classroom::all();
        $doctor = Doctor::findOrFail($id);
        return view('doctor.view', compact('doctor', 'classrooms' ));
    }

    public function update(Request $request,int $id)
    {
        $doctor = Doctor::findOrFail($id);
        $this->validate($request, [
            'doctor_name' => 'required|max:30',
            'doctor_email' => 'required|email|unique:doctors,email',
            //'classroom' => ['required',Rule::exists('classrooms', 'id')],
            'doctor_phone'=> 'required|regex:/(0)[0-9]{10}/',
            'doctor_password' => 'required',
        ]);
        try {
            DB::transaction(function () use ($request, $teacher){
                
                $doctor->doctor_name = $request->doctor_name;
                $doctor->doctor_email = $request->doctor_email;
                $doctor->doctor_phone = $request->doctor_phone;
                $doctor->doctor_password = $request->doctor_password;
                $doctor->save();
            });
        }catch (\Exception $exception){
            // Back to form with errors
            return redirect('/doctor/edit/'.$id)
                ->withErrors($exception->getMessage())->withInput();
        }
        return redirect('/doctor')->with('success', 'A Teacher Updated Successfully.');
    }
 
    public function destroy($id) {
        try {
            Doctor::destroy($id);
        } catch (Exception $exception){
            echo $exception->getMessage();
        }
        return redirect('/doctor');
     }

}
