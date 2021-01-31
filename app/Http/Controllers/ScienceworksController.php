<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\View;
use Illuminate\Support\MessageBag;
use App\Sciencework;
use App\Student;
use App\Teacher;
use App\Baseinfo;
use App\Cathedra;
use Carbon\Carbon;
use DB;
use Illuminate\Auth\Events\Validated;
use \PDF;


use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
class ScienceworksController extends Controller
{
    public function getScienceworks($status){
        return DB::table('students')
        ->select("scienceworks.id as id", "scienceworks.topic as topic", "scienceworks.type as type", "scienceworks.presenting_date as presenting_date", "baseinfos.name as studentname", "baseinfos.surname as studentsurname", "students.specialty as specialty",  "students.degree as degree")
        ->leftJoin('baseinfos', 'students.baseinfo_id_for_student', '=', 'baseinfos.id')
        ->leftJoin('scienceworks', 'students.id', '=', 'scienceworks.student_id')
         ->where('scienceworks.status','=', $status)
         ->orderBy('scienceworks.created_at', 'desc') 
         ->paginate(6);
    }

    public function getScienceworksForStudent($id){
        return DB::table('scienceworks')
        ->select('*')
        ->where('scienceworks.student_id','=',$id)
        ->where('scienceworks.status','!=','disapproved_for_teacher')
        ->where('scienceworks.status','!=','created_by_teacher')
        ->paginate(6);
    }

    public function getScienceworksForTeacher($id){
        return DB::table('scienceworks')
        ->select('*')
        ->where('scienceworks.teacher_id','=',$id)
        ->where('scienceworks.status','!=','disapproved_for_student')
        ->where('scienceworks.status','!=','created_by_teacher')
        ->paginate(6);
    }

    public function getScienceworksForCathedraworker($cathedra_id){
        return DB::table('scienceworks')
        ->select('*')
        ->where('scienceworks.cathedra_id','=',$cathedra_id)
        ->where(function ($query) {
            $query->where('scienceworks.status', '=', 'active')
                  ->orWhere('scienceworks.status', '=', 'approved_by_teacher');
        })
        ->where(function ($query) {
            $query->whereNull('scienceworks.presenting_date')
                ->orWhere('scienceworks.presenting_date', '>=', Carbon::now('Europe/Kiev'));
        })
        ->paginate(6);
    }

    public function getScienceworksForReport($cathedra_id){
        return DB::table('scienceworks')
        ->select("scienceworks.*", "bit.name as name", "bit.surname as surname", "bis.name as sname", "bis.surname as ssurname","students.year as year","students.specialty_abbr as specialty_abbr","students.group as group","students.specialty as specialty", "teachers.science_degree as degree", "teachers.scientific_rank as scrank")
        ->leftJoin('students', 'scienceworks.student_id', '=', 'students.id') 
        ->leftJoin('baseinfos as bis', 'students.baseinfo_id_for_student', '=', 'bis.id')
        ->leftJoin('teachers', 'scienceworks.teacher_id', '=', 'teachers.id')
        ->leftJoin('baseinfos as bit', 'teachers.baseinfo_id_for_teacher', '=', 'bit.id')
        ->where('scienceworks.cathedra_id','=',$cathedra_id)
        ->where('scienceworks.status', '=', 'active')
        ->get();
    }

    public function getScienceworksForFiltratedReport($cathedra_id, $teacher_id){
        return DB::table('scienceworks')
        ->select("scienceworks.*", "bit.name as name", "bit.surname as surname", "bis.name as sname", "bis.surname as ssurname","students.year as year","students.specialty_abbr as specialty_abbr","students.group as group","students.specialty as specialty", "teachers.science_degree as degree", "teachers.scientific_rank as scrank")
        ->leftJoin('students', 'scienceworks.student_id', '=', 'students.id') 
        ->leftJoin('baseinfos as bis', 'students.baseinfo_id_for_student', '=', 'bis.id')
        ->leftJoin('teachers', 'scienceworks.teacher_id', '=', 'teachers.id')
        ->leftJoin('baseinfos as bit', 'teachers.baseinfo_id_for_teacher', '=', 'bit.id')
        ->where('scienceworks.cathedra_id','=',$cathedra_id)
        ->where('scienceworks.teacher_id','=',$teacher_id)
        ->where('scienceworks.status', '=', 'active')
        ->get();
    }

    public function filtratedByGroupReport($cathedra_id, $group, $year, $specialty){
        return DB::table('scienceworks')
        ->select("scienceworks.*", "bit.name as name", "students.specialty_abbr as specialty_abbr","bit.surname as surname", "bis.name as sname", "bis.surname as ssurname","students.year as year","students.group as group","students.specialty as specialty", "teachers.science_degree as degree", "teachers.scientific_rank as scrank")
        ->leftJoin('students', 'scienceworks.student_id', '=', 'students.id') 
        ->leftJoin('baseinfos as bis', 'students.baseinfo_id_for_student', '=', 'bis.id')
        ->leftJoin('teachers', 'scienceworks.teacher_id', '=', 'teachers.id')
        ->leftJoin('baseinfos as bit', 'teachers.baseinfo_id_for_teacher', '=', 'bit.id')
        ->where('scienceworks.cathedra_id','=',$cathedra_id)
        ->where('scienceworks.status', '=', 'active')
        ->where('students.specialty', '=', $specialty)
        ->where('students.group', '=', $group)
        ->where('students.year', '=', $year)
        ->get();
    }

    public function filtratedByGroupAndTeacherReport($cathedra_id, $teacher_id, $group, $year, $specialty){
        return DB::table('scienceworks')
        ->select("students.specialty_abbr as specialty_abbr","scienceworks.*", "bit.name as name", "bit.surname as surname", "bis.name as sname", "bis.surname as ssurname","students.year as year","students.group as group","students.specialty as specialty", "teachers.science_degree as degree", "teachers.scientific_rank as scrank")
        ->leftJoin('students', 'scienceworks.student_id', '=', 'students.id') 
        ->leftJoin('baseinfos as bis', 'students.baseinfo_id_for_student', '=', 'bis.id')
        ->leftJoin('teachers', 'scienceworks.teacher_id', '=', 'teachers.id')
        ->leftJoin('baseinfos as bit', 'teachers.baseinfo_id_for_teacher', '=', 'bit.id')
        ->where('scienceworks.cathedra_id','=',$cathedra_id)
        ->where('scienceworks.status', '=', 'active')
        ->where('students.specialty', '=', $specialty)
        ->where('students.group', '=', $group)
        ->where('scienceworks.teacher_id','=',$teacher_id)
        ->where('students.year', '=', $year)
        ->get();
    }

    public function showForStudent(){
        $role = auth()->user()->roles->first()->name;
        $student_id = Student::whereBaseinfo_id_for_student(auth()->user()->baseinfo_id)->first()->id;
        $sws = $this -> getScienceworksForStudent($student_id);
        return View::make('scienceworks.showForStudent', [
            'sws' => $sws,
            'role' => $role,
        ]);
    }

    public function showSourceTool(){
        $formerrors;
        return View::make('source_tool',[
            'formerrors' => $formerrors,
        ]);
    }
    
    
    public function showTopicsForStudent(){
        $ct = Baseinfo::whereId(auth()->user()->baseinfo_id)->first()->cathedra_id;
        $st = Student::whereBaseinfo_id_for_student(auth()->user()->baseinfo_id)->first();
         $st_degree = $st->degree;
         $st_y = $st->year;
          if($st_degree=="bachelor"){
            if($st_y==3){
                $sws =  DB::table('scienceworks')
                ->select('scienceworks.*')
                ->where('scienceworks.cathedra_id','=',$ct)
                ->where('scienceworks.status','=','created_by_teacher')
                ->where('scienceworks.type', '=', 'bachaelor coursework')
                ->paginate(6);
            }
            elseif($st_y==4){
                $sws =  DB::table('scienceworks')
                ->select('scienceworks.*')
                ->where('scienceworks.cathedra_id','=',$ct)
                ->where('scienceworks.status','=','created_by_teacher')
                ->where('scienceworks.type', '=', 'bachaelor dyploma')
                ->paginate(6);
            }  
            else{
                $sws = null;
            }   
        }
        elseif($st_degree=='master'){
            if($st_y==1){
                $sws =  DB::table('scienceworks')
                ->select('scienceworks.*')
                ->where('scienceworks.cathedra_id','=',$ct)
                ->where('scienceworks.status','=','created_by_teacher')
                ->where('scienceworks.type', '=', 'major coursework')
                ->paginate(6);
            }
            elseif($st_y==2){
                $sws =  DB::table('scienceworks')
                ->select('scienceworks.*')
                ->where('scienceworks.cathedra_id','=',$ct)
                ->where('scienceworks.status','=','created_by_teacher')
                ->where('scienceworks.type', '=', 'major dyploma')
                ->paginate(6);
            }
        }
        else{
            $sws = null;
        }
        return View::make('scienceworks.showTopicsForStudent', [
            'sws' => $sws,
        ]);
    }

    public function showForTeacher(){
        $role = auth()->user()->roles->first()->name;
        $teacher_id = Teacher::whereBaseinfo_id_for_teacher(auth()->user()->baseinfo_id)->first()->id;
        $sws = $this -> getScienceworksForTeacher($teacher_id);
        return View::make('scienceworks.showForTeacher', [
            'sws' => $sws,
            'role' => $role,
        ]);
    }

    public function showForCathedraworker(){
        $role = auth()->user()->roles->first()->name;
        $cathedra_id = Baseinfo::whereId(auth()->user()->baseinfo_id)->first()->cathedra_id;
        $sws = $this->getScienceworksForCathedraworker($cathedra_id);
        return View::make('scienceworks.showForCathedraworker', [
            'sws' => $sws,
            'role' => $role,
        ]); 
    }

    public function worksReport(Request $request){    
        $checked = false;
        $cathedra_id = Baseinfo::whereId(auth()->user()->baseinfo_id)->first()->cathedra_id;
        if($request->sciencework == null || $request->sciencework == 'all'){
            $checked = false;
            $sws = DB::table('scienceworks')
            ->select('scienceworks.*', 'students.*','baseinfos.surname as surname','baseinfos.name as name')
            ->leftJoin('students', 'scienceworks.student_id', '=', 'students.id')
            ->leftJoin('baseinfos', 'students.baseinfo_id_for_student', '=', 'baseinfos.id')
            ->where('scienceworks.cathedra_id', '=', $cathedra_id)
            ->where(function ($query) {
                $query->whereNull('students.real_grad_date')
                    ->orWhere('students.real_grad_date', '>=', Carbon::now('Europe/Kiev'));
            })
            ->where(function ($query) {
                $query->where('students.degree', '=', 'master')
                    ->orWhere(function ($query) {
                        $query->where('students.year', '=', '3')
                            ->orWhere('students.year', '=', '4');
                    });
            })
            ->get();   
            $sts = null;
        }
        else if($request->sciencework == 'without'){
            $checked = true;
             $stsM = DB::table('scienceworks')
            ->select('scienceworks.student_id')
            ->leftJoin('students', 'scienceworks.student_id', '=', 'students.id')
            ->leftJoin('baseinfos', 'students.baseinfo_id_for_student', '=', 'baseinfos.id')
            ->where('scienceworks.cathedra_id', '=', $cathedra_id)
            ->where(function ($query) {
                $query->whereNull('students.real_grad_date')
                    ->orWhere('students.real_grad_date', '>=', Carbon::now('Europe/Kiev'));
            })
            ->where(function ($query) {
                $query->where('students.degree', '=', 'master')
                    ->orWhere(function ($query) {
                        $query->where('students.year', '=', '3')
                            ->orWhere('students.year', '=', '4');
                    });
            })
            ->get();

            $data= json_decode( json_encode($stsM), true);
             $sts = DB::table('students')
            ->select("students.id as stid", "baseinfos.id", "baseinfos.name", "baseinfos.surname","students.degree", "students.year", "students.specialty", "students.group")
            ->leftJoin('baseinfos', 'students.baseinfo_id_for_student', '=', 'baseinfos.id')
            ->where('baseinfos.cathedra_id', '=', $cathedra_id)
            ->where(function ($query) {
                $query->whereNull('students.real_grad_date')
                    ->orWhere('students.real_grad_date', '>=', Carbon::now('Europe/Kiev'));
            })
            ->where(function ($query) {
                $query->where('students.degree', '=', 'master')
                    ->orWhere(function ($query) {
                        $query->where('students.year', '=', '3')
                            ->orWhere('students.year', '=', '4');
                    });
            })
            ->whereNotIn('students.id',$data)
            ->get();
            $sws = null;
        }
        return View::make('scienceworks.showForWorksReport', [
            'sws' => $sws,
            'sts' => $sts,
            'checked' => $checked,
        ]);
    }

    public function applicationReport(Request $request){
        $checked = false;
        $cathedra_id = Baseinfo::whereId(auth()->user()->baseinfo_id)->first()->cathedra_id;
        if($request->application == null || $request->application == 'all'){
            $checked = false;
            $sws = DB::table('scienceworks')
            ->select("scienceworks.*", "bit.name as name", "bit.surname as surname", "bis.name as sname", "bis.surname as ssurname","students.year as year","students.group as group","students.specialty as specialty","students.specialty_abbr as specialty_abbr" , "teachers.science_degree as degree", "teachers.scientific_rank as scrank")
            ->leftJoin('students', 'scienceworks.student_id', '=', 'students.id') 
            ->leftJoin('baseinfos as bis', 'students.baseinfo_id_for_student', '=', 'bis.id')
            ->leftJoin('teachers', 'scienceworks.teacher_id', '=', 'teachers.id')
            ->leftJoin('baseinfos as bit', 'teachers.baseinfo_id_for_teacher', '=', 'bit.id')
            ->where('scienceworks.cathedra_id','=',$cathedra_id)
            ->where('scienceworks.status', '=', 'active')
            ->get();
        }
        else if($request->application == 'without'){
            $checked = true;
            $sws = DB::table('scienceworks')
            ->select("scienceworks.*", "bit.name as name", "bit.surname as surname", "bis.name as sname", "bis.surname as ssurname","students.year as year","students.group as group","students.specialty as specialty","students.specialty_abbr as specialty_abbr" , "teachers.science_degree as degree", "teachers.scientific_rank as scrank")
            ->leftJoin('students', 'scienceworks.student_id', '=', 'students.id') 
            ->leftJoin('baseinfos as bis', 'students.baseinfo_id_for_student', '=', 'bis.id')
            ->leftJoin('teachers', 'scienceworks.teacher_id', '=', 'teachers.id')
            ->leftJoin('baseinfos as bit', 'teachers.baseinfo_id_for_teacher', '=', 'bit.id')
            ->where('scienceworks.cathedra_id','=',$cathedra_id)
            ->where('scienceworks.application','=',false)
            ->where('scienceworks.status', '=', 'active')
            ->get();
        }
        return View::make('scienceworks.showForApplicationReport', [
            'sws' => $sws,
            'checked' => $checked,
        ]);
    }

    public function report(Request $request){     
        $cathedra_id = Baseinfo::whereId(auth()->user()->baseinfo_id)->first()->cathedra_id;
        if($request->teacher_id!=null && $request->group_group == null && $request->group_year==null && $request->group_specialty==null){
            $sws = $this->getScienceworksForFiltratedReport($cathedra_id, $request->teacher_id);
        }
        elseif($request->teacher_id==null && $request->group_group!=null && $request->group_specialty!=null && $request->group_year!=null){
            $sws = $this->filtratedByGroupReport($cathedra_id,$request->group_group, $request->group_year, $request->group_specialty);
        }
        elseif($request->teacher_id!=null && $request->group_group!=null && $request->group_specialty!=null && $request->group_year!=null){
            $sws = $this->filtratedByGroupAndTeacherReport($cathedra_id,$request->teacher_id,$request->group_group, $request->group_year, $request->group_specialty);
        }
        else{
            $sws = $this->getScienceworksForReport($cathedra_id);
        } 
        return View::make('scienceworks.showForReport', [
            'sws' => $sws,
        ]); 
    }


    public function disapproveByCathedraworker(Request $request, $id){
            $role = auth()->user()->roles->first()->name;
            $sw= Sciencework::find($id);
            $st = $sw -> status;
            $rules = array(
                'comment' =>  ['required'],
                'who' => ['required']
            ); 
            $customMessages = [
                'comment.required' => "Зауваження повинно бути обов'язково вказане.",
                'who.required' => "Повинно бути вказано на кому адресувати зауваження.",
            ];
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                return redirect()->action('ScienceworksController@showForCathedraworker')
                    ->withErrors($validator);
            } else {
                $sw->comment = $request->comment;
                if($request->who=='student'){
                    $sw->status = 'disapproved_for_student';
                }
                elseif($request->who=='teacher'){
                    $sw->status = 'disapproved_for_teacher';
                }
                $sw->save();
                return redirect()->action('ScienceworksController@showForCathedraworker');
            }
    }

    public function disapproveForStudent(Request $request, $id){
        $role = auth()->user()->roles->first()->name;
        $sw= Sciencework::find($id);
        $st = $sw -> status;
        $rules = array(
            'comment' =>  ['required'],
        );
        $customMessages = [
            'comment.required' => "Зауваження повинно бути обов'язково вказане.",
        ];
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $customMessages);
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator);
        } else {
            $sw->comment = $request->comment;
            $sw->status = 'disapproved_for_student';
            $sw->save();
            return redirect()->action('ScienceworksController@showForTeacher');
        }
    }
    public function changeStatus(Request $request, $id)
    {
        $role = auth()->user()->roles->first()->name;
        $sw= Sciencework::find($id);
        $sw->application = false;
        $st = $sw -> status;
        if($st == 'approved_by_teacher'&& $role == 'teacher'){
            $sw->status = 'inactive';
            $sw->save();
            return redirect()->action('ScienceworksController@showForTeacher');
        }
        else if($st == 'inactive' && $role == 'teacher'){
            $sw->status = 'approved_by_teacher';
            $sw->save();            
            return redirect()->action('ScienceworksController@showForTeacher');
        }
        else if($st == 'approved_by_teacher'&& $role == 'cathedraworker'){
            $sw->status = 'active';
            $sw->save();
            return redirect()->action('ScienceworksController@showForCathedraworker');
        }
        else if($st == 'active'&& $role == 'cathedraworker'){
            $sw->status = 'approved_by_teacher';
            $sw->save();
            return redirect()->action('ScienceworksController@showForCathedraworker');
        }
    }

    public function delete($id)
    {
        $role = Auth::user()->roles->first()->name;
        $sciencework= Sciencework::find($id);
        $st = $sciencework->status;
        $sciencework->delete();
        if($st=='approved_by_teacher'){
            return redirect()->action('TeachersController@showApproved');
        }
        elseif($st == 'inactive' && $role == 'teacher'){
            return redirect()->action('ScienceworksController@showInactive');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function getFirstPage(){
        $auth_user = auth()->user();
        $user = Baseinfo::whereId($auth_user->baseinfo_id)->first();
        $user_name = Str::substr($user->name, 0, 1);
        $user_fathername = Str::substr($user->fathername, 0, 1);
        $student = Student::whereBaseinfo_id_for_student($auth_user->baseinfo_id)->first();
        $sciencework = Sciencework::whereStudent_id($student->id)->first();
        $cathedra = Str::lower(Cathedra::whereId($user->cathedra_id) -> first()->name);
        $teacher = Teacher::whereId($sciencework->teacher_id)->first();
        $teacher_info = Baseinfo::whereId($teacher->baseinfo_id_for_teacher)->first();
        $teacher_name = Str::substr($teacher_info->name, 0, 1);
        $teacher_fathername = Str::substr($teacher_info->fathername, 0, 1);
        $view = view('html_template_for_first_page',[
            'cathedra' => $cathedra,
            'user' => $user,
            'user_name' => $user_name,
            'sciencework' => $sciencework,
            'student' => $student,
            'teacher' => $teacher,
            'teacher_info' => $teacher_info,
            'teacher_name' => $teacher_name,
            'user_fathername' => $user_fathername,
            'teacher_fathername' => $teacher_fathername,
        ]);
        $html = mb_convert_encoding($view, 'HTML-ENTITIES', 'UTF-8');
        $html_decode = html_entity_decode($html);
        $pdf = PDF::loadHTML($html_decode);
        return $pdf->download('firstpage.pdf'); 
    }
//     public function addStudent(Request $request, MessageBag $error)
//     {
//         $rules = array(
//             'studnumber' =>  ['required', 'exists:students,studnumber'],
//             'email' => ['required', 'email','min:5','max:50'],
//             'password'=> ['required','min:8','max:50'],
//             'password_confirmation' => 'required|same:password'  
//         );
//         $customMessages = [
//             'studnumber.required' => 'Номер студенського квитка повинен бути вказаний.',
//             'studnumber.exists' => 'Номер студентського повинен відповідати раніше збереженому номеру студентського в базі.',
//             'email.required' => 'Адреса електронної пошти повинна бути обовязково вказана.',
//             'email.email' => 'Адреса електронної пошти повинна мати формат алреси електронної пошти, а не інакший.',
//             'email.min' => 'Адреса електронної пошти повинна вміщувати не менш ніж 5 символів.',
//             'email.max' => 'Адреса електронної пошти повинна вміщувати не більш ніж 50 символів.',
//             'password.required' => 'Пароль повинен бути обовязково вказаний.',
//             'password_confirmation.required' => 'Підтвердження паролю обовязкове.',
//             'password.min' => 'Пароль повинен вміщувати більш ніж 8 символів.',
//             'password.max' => 'Пароль повинен вміщувати менш ніж 50 символів.',
//             'password_confirmation.same' => 'Паролі повинні співпадати.',
//         ];
//         $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $customMessages);
//         if ($validator->fails()) {
//             return Redirect::to('/register-as-student')
//                 ->withErrors($validator);
//         } else {
//         $student = Student::whereStudnumber($request->studnumber)->first();
//         $baseinfo = Baseinfo::whereId($student->baseinfo_id_for_student)->first();
//         $checkUser = User::whereBaseinfo_id($student->baseinfo_id_for_student)->first();
//         if($checkUser==null){
//             $user = new User();
//             $user->baseinfo_id = $baseinfo->id;
//             $user->email = $request->email;
//             $user->password = Hash::make($request->password);
//             $user->save();
//             $user->assignRole('student');
//             Auth::login($user);
//             return redirect('home');
//         }
//         else{
//             $error->add('token', 'Обліковий запис для даного студенту, виявленого за номером студентського квитка, вже створений.');
//             return redirect('login')->withErrors($error);
//         }
//     }
// }



    public function sourceTool(Request $request, MessageBag $error){
        $webrules = array(
            'web-source-name' => ['required', 'min:2','max:50'],
            'web-source-authorname' => ['min:2', 'max:50'],
            'web-source-fathername' => ['min:2', 'max:50'],
            'web-source-surname' => ['min:2', 'max:50'],
            // 'web-source-link' => ['required', 'url'],

        );
        $rules = array(
            'source-surname' => ['min:2', 'max:50'],
            'source-authorname' => ['min:2', 'max:50'],
            'source-fathername' => ['min:2', 'max:50'],
            'source-name' => ['required', 'min:2','max:50'],
            'source-type' => ['required', 'min:2','max:50'],
            'source-year' => ['date'],
            'source-pages' => ['min:1','max:15'],
        );
        $webCustomMessages = [
            'web-source-name.required' => 'Назва роботи повинна бути вказана',
            'web-source-name.min' => 'Назва роботи повинна вміщувати не менш ніж 2 символи',
            'web-source-name.max' => 'Назва роботи повинна вміщувати не більш ніж 50 символів',
            'web-source-authorname.min' => "Ім'я автора повинно вміщувати не менш ніж 2 символи",
            'web-source-authorname.max' => "Ім'я автора повинно вміщувати не більш ніж 50 символів",
            'web-source-fathername.min' => 'По батькові автора повинно вміщувати не менш ніж 2 символи',
            'web-source-fathername.max' => 'По батькові автора повинно вміщувати не більш ніж 50 символів',
            'web-source-surname.min' => 'Прізвище автора повинно вміщувати не менш ніж 3 символи',
            'web-source-surname.max' => 'Прізвище автора повинно вміщувати не більш ніж 50 символів',
            // 'web-source-link.required' => 'Посилання на ресурс повинно бути вказане',
            // 'web-source-link.url' => 'Посилання не ресурс повинно мати ознаки посилання',
        ];
        $customMessages = [
            'source-surname.min' => 'Прізвище автора повинно вміщувати не менш ніж 2 символи',
            'source-surname.max' => 'Прізвище автора повинно вміщувати не більш ніж 50 символів',
            'source-authorname.min' => "Ім'я автора повинно вміщувати не менш ніж 2 символи",
            'source-authorname.max' => "Ім'я автора повинно вміщувати не більш ніж 50 символів",
            'source-fathername.min' => 'По батькові автора повинно вміщувати не менш ніж 2 символи',
            'source-fathername.max' => 'По батькові автора повинно вміщувати не більш ніж 50 символів',
            'source-name.required' => 'Назва роботи повинна бути вказана',
            'source-name.min' => 'Назва роботи повинна вміщувати не менш ніж 2 символи',
            'source-name.max' => 'Назва роботи повинна вміщувати не більш ніж 50 символів',
            'source-type.required' => 'Тип роботи повинен бути вказаний',
            'source-type.min' => 'Тип роботи повинен вміщувати не менш ніж 2 символи',
            'source-type.max' => 'Тип роботи повинен вміщувати не більш ніж 50 символів',
            'source-year.date' => "Поле 'рік' повинно бути заповнене коректно",
            'source-pages.min' => "Поле 'сторінки' повинно мати не менш ніж 2 символи",
            'source-pages.max' => "Поле 'сторінки' повинно мати не більш ніж 50 символів",
        ];
            if($request->select_source_type =='web-source'){
                $webValidator = \Illuminate\Support\Facades\Validator::make($request->all(), $webrules, $webCustomMessages);
                if ($webValidator->fails()) {
                //     $formerrors = $webValidator->errors()->all();
                //     return Redirect::to('/student/source-tool/')
                //          ->with($formerrors);
                // } else {
                //     return "everything is good for web source";
                // }
            }
            else{
                $otherValidator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $customMessages);
                if ($otherValidator->fails()) {
                //     return Redirect::to('/student/source-tool/')
                //          ->withErrors($otherValidator);
                // } else {
                //     return "everything is good for other sources";
                // }
            }
    }
  
}
