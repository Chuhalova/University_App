<?php

namespace App\Http\Controllers;
use \Illuminate\Support\Facades\View;
use App\Sciencework;
use App\Student;
use App\Teacher;
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
        ->paginate(6);
    }

    public function getScienceworksForTeacher($id){
        return DB::table('scienceworks')
        ->select('*')
        ->where('scienceworks.teacher_id','=',$id)
        ->where('scienceworks.status','!=','disapproved_for_student')
        ->paginate(6);
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

    public function showForTeacher(){
        $role = auth()->user()->roles->first()->name;
        $teacher_id = Teacher::whereBaseinfo_id_for_teacher(auth()->user()->baseinfo_id)->first()->id;
        $sws = $this -> getScienceworksForTeacher($teacher_id);
        return View::make('scienceworks.showForTeacher', [
            'sws' => $sws,
            'role' => $role,
        ]);
    }

    public function showInactive()
    {
        $role = Auth::user()->roles->first()->name;
        $status = 'inactive';
        $sws = $this -> getScienceworks($status);
        return View::make('scienceworks.show', [
            'sws' => $sws,
            'status' => $status,
            'role' => $role,
        ]);
    }

    public function showApproved()
    {
        $role = Auth::user()->roles->first()->name;
        $status = 'approved_by_teacher';
        $sws = $this -> getScienceworks($status);
        return View::make('scienceworks.show', [
            'sws' => $sws,
            'status' => $status,
            'role' => $role,
        ]);
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
        $st = $sw -> status;
        if($st == 'approved_by_teacher'){
            $sw->status = 'inactive';
            $sw->save();
            return redirect()->action('ScienceworksController@showForTeacher');
        }
        else if($st == 'inactive' && $role == 'teacher'){
            $sw->status = 'approved_by_teacher';
            $sw->save();            
            return redirect()->action('ScienceworksController@showForTeacher');
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
