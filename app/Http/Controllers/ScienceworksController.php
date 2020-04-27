<?php

namespace App\Http\Controllers;
use \Illuminate\Support\Facades\View;
use App\Sciencework;
use App\Student;
use App\Teacher;
use App\Baseinfo;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        ->paginate(6);
    }

    public function getScienceworksForReport($cathedra_id){
        return DB::table('scienceworks')
        ->select("scienceworks.*", "bit.name as name", "bit.surname as surname", "bis.name as sname", "bis.surname as ssurname","students.year as year","students.group as group","students.specialty as specialty", "teachers.science_degree as degree", "teachers.scientific_rank as scrank")
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
        ->select("scienceworks.*", "bit.name as name", "bit.surname as surname", "bis.name as sname", "bis.surname as ssurname","students.year as year","students.group as group","students.specialty as specialty", "teachers.science_degree as degree", "teachers.scientific_rank as scrank")
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
        ->select("scienceworks.*", "bit.name as name", "bit.surname as surname", "bis.name as sname", "bis.surname as ssurname","students.year as year","students.group as group","students.specialty as specialty", "teachers.science_degree as degree", "teachers.scientific_rank as scrank")
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
        ->select("scienceworks.*", "bit.name as name", "bit.surname as surname", "bis.name as sname", "bis.surname as ssurname","students.year as year","students.group as group","students.specialty as specialty", "teachers.science_degree as degree", "teachers.scientific_rank as scrank")
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
    
    
    public function showTopicsForStudent(){
        $ct = Baseinfo::whereId(auth()->user()->baseinfo_id)->first()->cathedra_id;
        $st_degree = Student::whereBaseinfo_id_for_student(auth()->user()->baseinfo_id)->first()->degree;
        if($st_degree=="bachelor"){
            $sws =  DB::table('scienceworks')
            ->select('scienceworks.*')
            ->where('scienceworks.cathedra_id','=',$ct)
            ->where('scienceworks.status','=','created_by_teacher')
            ->where(function ($query) {
                $query->where('scienceworks.type', '=', 'bachaelor coursework')
                      ->orWhere('scienceworks.type', '=', 'bachaelor dyploma')
                      ;
            })
            ->paginate(6);
        }
        elseif($st_degree=='master'){
            $sws =  DB::table('scienceworks')
            ->select('scienceworks.*')
            ->where('scienceworks.cathedra_id','=',$ct)
            ->where('scienceworks.status','=','created_by_teacher')
            ->where(function ($query) {
                $query->where('scienceworks.type', '=', 'major coursework')
                      ->orWhere('scienceworks.type', '=', 'major dyploma')
                      ;
            })
            ->paginate(6);
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
            $sts = DB::table('students')
            ->select("baseinfos.id", "baseinfos.name", "baseinfos.surname", "students.degree", "students.year", "students.specialty", "students.group")
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
            ->whereNotIn('students.id',function($query){
                $query->select('student_id')->from('scienceworks');
             })
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
            ->select("scienceworks.*", "bit.name as name", "bit.surname as surname", "bis.name as sname", "bis.surname as ssurname","students.year as year","students.group as group","students.specialty as specialty", "teachers.science_degree as degree", "teachers.scientific_rank as scrank")
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
            ->select("scienceworks.*", "bit.name as name", "bit.surname as surname", "bis.name as sname", "bis.surname as ssurname","students.year as year","students.group as group","students.specialty as specialty", "teachers.science_degree as degree", "teachers.scientific_rank as scrank")
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
}
