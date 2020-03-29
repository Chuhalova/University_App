<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Redirect;
use Carbon\Carbon;
use App\Sciencework;
use App\Student;
use App\Baseinfo;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;
class ScienceworkController extends Controller
{

    public function registerScienceworkAsStudent(){ 
        return view ('sciencework.registerScienceworkAsStudent');
    }

    public function autocomplete(Request $request)
    {
    if($request->ajax()) {
        $data = DB::table('teachers')
        ->select("baseinfos.id", "baseinfos.name", "baseinfos.surname", "teachers.science_degree", "teachers.scientific_rank")
        ->leftJoin('baseinfos', 'teachers.baseinfo_id_for_teacher', '=', 'baseinfos.id')
        ->leftJoin('users', 'teachers.baseinfo_id_for_teacher', '=', 'users.baseinfo_id')
        ->where('baseinfos.cathedra_id','=', 1)
        ->whereNull('teachers.end_of_work_date')
        ->where("baseinfos.surname","like","%{$request->input('query')}%")
            ->get();
            $output = ''; 
            if (count($data)>0) {
                // concatenate output to the array
                $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';
                // loop through the result array
                foreach ($data as $row){
                    // concatenate output to the array
                    $output .= '<li id='.$row->id.' class="list-group-item">'.$row->name .' '. $row->surname .' '. $row->science_degree .' '. $row->scientific_rank.'</li>';
                }
                // end of output
                $output .= '</ul>';
            }
            else {
                 // if there's no matching results according to the input
                 $output .= '<li class="list-group-item">'.'No results'.'</li>';
                }
                // return output result array
                return $output;
            }
        //     $customdata = $data->map(function ($value) use($data) {
        //         return [
        //             'id'=> $value->id,
        //             'name' => "{$value->name} {$value->surname}, {$value->science_degree}, {$value->scientific_rank}",
        //         ];
        //     });
        // return response()->json($customdata);
    }

    public function index()
    {
        //
    }

    
    public function addScienceworkAsStudent(Request $request, MessageBag $error_with_degree)
    {
        $user_id = Auth::user()->first()->baseinfo_id;
        $st = Student::whereBaseinfo_id_for_student($user_id)->first();
        $st_id = $st->id;
        $st_gr_date = $st->real_grad_date;
        $st_degree = $st -> degree;
        $ct_id = Baseinfo::whereId($user_id)->first()->cathedra_id;
        if($st_gr_date<=Carbon::now('Europe/Kiev')){
            $error_with_degree->add('token', 'Ви вже не є студентом.');
            return Redirect::to('/register-sciencework-as-student')
            ->withErrors($error_with_degree);
        }
        else{
            $today = Carbon::today()->format('Y-m-d');
            $ten_years_from_now = Carbon::today()->addYears(10)->format('Y-m-d');
            $rules = array(
                'type' =>  ['required'],
                'topic' => ['required', 'min:5'],
                'presenting_date' => ['required', 'before:' . $ten_years_from_now,'after:' . $today],
            );
            $customMessages = [
                'type.required' => "Тип роботи повинен бути обов'язково вказаним.",
                'topic.required' => "Назва роботи повинна бути обов'язково вказаною.",
                'topic.min' => 'Назва роботи повинна вміщати більш ніж 5 символів.',
                'presenting_date.required'=> "Дата захисту роботи повинна бути обов'язково вказаною.",
                'presenting_date.before'=> "Дата захисту роботи повинна бути запланованою раніше ніж через десять років.",
                'presenting_date.after'=> "Дата захисту роботи повинна бути запланованою не раніше ніж сьогодні.",
            ];
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                return Redirect::to('/register-sciencework-as-student')
                    ->withErrors($validator);
            } else {
                if($st_degree == 'bachelor'){
                    if($request->type == 'bachaelor coursework'){
                        if($this->checkForWork("bachaelor coursework")){
                            $error_with_degree->add('token', 'Ви вже створили заявку на данний тип роботи');
                            return Redirect::to('/register-sciencework-as-student')
                            ->withErrors($error_with_degree);
                        }
                        else{
                            $this->addSciencework($st_id,$ct_id, $request);
                        };
                    }
                    else if($request->type == 'bachaelor dyploma'){
                        if($this->checkForWork("bachaelor dyploma")){
                            $error_with_degree->add('token', 'Ви вже створили заявку на данний тип роботи');
                            return Redirect::to('/register-sciencework-as-student')
                            ->withErrors($error_with_degree);
                        }
                        else{
                            $this->addSciencework($st_id,$ct_id, $request);
                        };
                    }
                    else{
                        $error_with_degree->add('token', 'Недопустимий тип роботи для вашого степені');
                        return Redirect::to('/register-sciencework-as-student')
                        ->withErrors($error_with_degree);
                    }
                }
                else if($st_degree == 'master'){
                    if($request->type == 'major coursework'){
                        if($this->checkForWork("major coursework")){
                            $error_with_degree->add('token', 'Ви вже створили заявку на данний тип роботи');
                            return Redirect::to('/register-sciencework-as-student')
                            ->withErrors($error_with_degree);
                        }
                        else{
                            $this->addSciencework($st_id,$ct_id, $request);
                        };
                    }
                    else if($request->type == 'major dyploma'){
                        if($this->checkForWork("major dyploma")){
                            $error_with_degree->add('token', 'Ви вже створили заявку на данний тип роботи');
                            return Redirect::to('/register-sciencework-as-student')
                            ->withErrors($error_with_degree);
                        }
                        else{
                            $this->addSciencework($st_id,$ct_id, $request);
                        };
                    }
                    else{
                        $error_with_degree->add('token', 'Недопустимий тип роботи для вашого степені');
                        return Redirect::to('/register-sciencework-as-student')
                        ->withErrors($error_with_degree);
                    }
                }
            }   
        }
        
    }

     function checkForWork($sciencework_type){
        $user_id = Auth::user()->first()->baseinfo_id;
        $st = Student::whereBaseinfo_id_for_student($user_id)->first();
        $st_id = $st->id;
        $st_degree = $st -> degree;
        $result = [];
        $works = Sciencework::where('presenting_date', '>=', Carbon::now('Europe/Kiev'))->whereType($sciencework_type)->get();
        foreach($works as $key => $value){
            array_push( $result, $value->student_id);
        }
        if(in_array($st_id, $result))
        {
            return true; 
        }
        else{
            return false; 
       }
    }


    public function addSciencework($st_id,$ct_id,Request $request)
    {
        $sciencework = new Sciencework();
        $sciencework->topic = $request->topic;
        $sciencework->type = $request->type;
        $sciencework->presenting_date = $request->presenting_date;
        $sciencework->status = 'inactive';
        $sciencework->student_id = $st_id;
        $sciencework->teacher_id = $request->teacher_id;
        $sciencework->cathedra_id = $ct_id;
        $sciencework->save();
        return redirect('home');
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
