<?php
namespace App\Http\Controllers;
use Illuminate\Support\MessageBag;

use Illuminate\Http\Request;
use App\User;
use App\Baseinfo;
use App\Student;
use App\Teacher;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
class CustomRegisterController extends Controller
{
    public function registerAsTeacher(){
        return view ('auth.registerAsTeacher');
    }

    public function registerAsStudent(){
        return view ('auth.registerAsStudent');
    }

    public function registerCathedraworker(){
        return view ('auth.registerCathedraworker');
    }

    public function addStudent(Request $request, MessageBag $error)
    {
        $rules = array(
            'studnumber' =>  ['required', 'exists:students,studnumber'],
            'email' => ['required', 'email','min:5','max:50'],
            'password'=> ['required','min:8','max:50'],
            'password_confirmation' => 'required|same:password'  
        );
        $customMessages = [
            'studnumber.required' => 'Номер студенського квитка повинен бути вказаний.',
            'studnumber.exists' => 'Номер студентського повинен відповідати раніше збереженому номеру студентського в базі.',
            'email.required' => 'Адреса електронної пошти повинна бути обовязково вказана.',
            'email.email' => 'Адреса електронної пошти повинна мати формат алреси електронної пошти, а не інакший.',
            'email.min' => 'Адреса електронної пошти повинна вміщувати не менш ніж 5 символів.',
            'email.max' => 'Адреса електронної пошти повинна вміщувати не більш ніж 50 символів.',
            'password.required' => 'Пароль повинен бути обовязково вказаний.',
            'password_confirmation.required' => 'Підтвердження паролю обовязкове.',
            'password.min' => 'Пароль повинен вміщувати більш ніж 8 символів.',
            'password.max' => 'Пароль повинен вміщувати менш ніж 50 символів.',
            'password_confirmation.same' => 'Паролі повинні співпадати.',
        ];
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $customMessages);
        if ($validator->fails()) {
            return Redirect::to('/register-as-student')
                ->withErrors($validator);
        } else {
        $student = Student::whereStudnumber($request->studnumber)->first();
        $baseinfo = Baseinfo::whereId($student->baseinfo_id_for_student)->first();
        $checkUser = User::whereBaseinfo_id($student->baseinfo_id_for_student)->first();
        if($checkUser==null){
            $user = new User();
            $user->baseinfo_id = $baseinfo->id;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            $user->assignRole('student');
            Auth::login($user);
            return redirect('home');
        }
        else{
            $error->add('token', 'Обліковий запис для даного студенту, виявленого за номером студентського квитка, вже створений.');
            return redirect('login')->withErrors($error);
        }
    }
}

public function addTeacher(Request $request)
{
    $rules = array(
        'workbooknumber' =>  ['required', 'exists:teachers,workbooknumber']
    );
    $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        return Redirect::to('/register-as-teacher')
            ->withErrors($validator);
    } else {
    $teacher = Teacher::whereWorkbooknumber($request->workbooknumber)->first();
    $baseinfo = Baseinfo::whereId($teacher->baseinfo_id_for_teacher)->first();
    $checkTeacher = User::whereBaseinfo_id($teacher->baseinfo_id_for_teacher)->first();
    if($checkTeacher==null){
    $user = new User();
    $user->baseinfo_id = $baseinfo->id;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->save();
    $user->assignRole('teacher');
    Auth::login($user);
    return redirect('home');
    }
    else{
        return "not coll";
    }
}
}

public function addCathedraworker(Request $request)
{
    $baseinfo = new Baseinfo();
    $baseinfo->name = $request->name;
    $baseinfo->surname = $request->surname;
    $baseinfo->save();
    $user = new User();
    $user->baseinfo_id = $baseinfo->id;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->save();
    $user->assignRole('cathedraworker');
    return redirect('home');
    }
}

