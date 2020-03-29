<?php

namespace App\Http\Controllers;
use \Illuminate\Support\Facades\View;
use App\Sciencework;
use DB;
use Illuminate\Http\Request;

class CathedraworkersController extends Controller
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

    public function showActive()
    {
        $status = 'active';
        $sws = $this -> getScienceworks($status);
        return View::make('cathedraworker.showScienceworks', [
            'sws' => $sws,
            'status' => $status,
        ]);
    }

    public function showApproved()
    {
        $status = 'approved_by_teacher';
        $sws = $this -> getScienceworks($status);
        return View::make('cathedraworker.showScienceworks', [
            'sws' => $sws,
            'status' => $status,
        ]);
    }

    public function delete($id)
    {
        $sciencework= Sciencework::find($id);
        $st = $sciencework->status;
        $sciencework->delete();
        if($st=='active'){
            return redirect()->action('CathedraworkersController@showActive');
        }
        elseif($st=='approved_by_teacher'){
            return redirect()->action('CathedraworkersController@showApproved');
        }
    }


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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
