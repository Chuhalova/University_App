<?php

namespace App\Http\Controllers;
use App\Baseinfo;
use App\Cathedra;
use Carbon\Carbon;
use DB;
use Redirect;
use \Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = auth()->user()->baseinfo_id;
        $person = Baseinfo::whereId($user_id)->first();
        return View::make('home', [
            'person' => $person,
        ]);
    }

    public function getSwsForYeaReport($start, $end,$cathedra_id, $year, $degree,$speciality){
        return DB::table('scienceworks')
        ->select("scienceworks.*", "bit.name as name", "bit.surname as surname", "bis.name as sname", "bis.surname as ssurname","students.year as year","students.specialty_abbr as specialty_abbr","students.group as group","students.specialty as specialty", "teachers.science_degree as degree", "teachers.scientific_rank as scrank")
        ->leftJoin('students', 'scienceworks.student_id', '=', 'students.id') 
        ->leftJoin('baseinfos as bis', 'students.baseinfo_id_for_student', '=', 'bis.id')
        ->leftJoin('teachers', 'scienceworks.teacher_id', '=', 'teachers.id')
        ->leftJoin('baseinfos as bit', 'teachers.baseinfo_id_for_teacher', '=', 'bit.id')
        ->where('scienceworks.cathedra_id','=',$cathedra_id)
        ->where('students.specialty','=',$speciality)
        ->where('students.year', '=', $year)
        ->where('students.degree', '=', $degree)
        ->where('scienceworks.application','=','1')
        ->where('scienceworks.status','=','active')
        ->where('scienceworks.presenting_date', '>=', $start)
        ->where('scienceworks.presenting_date', '<=', $end)
        ->get();
    }

    public function getSwsFoReport($start, $end,$cathedra_id){
        return DB::table('scienceworks')
        ->select("scienceworks.*", "bit.name as name", "bit.surname as surname", "bis.name as sname", "bis.surname as ssurname","students.year as year","students.specialty_abbr as specialty_abbr","students.group as group","students.specialty as specialty", "teachers.science_degree as degree", "teachers.scientific_rank as scrank")
        ->leftJoin('students', 'scienceworks.student_id', '=', 'students.id') 
        ->leftJoin('baseinfos as bis', 'students.baseinfo_id_for_student', '=', 'bis.id')
        ->leftJoin('teachers', 'scienceworks.teacher_id', '=', 'teachers.id')
        ->leftJoin('baseinfos as bit', 'teachers.baseinfo_id_for_teacher', '=', 'bit.id')
        ->where('scienceworks.cathedra_id','=',$cathedra_id)
        ->where('scienceworks.application','=','1')
        ->where('scienceworks.status','=','active')
        ->where('scienceworks.presenting_date', '>=', $start)
        ->where('scienceworks.presenting_date', '<=', $end)
        ->get();
    }

    public function returnYearReportView(Request $request){
        $yearnow = Carbon::now('Europe/Kiev')->year;
        $monthnow = Carbon::now('Europe/Kiev')->month;
        if($monthnow<=12 && $monthnow>=8){
            $starty = $yearnow;
            $endy = $yearnow+1;
            $start = Carbon::parse($starty . "09" . "01")->format('Y-m-d');
            $end = Carbon::parse($endy . "07" . "01")->format('Y-m-d');
        }
        else{
            $starty = $yearnow-1;
            $endy = $yearnow;
            $start = Carbon::parse($starty . "09" . "01")->format('Y-m-d');
            $end = Carbon::parse($endy . "07" . "01")->format('Y-m-d');
        } 
        $cathedra_id = Baseinfo::whereId(auth()->user()->baseinfo_id)->first()->cathedra_id;
        
        $data = DB::table('students')
        ->select('students.*')
        ->leftJoin('scienceworks', 'students.id', '=', 'scienceworks.student_id') 
        ->where('scienceworks.cathedra_id','=',$cathedra_id)
        ->where('scienceworks.status','=','active')
        ->get();
        $result=[];
        foreach ($data as $key => $value) {
            if (in_array($value->specialty, $result)){
            }
            else{
                array_push($result, $value->specialty);
            }
        }

        if($request->speciality!=null && $request->year!=null){
            if($request->year=='3'){
                $year = '3';
                $degree = 'bachelor';
            }
            elseif($request->year=='4'){
                $year = '4';
                $degree = 'bachelor';
            }
            elseif($request->year=='5'){
                $year = '1';
                $degree = 'master';
            }
            elseif($request->year=='6'){
                $year = '2';
                $degree = 'master';
            }
            $sws = $this->getSwsForYeaReport($start, $end, $cathedra_id, $year, $degree, $request->speciality);
        }
        else{
            $sws = $this->getSwsFoReport($start, $end, $cathedra_id);
        }
        if($request->input('action') =='download'){
            if($request->year!=null && $request->speciality!=null){
            $view= View::make('scienceworks.showForYeaReportCopy', [
                'sws' => $sws,
                'cathedra_id' => Cathedra::whereId($cathedra_id)->first()->name,
                'time' => Carbon::now()->toDateString(),
                'start' => $starty,
                'end' => $endy,
                'data' => $result,
                'year' => $year,
                'degree' => $degree,
                'specialty' => $request->speciality,
            ])->render();
        $file_name = strtotime(date('Y-m-d H:i:s')) . 'report.docx';
        $headers = array(
                    "Content-type"=>"application/vnd.openxmlformats-officedocument.wordprocessingml.document",
                    "Content-Disposition"=>"attachment;Filename=$file_name"
                );
       return response()->make($view, 200, $headers); 
    }
    else{
        abort(404);
    }
}
        else{

           return View::make('scienceworks.showForYeaReport', [
            'sws' => $sws,
            'data' => $result,
        ]);
        }  
    }
}
