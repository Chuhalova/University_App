<?php
namespace App\Http\Controllers;
use Illuminate\Support\MessageBag;

use Illuminate\Http\Request;
use App\User;
use App\Baseinfo;
use App\Student;
use App\Teacher;
use App\Cathedra;
use \Illuminate\Support\Facades\View;
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
        $cathedras = Cathedra::all();
        return View::make('auth.registerCathedraworker', [
            'cathedras' => $cathedras,
        ]);
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

public function addTeacher(Request $request, MessageBag $error)
{
    $rules = array(
        'workbooknumber' =>  ['required', 'exists:teachers,workbooknumber'],
        'email' => ['required', 'email','min:5','max:50'],
        'password'=> ['required','min:8','max:50'],
        'password_confirmation' => 'required|same:password'
    );
    $customMessages = [
        'workbooknumber.required' => 'Номер трудової книжки повинен бути обовязково вказаний.',
        'workbooknumber.exists' => 'Номер трудової книжки повинен існувати в базі.',
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
        $error->add('token', 'Обліковий запис для даного викладача, виявленого за номером трудової книжки, вже створений.');
        return redirect('login')->withErrors($error);
    }
}
}

public function addCathedraworker(Request $request)
{
    $rules = array(
        'name' =>  ['required', 'min:2','max:50'],
        'surname' =>  ['required', 'min:3','max:50'],
        'fathername' =>  ['required', 'min:3','max:50'],
        'email' => ['required', 'email','min:5','max:50'],
        'password'=> ['required','min:8','max:50'],
        'password_confirmation' => 'required|same:password'
    );
    $customMessages = [
        'email.required' => 'Адреса електронної пошти повинна бути обовязково вказана.',
        'email.email' => 'Адреса електронної пошти повинна мати формат алреси електронної пошти, а не інакший.',
        'email.min' => 'Адреса електронної пошти повинна вміщувати не менш ніж 5 символів.',
        'email.max' => 'Адреса електронної пошти повинна вміщувати не більш ніж 50 символів.',
        'name.required' => "Ім'я повинно бути обов'язково вказане.",
        'name.min' => "Ім'я повинно вміщувати не менш ніж 2 символи.",
        'name.max' => "Ім'я повинно вміщувати не більш ніж 50 символів.",
        'surname.required' => "Прізвище повинно бути обов'язково вказане.",
        'surname.min' => "Прізвище повинно вміщувати не менш ніж 3 символи.",
        'surname.max' => "Прізвище повинно вміщувати не більш ніж 50 символів.",
        'fathername.required' => "По-батькові повинно бути обов'язково вказане.",
        'fathername.min' => "По-батькові повинно вміщувати не менш ніж 3 символи.",
        'fathername.max' => "По-батькові повинно вміщувати не більш ніж 50 символів.",
        'password.required' => "Пароль повинен бути обов'язково вказаний.",
        'password.min' => "Пароль повинен вміщувати не менш ніж 8 символів.",
        'password.max' => "Пароль повинен вміщувати не більш ніж 50 символів.",
        'password_confirmation.required' => "Ви повинні повторити пароль.",
        'password_confirmation.same' => "Паролі повинні співпадати.",
    ];
    $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $customMessages);
    if ($validator->fails()) {
        return Redirect::to('/register-cathedraworker')
            ->withErrors($validator);
    } else {

    $baseinfo = new Baseinfo();
    $baseinfo->name = $request->name;
    $baseinfo->surname = $request->surname;
    $baseinfo->fathername = $request->fathername;
    $baseinfo->gender=$request->gender;
    $baseinfo->cathedra_id=$request->cathedra;
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
}

