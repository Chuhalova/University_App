<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use View;
use Redirect;
use Carbon\Carbon;
use App\Sciencework;
use App\Student;
use App\Teacher;
use App\Baseinfo;
use Illuminate\Support\Collection;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;
class ScienceworkController extends Controller
{

    public function proposeTopic(){
        return view ('sciencework.postTopic');
    }

    public function registerScienceworkAsStudent(){ 
        return view ('sciencework.registerScienceworkAsStudent');
    }

    public function registerScienceworkAsCathedraworker(){ 
        return view ('sciencework.registerScienceworkAsCathedraworker');
    }

    public function autocompleteStudent(Request $request)
    {
    $ct =  Baseinfo::whereId(auth()->user()->baseinfo_id)->first()->cathedra_id;
    if($request->ajax()) {
        $data = DB::table('students')
        ->select("baseinfos.id", "baseinfos.name", "baseinfos.surname", "students.degree", "students.specialty","students.group")
        ->leftJoin('baseinfos', 'students.baseinfo_id_for_student', '=', 'baseinfos.id')
        ->leftJoin('users', 'students.baseinfo_id_for_student', '=', 'users.baseinfo_id')
        ->where('baseinfos.cathedra_id','=', $ct)
        ->where(function ($query) {
            $query->whereNull('students.real_grad_date')
                  ->orWhere('students.real_grad_date', '>=', Carbon::now('Europe/Kiev'));
        })
        ->where(function ($query) {
            $query->where('students.degree','=','master')
                  ->orWhere(function ($query) {
                    $query->where('students.year','=','3')
                          ->orWhere('students.year','=','4');
                });
        })
        ->where("baseinfos.surname","like","{$request->student}%")
            ->get();
            $output = ''; 
            if (count($data)>0) {
                $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';
                foreach ($data as $row){
                    $output .= '<li id='.$row->id.' class="student_li list-group-item">'.$row->name .' '. $row->surname .' '. $row->degree .' '. $row->specialty.' '. $row->group.'</li>';
                }
                $output .= '</ul>';
            }
            else {
                 $output .= '<li class="student_li list-group-item">'.'No results'.'</li>';
                }
                return $output;
            }
    }

    public function autocomplete(Request $request)
    {
    $ct =  Baseinfo::whereId(auth()->user()->baseinfo_id)->first()->cathedra_id;
    if($request->ajax()) {
        $data = DB::table('teachers')
        ->select("baseinfos.id", "baseinfos.name", "baseinfos.surname", "teachers.science_degree", "teachers.scientific_rank")
        ->leftJoin('baseinfos', 'teachers.baseinfo_id_for_teacher', '=', 'baseinfos.id')
        ->leftJoin('users', 'teachers.baseinfo_id_for_teacher', '=', 'users.baseinfo_id')
        ->where('baseinfos.cathedra_id','=', $ct)
        ->where(function ($query) {
            $query->whereNull('teachers.end_of_work_date')
                  ->orWhere('teachers.end_of_work_date', '>=', Carbon::now('Europe/Kiev'));
        })
        ->where("baseinfos.surname","like","{$request->teacher}%")
            ->get();
            $output = ''; 
            if (count($data)>0) {
                $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';
                foreach ($data as $row){
                    $output .= '<li id='.$row->id.' class="teacher_li list-group-item">'.$row->name .' '. $row->surname .' '. $row->science_degree .' '. $row->scientific_rank.'</li>';
                }
                $output .= '</ul>';
            }
            else {
                 $output .= '<li class="teacher_li list-group-item">'.'No results'.'</li>';
                }
                return $output;
            }
    }

    public function autocompleteGroup(Request $request){
        $ct =  Baseinfo::whereId(auth()->user()->baseinfo_id)->first()->cathedra_id;
        $data = DB::table("students")
        ->select('students.*')
        ->leftJoin('baseinfos', 'students.baseinfo_id_for_student', '=', 'baseinfos.id')
        ->leftJoin('users', 'students.baseinfo_id_for_student', '=', 'users.baseinfo_id')
        ->where('baseinfos.cathedra_id','=', $ct)
        ->where(function ($query) {
            $query->whereNull('students.real_grad_date')
                  ->orWhere('students.real_grad_date', '>=', Carbon::now('Europe/Kiev'));
        })
        ->get();
        $collection = new Collection([]);
        foreach($data as $d){
            $collection->push([
                    'name'=>implode('',array_diff_assoc(str_split(ucwords($d->specialty)),str_split(strtolower($d->specialty)))).''.$d->year.'-'.$d->group,
                    'group'=> $d->group,
                    'year'=> $d->year,
                    'specialty'=> $d->specialty
            ]);
        }
        return response()->json( $collection);
        
    }

    public function autocomplete2(Request $request)
    {
    $ct =  Baseinfo::whereId(auth()->user()->baseinfo_id)->first()->cathedra_id;
    if($request->ajax()) {
        $data = DB::table('scienceworks')
        ->select("scienceworks.*", "bit.name as name", "bit.surname as surname", "teachers.science_degree as science_degree", "teachers.scientific_rank as scientific_rank")
        ->leftJoin('teachers', 'scienceworks.teacher_id', '=', 'teachers.id')
        ->leftJoin('baseinfos as bit', 'teachers.baseinfo_id_for_teacher', '=', 'bit.id')
        ->where('scienceworks.cathedra_id','=',$ct)
        ->where("bit.surname","like","{$request->teacher}%")
        ->where('scienceworks.status', '=', 'active')
        ->get()
        ->unique('scienceworks.teacher_id');
            $output = ''; 
            if (count($data)>0) {
                $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';
                foreach ($data as $row){
                    $output .= '<li id='.$row->teacher_id.' class="teacher_li list-group-item">'.$row->name .' '. $row->surname .' '. $row->science_degree .' '. $row->scientific_rank.'</li>';
                }
                $output .= '</ul>';
            }
            else {
                 $output .= '<li class="teacher_li list-group-item">'.'No results'.'</li>';
                }
                return $output;
            }
    }


    public function editScienceworkAsStudent($id){
        $sw = Sciencework::find($id);
        if (!isset($sw)) {
            abort(402);
        } else {
            return View::make('scienceworks.editForStudent', [
                'sw' => $sw,
            ]);
        }
    }

    

    public function editScienceworkAsTeacher($id){
        $sw = Sciencework::find($id);
        if (!isset($sw)) {
            abort(402);
        } else {
            return View::make('scienceworks.editForTeacher', [
                'sw' => $sw,
            ]);
        }
    }

    public function editTopicAsTeacher($id){
        $sw = Sciencework::find($id);
        if (!isset($sw)) {
            abort(402);
        } else {
            return View::make('scienceworks.editTopicForTeacher', [
                'sw' => $sw,
            ]);
        }
    }

    public function editScienceworkAsCathedraworker($id){
        $sw = Sciencework::find($id);
        if (!isset($sw)) {
            abort(402);
        } else {
            return View::make('scienceworks.editForCathedraworker', [
                'sw' => $sw,
            ]);
        }
    }

    public function updateScienceworkAsCathedraworker($id,Request $request,MessageBag $error_with_degree){
        $sw = Sciencework::find($id);
        if (!isset($sw)) {
            abort(402);
        } else {
            $st = Student::whereId($sw->student_id)->first();
            $st_id = $st->id;
            $st_gr_date = $st->real_grad_date;
            $st_degree = $st -> degree;
            if($st_gr_date!=null && $st_gr_date<=Carbon::now('Europe/Kiev')){
                $error_with_degree->add('token', 'Студент вже випустився.');
                return Redirect::back()
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
                    return Redirect::back()
                        ->withErrors($validator);
                } else {
                    
                    if($request->type!=$sw->type){
                     if($st_degree == 'bachelor'){
                        if($request->type == 'bachaelor coursework'){
                            if($this->checkForWorkForTeacher($sw,"bachaelor coursework")){
                                $error_with_degree->add('token', 'Заявка на даний тип роботи вже створена для цього студента');
                                return Redirect::back()
                                ->withErrors($error_with_degree);
                            }
                            else{
                                $this->updateScienceworkAsCw($sw,$request);
                                return Redirect::to('/cathedraworker/show');
                            };
                        }
                        else if($request->type == 'bachaelor dyploma'){
                            if($this->checkForWorkForTeacher($sw,"bachaelor dyploma")){
                                $error_with_degree->add('token', 'Заявка на даний тип роботи вже створена для цього студента');
                                return Redirect::back()
                                ->withErrors($error_with_degree);
                            }
                            else{
                                $this->updateScienceworkAsCw($sw,$request);
                                return Redirect::to('/cathedraworker/show');
                            };
                        }
                        else{
                            $error_with_degree->add('token', 'Недопустимий тип роботи для степені студента');
                            return Redirect::back()
                                ->withErrors($error_with_degree);
                        }
                    }
                    else if($st_degree == 'master'){
                        
                        if($request->type == 'major coursework'){
                            

                            if($this->checkForWorkForTeacher($sw,"major coursework")){
                                $error_with_degree->add('token', 'Заявка на даний тип роботи вже створена для цього студента');
                                return Redirect::back()
                                ->withErrors($error_with_degree);
                            }
                            else{
                                $this->updateScienceworkAsCw($sw,$request);
                                return Redirect::to('/cathedraworker/show');
                            };
                        }
                        else if($request->type == 'major dyploma'){
                           

                            if($this->checkForWorkForTeacher($sw,"major dyploma")){
                                $error_with_degree->add('token', 'Заявка на даний тип роботи вже створена для цього студента');
                                return Redirect::back()
                                ->withErrors($error_with_degree);
                            }
                            else{
                                $this->updateScienceworkAsCw($sw,$request);
                                return Redirect::to('/cathedraworker/show');
                            };
                        }
                        else{
                            $error_with_degree->add('token', 'Недопустимий тип роботи для степені студента');
                            return Redirect::back()
                                ->withErrors($error_with_degree);
                        }
                    }
                }
                    else{
                        $this->updateScienceworkAsCw($sw,$request);
                        return Redirect::to('/cathedraworker/show');
                    }
                }
            }
        }
    }

    public function updateTopicAsTeacher($id,Request $request,MessageBag $error_with_degree){
        $sw = Sciencework::find($id);
        if (!isset($sw)) {
            abort(402);
        } else {
            $rules = array(
                'type' =>  ['required'],
                'topic' => ['required', 'min:5'],
            );
            $customMessages = [
                'type.required' => "Тип роботи повинен бути обов'язково вказаним.",
                'topic.required' => "Назва роботи повинна бути обов'язково вказаною.",
                'topic.min' => 'Назва роботи повинна вміщати більш ніж 5 символів.',
            ];
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $customMessages);
                if ($validator->fails()) {
                    return Redirect::back()
                        ->withErrors($validator);
                } else {
                    $user_id = auth()->user()->baseinfo_id;
                    $tc = Teacher::whereBaseinfo_id_for_teacher($user_id)->first();
                    $tc_end_work = $tc->end_of_work_date;
                    if(($tc_end_work!=null && $tc_end_work<=Carbon::now('Europe/Kiev'))){
                        $error_with_degree->add('token', 'Ви вже не можете змінювати роботи.');
                        return Redirect::back()
                        ->withErrors($error_with_degree);
                    }
                    else{
                        $sw->topic = $request->topic;
                        $sw->type = $request->type;
                        $sw->save();
                        return Redirect::to('/teacher/get-topics');
                    }
                }
        }
    }

    public function updateScienceworkAsTeacher($id,Request $request,MessageBag $error_with_degree){
        $sw = Sciencework::find($id);
        if (!isset($sw)) {
            abort(402);
        } else {
            $st = Student::whereId($sw->student_id)->first();
            $st_id = $st->id;
            $st_gr_date = $st->real_grad_date;
            $st_degree = $st -> degree;
            if($st_gr_date!=null && $st_gr_date<=Carbon::now('Europe/Kiev')){
                $error_with_degree->add('token', 'Студент вже випустився.');
                return Redirect::back()
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
                    return Redirect::back()
                        ->withErrors($validator);
                } else {
                    
                    if($request->type!=$sw->type){
                     if($st_degree == 'bachelor'){
                        if($request->type == 'bachaelor coursework'){
                            if($this->checkForWorkForTeacher($sw,"bachaelor coursework")){
                                $error_with_degree->add('token', 'Заявка на даний тип роботи вже створена для цього студента');
                                return Redirect::back()
                                ->withErrors($error_with_degree);
                            }
                            else{
                                $this->updateSciencework($sw,$request);
                                return Redirect::to('/teacher/show');
                            };
                        }
                        else if($request->type == 'bachaelor dyploma'){
                            if($this->checkForWorkForTeacher($sw,"bachaelor dyploma")){
                                $error_with_degree->add('token', 'Заявка на даний тип роботи вже створена для цього студента');
                                return Redirect::back()
                                ->withErrors($error_with_degree);
                            }
                            else{
                                $this->updateSciencework($sw,$request);
                                return Redirect::to('/teacher/show');
                            };
                        }
                        else{
                            $error_with_degree->add('token', 'Недопустимий тип роботи для степені студента');
                            return Redirect::back()
                                ->withErrors($error_with_degree);
                        }
                    }
                    else if($st_degree == 'master'){
                        
                        if($request->type == 'major coursework'){
                            

                            if($this->checkForWorkForTeacher($sw,"major coursework")){
                                $error_with_degree->add('token', 'Заявка на даний тип роботи вже створена для цього студента');
                                return Redirect::back()
                                ->withErrors($error_with_degree);
                            }
                            else{
                                $this->updateSciencework($sw,$request);
                                return Redirect::to('/teacher/show');
                            };
                        }
                        else if($request->type == 'major dyploma'){
                           

                            if($this->checkForWorkForTeacher($sw,"major dyploma")){
                                $error_with_degree->add('token', 'Заявка на даний тип роботи вже створена для цього студента');
                                return Redirect::back()
                                ->withErrors($error_with_degree);
                            }
                            else{
                                $this->updateSciencework($sw,$request);
                                return Redirect::to('/teacher/show');
                            };
                        }
                        else{
                            $error_with_degree->add('token', 'Недопустимий тип роботи для степені студента');
                            return Redirect::back()
                                ->withErrors($error_with_degree);
                        }
                    }
                }
                    else{
                        $this->updateSciencework($sw,$request);
                        return Redirect::to('/teacher/show');
                    }
                }
            }
        }
    }

    public function updateScienceworkAsStudent($id,Request $request,MessageBag $error_with_degree){
        $sw = Sciencework::find($id);
        if (!isset($sw)) {
            abort(402);
        } else {
            $user_id = auth()->user()->baseinfo_id;
            $st = Student::whereBaseinfo_id_for_student($user_id)->first();
            $st_id = $st->id;
            if($sw->student_id==null){
                $sw->student_id = $st_id;
            }
            $st_gr_date = $st->real_grad_date;
            $st_degree = $st -> degree;
            $ct_id = Baseinfo::whereId($user_id)->first()->cathedra_id;
            if($st_gr_date!=null && $st_gr_date<=Carbon::now('Europe/Kiev')){
                $error_with_degree->add('token', 'Ви вже не є студентом.');
                return Redirect::back()
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
                    return Redirect::back()
                        ->withErrors($validator);
                } else {                   
                    if($request->type!=$sw->type){
                     if($st_degree == 'bachelor'){
                        if($request->type == 'bachaelor coursework'){
                            if($this->checkForWork("bachaelor coursework")){
                                $error_with_degree->add('token', 'Ви вже створили заявку на данний тип роботи');
                                return Redirect::back()
                                ->withErrors($error_with_degree);
                            }
                            else{
                                $this->updateSciencework($sw,$request);
                                return Redirect::to('/student/show');
                            };
                        }
                        else if($request->type == 'bachaelor dyploma'){
                            if($this->checkForWork("bachaelor dyploma")){
                                $error_with_degree->add('token', 'Ви вже створили заявку на данний тип роботи');
                                return Redirect::back()
                                ->withErrors($error_with_degree);
                            }
                            else{
                                $this->updateSciencework($sw,$request);
                                return Redirect::to('/student/show');
                            };
                        }
                        else{
                            $error_with_degree->add('token', 'Недопустимий тип роботи для вашого степені');
                            return Redirect::back()
                                ->withErrors($error_with_degree);
                        }
                    }
                    else if($st_degree == 'master'){
                        
                        if($request->type == 'major coursework'){
                            

                            if($this->checkForWork("major coursework")){
                                $error_with_degree->add('token', 'Ви вже створили заявку на данний тип роботи');
                                return Redirect::back()
                                ->withErrors($error_with_degree);
                            }
                            else{
                                $this->updateSciencework($sw,$request);
                                return Redirect::to('/student/show');
                            };
                        }
                        else if($request->type == 'major dyploma'){
                           

                            if($this->checkForWork("major dyploma")){
                                $error_with_degree->add('token', 'Ви вже створили заявку на данний тип роботи');
                                return Redirect::back()
                                ->withErrors($error_with_degree);
                            }
                            else{
                                $this->updateSciencework($sw,$request);
                                return Redirect::to('/student/show');
                            };
                        }
                        else{
                            $error_with_degree->add('token', 'Недопустимий тип роботи для вашого степені');
                            return Redirect::back()
                                ->withErrors($error_with_degree);
                        }
                    }
                }
                    else{
                        $this->updateSciencework($sw,$request);
                        return Redirect::to('/student/show');
                    }
                }
            }
        }
    }
    
    public function updateSciencework($sw, $request){
        $sw->comment = "";
        $sw->application = false;
        $sw->status="inactive";
        $sw->topic = $request->topic;
        $sw ->type = $request ->type;
        $sw->presenting_date=$request->presenting_date;
        $sw->save();
    }

    public function updateScienceworkAsCw($sw, $request){
        $sw->comment = "";
        $sw->application = false;
        $sw->status="approved_by_teacher";
        $sw->topic = $request->topic;
        $sw ->type = $request ->type;
        $sw->presenting_date=$request->presenting_date;
        $sw->save();
    }

    public function addApplication($id){
        $sw= Sciencework::find($id);
        if(isset($sw)){
            $sw->application = true;
            $sw->save();
        }
        return Redirect::back();
    }

    public function deleteScienceworkAsStudent($id){
        $sw= Sciencework::find($id);
        if(isset($sw)){
            $sw->delete();
        }
        return Redirect::back();
    }

    public function deleteTopicAsTeacher($id){
        $sw= Sciencework::find($id);
        if(isset($sw)){
            $sw->delete();
        }
        return Redirect::back();
    }

    public function postTopic(Request $request, MessageBag $error_with_degree){
        $rules = array(
            'type' =>  ['required'],
            'topic' => ['required', 'min:5'],
        );
        $customMessages = [
            'type.required' => "Тип роботи повинен бути обов'язково вказаним.",
            'topic.required' => "Назва роботи повинна бути обов'язково вказаною.",
            'topic.min' => 'Назва роботи повинна вміщати більш ніж 5 символів.',
        ];
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                return Redirect::to('/teacher/propose')
                    ->withErrors($validator);
            } else {
                $user_id = auth()->user()->baseinfo_id;
                $tc = Teacher::whereBaseinfo_id_for_teacher($user_id)->first();
                $tc_id = $tc->id;
                $tc_end_work = $tc->end_of_work_date;
                $ct_id = Baseinfo::whereId($user_id)->first()->cathedra_id;
                if(($tc_end_work!=null && $tc_end_work<=Carbon::now('Europe/Kiev'))){
                    $error_with_degree->add('token', 'Ви вже не можете створювати роботи.');
                    return Redirect::to('/teacher/propose')
                    ->withErrors($error_with_degree);
                }
                else{
                    $sciencework = new Sciencework();
                    $sciencework->topic = $request->topic;
                    $sciencework->type = $request->type;
                    $sciencework->status = 'created_by_teacher';
                    $sciencework->teacher_id = $tc_id;
                    $sciencework->cathedra_id = $ct_id;
                    $sciencework->save();
                    return Redirect::to('/teacher/get-topics');
                }
            }
    }

    public function getTopics(){
        $tc = Teacher::whereBaseinfo_id_for_teacher(auth()->user()->baseinfo_id)->first()->id;
        $sws = DB::table('scienceworks')
        ->select('scienceworks.*')
        ->where('scienceworks.teacher_id','=',$tc)
        ->where('scienceworks.status','=','created_by_teacher')
        ->paginate(6);
        return View::make('scienceworks.showTopics', [
            'sws' => $sws,
        ]);
    }
    
    public function commonAddSciencework($request, $error, $student_id, $teacher_id, $status, $sucview, $unsucview){
        $ct = Baseinfo::whereId(auth()->user()->baseinfo_id)->first()->cathedra_id;
        $student_year = Student::whereId($student_id)->first()->year;
        $student_degree = Student::whereId($student_id)->first()->degree;
        $st_real_grad_date = Student::whereId($student_id)->first()->real_grad_date;
        $tc_end_date = Teacher::whereId($teacher_id)->first()->end_of_work_date;
                if(($st_real_grad_date!=null && $st_real_grad_date<=Carbon::now('Europe/Kiev'))&&($tc_end_date!=null && $tc_end_date<=Carbon::now('Europe/Kiev'))){
                    $error->add('token', 'Викладач та студент вже недоступні');
                    return Redirect::to($sucview)
                    ->withErrors($error);
                }
                elseif(($st_real_grad_date==null || $st_real_grad_date>=Carbon::now('Europe/Kiev'))&&($tc_end_date!=null && $tc_end_date<=Carbon::now('Europe/Kiev'))){
                    $error->add('token', 'Викладач вже недоступний');
                    return Redirect::to($sucview)
                    ->withErrors($error);
                }
                elseif(($st_real_grad_date!=null && $st_real_grad_date<=Carbon::now('Europe/Kiev'))&&($tc_end_date==null || $tc_end_date>=Carbon::now('Europe/Kiev'))){
                    $error->add('token', 'Студент вже недоступний');
                    return Redirect::to($sucview)
                    ->withErrors($error);
                }
                else{
                    if(($request->type=='bachaelor coursework' && $student_degree=='bachelor' && $student_year==3) || ($request->type=='bachaelor dyploma' && $student_degree=='bachelor' && $student_year==4) || ($request->type=='major coursework' && $student_year==1 && $student_degree=='master') || ($request->type=='major dyploma' && $student_year==2 && $student_degree=='master')){
                        if($this->commonCheckWork($student_id,$request->type)){
                            $error->add('token', 'Заявка на даний тип роботи для цього студента вже створена.');
                            return Redirect::to($sucview)
                            ->withErrors($error);
                        }
                        else{
                            $this->commonAdd($request,$student_id,$teacher_id,$status,$ct);
                            return Redirect::to($unsucview);
                        };
                    }
                    else{
                        $error->add('token', 'Студент даного курсу, даної програми не може створити данний тип роботи.');
                        return Redirect::to($sucview)
                        ->withErrors($error);
                        }                 
    }
}




    public function addScienceworkAsCathedraworker(Request $request, MessageBag $error)
    {
        $today = Carbon::today()->format('Y-m-d');
        $ten_years_from_now = Carbon::today()->addYears(10)->format('Y-m-d');
        $rules = array(
            'type' =>  ['required'],
            'topic' => ['required', 'min:5', 'max:100'],
            'presenting_date' => ['required', 'before:' . $ten_years_from_now,'after:' . $today],
            'teacher_id' =>  ['required','exists:teachers,id'],
            'student_id' => ['required','exists:students,id'],
        );
        $customMessages = [
            'student_id.required' => "Студент повинен бути обраним.",
            'student_id.exists' => "Студент повинен бути обраним з бази.",
            'teacher_id.required' => "Викладач повинен бути обраним",
            'teacher_id.exists' => "Викладач повинен бути обраним з бази",
            'type.required' => "Тип роботи повинен бути обов'язково вказаним.",
            'topic.required' => "Назва роботи повинна бути обов'язково вказаною.",
            'topic.min' => 'Назва роботи повинна вміщати більш ніж 5 символів.',
            'topic.max' => 'Назва роботи повинна вміщати не більш ніж 100 символів.',
            'presenting_date.required'=> "Дата захисту роботи повинна бути обов'язково вказаною.",
            'presenting_date.before'=> "Дата захисту роботи повинна бути запланованою раніше ніж через десять років.",
            'presenting_date.after'=> "Дата захисту роботи повинна бути запланованою не раніше ніж сьогодні.",
        ];
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                return Redirect::to('/cathedraworker/register')
                    ->withErrors($validator);
            } else {
        return $this->commonAddSciencework($request, $error, $request->student_id, $request->teacher_id, 'active', '/cathedraworker/register','/cathedraworker/show');
    }
}


    public function addScienceworkAsStudent(Request $request, MessageBag $error)
    {
        $today = Carbon::today()->format('Y-m-d');
        $ten_years_from_now = Carbon::today()->addYears(10)->format('Y-m-d');
        $rules = array(
            'type' =>  ['required'],
            'topic' => ['required', 'min:5', 'max:100'],
            'presenting_date' => ['required', 'before:' . $ten_years_from_now,'after:' . $today],
            'teacher_id' =>  ['required','exists:teachers,id'],
        );
        $customMessages = [
            'teacher_id.required' => "Викладач повинен бути обраним",
            'teacher_id.exists' => "Викладач повинен бути обраним з бази",
            'type.required' => "Тип роботи повинен бути обов'язково вказаним.",
            'topic.required' => "Назва роботи повинна бути обов'язково вказаною.",
            'topic.min' => 'Назва роботи повинна вміщати більш ніж 5 символів.',
            'topic.max' => 'Назва роботи повинна вміщати не більш ніж 100 символів.',
            'presenting_date.required'=> "Дата захисту роботи повинна бути обов'язково вказаною.",
            'presenting_date.before'=> "Дата захисту роботи повинна бути запланованою раніше ніж через десять років.",
            'presenting_date.after'=> "Дата захисту роботи повинна бути запланованою не раніше ніж сьогодні.",
        ];
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                return Redirect::to('/register-sciencework-as-student')
                    ->withErrors($validator);
            } else {
        $user_id = auth()->user()->baseinfo_id;
        $student_id = Student::whereBaseinfo_id_for_student($user_id)->first()->id;
        return $this->commonAddSciencework($request, $error, $student_id, $request->teacher_id, 'inactive', '/register-sciencework-as-student','/student/show');
    }
}

     function checkForWorkForTeacher($sw, $sciencework_type){
        $st = Student::whereBaseinfo_id_for_student($sw->student_id)->first();
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

     function checkForWork($sciencework_type){
        $user_id = auth()->user()->baseinfo_id;
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
    public function commonCheckWork($st_id, $sciencework_type){
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
    public function checkForWorkForCathedraworker($request,$sciencework_type){
        $st_degree = Student::whereId($request->student_id)->first() -> degree;
        $result = [];
        $works = Sciencework::where('presenting_date', '>=', Carbon::now('Europe/Kiev'))->whereType($sciencework_type   )->get();
        foreach($works as $key => $value){
            array_push( $result, $value->student_id);
        }
        if(in_array($request->student_id, $result))
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
    }
    public function commonAdd($request,$student_id,$teacher_id,$status,$ct){
        $sciencework = new Sciencework();
        $sciencework->topic = $request->topic;
        $sciencework->type = $request->type;
        $sciencework->presenting_date = $request->presenting_date;
        $sciencework->status = $status;
        $sciencework->student_id = $student_id;
        $sciencework->teacher_id = $teacher_id;
        $sciencework->cathedra_id = $ct;
        $sciencework->save();
    }
    public function addScienceworkCw(Request $request)
    {
        $sciencework = new Sciencework();
        $sciencework->topic = $request->topic;
        $sciencework->type = $request->type;
        $sciencework->presenting_date = $request->presenting_date;
        $sciencework->status = 'approved_by_teacher';
        $sciencework->student_id = $request->student_id;
        $sciencework->teacher_id = $request->teacher_id;
        $sciencework->cathedra_id = Baseinfo::whereId(auth()->user()->baseinfo_id)->first()->cathedra_id;
        $sciencework->save();
    }
}
