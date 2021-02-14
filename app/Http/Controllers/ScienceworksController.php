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
use App\Source;
use Carbon\Carbon;
use DB;
use Illuminate\Auth\Events\Validated;
use \PDF;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ScienceworksController extends Controller
{
    public function getScienceworks($status)
    {
        return DB::table('students')
            ->select("scienceworks.id as id", "scienceworks.topic as topic", "scienceworks.type as type", "scienceworks.presenting_date as presenting_date", "baseinfos.name as studentname", "baseinfos.surname as studentsurname", "students.specialty as specialty",  "students.degree as degree")
            ->leftJoin('baseinfos', 'students.baseinfo_id_for_student', '=', 'baseinfos.id')
            ->leftJoin('scienceworks', 'students.id', '=', 'scienceworks.student_id')
            ->where('scienceworks.status', '=', $status)
            ->orderBy('scienceworks.created_at', 'desc')
            ->paginate(6);
    }

    public function getScienceworksForStudent($id)
    {
        return DB::table('scienceworks')
            ->select('*')
            ->where('scienceworks.student_id', '=', $id)
            ->where('scienceworks.status', '!=', 'disapproved_for_teacher')
            ->where('scienceworks.status', '!=', 'created_by_teacher')
            ->paginate(6);
    }

    public function getScienceworksForTeacher($id)
    {
        return DB::table('scienceworks')
            ->select('*')
            ->where('scienceworks.teacher_id', '=', $id)
            ->where('scienceworks.status', '!=', 'disapproved_for_student')
            ->where('scienceworks.status', '!=', 'created_by_teacher')
            ->paginate(6);
    }

    public function getScienceworksForCathedraworker($cathedra_id)
    {
        return DB::table('scienceworks')
            ->select('*')
            ->where('scienceworks.cathedra_id', '=', $cathedra_id)
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

    public function getScienceworksForReport($cathedra_id)
    {
        return DB::table('scienceworks')
            ->select("scienceworks.*", "bit.name as name", "bit.surname as surname", "bis.name as sname", "bis.surname as ssurname", "students.year as year", "students.specialty_abbr as specialty_abbr", "students.group as group", "students.specialty as specialty", "teachers.science_degree as degree", "teachers.scientific_rank as scrank")
            ->leftJoin('students', 'scienceworks.student_id', '=', 'students.id')
            ->leftJoin('baseinfos as bis', 'students.baseinfo_id_for_student', '=', 'bis.id')
            ->leftJoin('teachers', 'scienceworks.teacher_id', '=', 'teachers.id')
            ->leftJoin('baseinfos as bit', 'teachers.baseinfo_id_for_teacher', '=', 'bit.id')
            ->where('scienceworks.cathedra_id', '=', $cathedra_id)
            ->where('scienceworks.status', '=', 'active')
            ->get();
    }

    public function getScienceworksForFiltratedReport($cathedra_id, $teacher_id)
    {
        return DB::table('scienceworks')
            ->select("scienceworks.*", "bit.name as name", "bit.surname as surname", "bis.name as sname", "bis.surname as ssurname", "students.year as year", "students.specialty_abbr as specialty_abbr", "students.group as group", "students.specialty as specialty", "teachers.science_degree as degree", "teachers.scientific_rank as scrank")
            ->leftJoin('students', 'scienceworks.student_id', '=', 'students.id')
            ->leftJoin('baseinfos as bis', 'students.baseinfo_id_for_student', '=', 'bis.id')
            ->leftJoin('teachers', 'scienceworks.teacher_id', '=', 'teachers.id')
            ->leftJoin('baseinfos as bit', 'teachers.baseinfo_id_for_teacher', '=', 'bit.id')
            ->where('scienceworks.cathedra_id', '=', $cathedra_id)
            ->where('scienceworks.teacher_id', '=', $teacher_id)
            ->where('scienceworks.status', '=', 'active')
            ->get();
    }

    public function filtratedByGroupReport($cathedra_id, $group, $year, $specialty)
    {
        return DB::table('scienceworks')
            ->select("scienceworks.*", "bit.name as name", "students.specialty_abbr as specialty_abbr", "bit.surname as surname", "bis.name as sname", "bis.surname as ssurname", "students.year as year", "students.group as group", "students.specialty as specialty", "teachers.science_degree as degree", "teachers.scientific_rank as scrank")
            ->leftJoin('students', 'scienceworks.student_id', '=', 'students.id')
            ->leftJoin('baseinfos as bis', 'students.baseinfo_id_for_student', '=', 'bis.id')
            ->leftJoin('teachers', 'scienceworks.teacher_id', '=', 'teachers.id')
            ->leftJoin('baseinfos as bit', 'teachers.baseinfo_id_for_teacher', '=', 'bit.id')
            ->where('scienceworks.cathedra_id', '=', $cathedra_id)
            ->where('scienceworks.status', '=', 'active')
            ->where('students.specialty', '=', $specialty)
            ->where('students.group', '=', $group)
            ->where('students.year', '=', $year)
            ->get();
    }

    public function filtratedByGroupAndTeacherReport($cathedra_id, $teacher_id, $group, $year, $specialty)
    {
        return DB::table('scienceworks')
            ->select("students.specialty_abbr as specialty_abbr", "scienceworks.*", "bit.name as name", "bit.surname as surname", "bis.name as sname", "bis.surname as ssurname", "students.year as year", "students.group as group", "students.specialty as specialty", "teachers.science_degree as degree", "teachers.scientific_rank as scrank")
            ->leftJoin('students', 'scienceworks.student_id', '=', 'students.id')
            ->leftJoin('baseinfos as bis', 'students.baseinfo_id_for_student', '=', 'bis.id')
            ->leftJoin('teachers', 'scienceworks.teacher_id', '=', 'teachers.id')
            ->leftJoin('baseinfos as bit', 'teachers.baseinfo_id_for_teacher', '=', 'bit.id')
            ->where('scienceworks.cathedra_id', '=', $cathedra_id)
            ->where('scienceworks.status', '=', 'active')
            ->where('students.specialty', '=', $specialty)
            ->where('students.group', '=', $group)
            ->where('scienceworks.teacher_id', '=', $teacher_id)
            ->where('students.year', '=', $year)
            ->get();
    }

    public function showForStudent()
    {
        $role = auth()->user()->roles->first()->name;
        $student_id = Student::whereBaseinfo_id_for_student(auth()->user()->baseinfo_id)->first()->id;
        $sws = $this->getScienceworksForStudent($student_id);
        return View::make('scienceworks.showForStudent', [
            'sws' => $sws,
            'role' => $role,
        ]);
    }

    public function showSourceTool()
    {
        $fws = Source::whereUser_id(auth()->user()->id)->orderBy('created_at', 'desc')->get()->slice(0, 5);
        //    $fwsForDel = Source::select('id')->whereUser_id(auth()->user()->id)->orderBy('created_at', 'desc')->get()->slice(5);
        //    if($fwsForDel){
        //     $fwsForDel->delete();
        //     }
        return View::make('source_tool', [
            'fws' => $fws,
        ]);
    }


    public function showTopicsForStudent()
    {
        $ct = Baseinfo::whereId(auth()->user()->baseinfo_id)->first()->cathedra_id;
        $st = Student::whereBaseinfo_id_for_student(auth()->user()->baseinfo_id)->first();
        $st_degree = $st->degree;
        $st_y = $st->year;
        if ($st_degree == "bachelor") {
            if ($st_y == 3) {
                $sws =  DB::table('scienceworks')
                    ->select('scienceworks.*')
                    ->where('scienceworks.cathedra_id', '=', $ct)
                    ->where('scienceworks.status', '=', 'created_by_teacher')
                    ->where('scienceworks.type', '=', 'bachaelor coursework')
                    ->paginate(6);
            } elseif ($st_y == 4) {
                $sws =  DB::table('scienceworks')
                    ->select('scienceworks.*')
                    ->where('scienceworks.cathedra_id', '=', $ct)
                    ->where('scienceworks.status', '=', 'created_by_teacher')
                    ->where('scienceworks.type', '=', 'bachaelor dyploma')
                    ->paginate(6);
            } else {
                $sws = null;
            }
        } elseif ($st_degree == 'master') {
            if ($st_y == 1) {
                $sws =  DB::table('scienceworks')
                    ->select('scienceworks.*')
                    ->where('scienceworks.cathedra_id', '=', $ct)
                    ->where('scienceworks.status', '=', 'created_by_teacher')
                    ->where('scienceworks.type', '=', 'major coursework')
                    ->paginate(6);
            } elseif ($st_y == 2) {
                $sws =  DB::table('scienceworks')
                    ->select('scienceworks.*')
                    ->where('scienceworks.cathedra_id', '=', $ct)
                    ->where('scienceworks.status', '=', 'created_by_teacher')
                    ->where('scienceworks.type', '=', 'major dyploma')
                    ->paginate(6);
            }
        } else {
            $sws = null;
        }
        return View::make('scienceworks.showTopicsForStudent', [
            'sws' => $sws,
        ]);
    }

    public function showForTeacher()
    {
        $role = auth()->user()->roles->first()->name;
        $teacher_id = Teacher::whereBaseinfo_id_for_teacher(auth()->user()->baseinfo_id)->first()->id;
        $sws = $this->getScienceworksForTeacher($teacher_id);
        return View::make('scienceworks.showForTeacher', [
            'sws' => $sws,
            'role' => $role,
        ]);
    }

    public function showForCathedraworker()
    {
        $role = auth()->user()->roles->first()->name;
        $cathedra_id = Baseinfo::whereId(auth()->user()->baseinfo_id)->first()->cathedra_id;
        $sws = $this->getScienceworksForCathedraworker($cathedra_id);
        return View::make('scienceworks.showForCathedraworker', [
            'sws' => $sws,
            'role' => $role,
        ]);
    }

    public function worksReport(Request $request)
    {
        $checked = false;
        $cathedra_id = Baseinfo::whereId(auth()->user()->baseinfo_id)->first()->cathedra_id;
        if ($request->sciencework == null || $request->sciencework == 'all') {
            $checked = false;
            $sws = DB::table('scienceworks')
                ->select('scienceworks.*', 'students.*', 'baseinfos.surname as surname', 'baseinfos.name as name')
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
        } else if ($request->sciencework == 'without') {
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

            $data = json_decode(json_encode($stsM), true);
            $sts = DB::table('students')
                ->select("students.id as stid", "baseinfos.id", "baseinfos.name", "baseinfos.surname", "students.degree", "students.year", "students.specialty", "students.group")
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
                ->whereNotIn('students.id', $data)
                ->get();
            $sws = null;
        }
        return View::make('scienceworks.showForWorksReport', [
            'sws' => $sws,
            'sts' => $sts,
            'checked' => $checked,
        ]);
    }

    public function applicationReport(Request $request)
    {
        $checked = false;
        $cathedra_id = Baseinfo::whereId(auth()->user()->baseinfo_id)->first()->cathedra_id;
        if ($request->application == null || $request->application == 'all') {
            $checked = false;
            $sws = DB::table('scienceworks')
                ->select("scienceworks.*", "bit.name as name", "bit.surname as surname", "bis.name as sname", "bis.surname as ssurname", "students.year as year", "students.group as group", "students.specialty as specialty", "students.specialty_abbr as specialty_abbr", "teachers.science_degree as degree", "teachers.scientific_rank as scrank")
                ->leftJoin('students', 'scienceworks.student_id', '=', 'students.id')
                ->leftJoin('baseinfos as bis', 'students.baseinfo_id_for_student', '=', 'bis.id')
                ->leftJoin('teachers', 'scienceworks.teacher_id', '=', 'teachers.id')
                ->leftJoin('baseinfos as bit', 'teachers.baseinfo_id_for_teacher', '=', 'bit.id')
                ->where('scienceworks.cathedra_id', '=', $cathedra_id)
                ->where('scienceworks.status', '=', 'active')
                ->get();
        } else if ($request->application == 'without') {
            $checked = true;
            $sws = DB::table('scienceworks')
                ->select("scienceworks.*", "bit.name as name", "bit.surname as surname", "bis.name as sname", "bis.surname as ssurname", "students.year as year", "students.group as group", "students.specialty as specialty", "students.specialty_abbr as specialty_abbr", "teachers.science_degree as degree", "teachers.scientific_rank as scrank")
                ->leftJoin('students', 'scienceworks.student_id', '=', 'students.id')
                ->leftJoin('baseinfos as bis', 'students.baseinfo_id_for_student', '=', 'bis.id')
                ->leftJoin('teachers', 'scienceworks.teacher_id', '=', 'teachers.id')
                ->leftJoin('baseinfos as bit', 'teachers.baseinfo_id_for_teacher', '=', 'bit.id')
                ->where('scienceworks.cathedra_id', '=', $cathedra_id)
                ->where('scienceworks.application', '=', false)
                ->where('scienceworks.status', '=', 'active')
                ->get();
        }
        return View::make('scienceworks.showForApplicationReport', [
            'sws' => $sws,
            'checked' => $checked,
        ]);
    }

    public function report(Request $request)
    {
        $cathedra_id = Baseinfo::whereId(auth()->user()->baseinfo_id)->first()->cathedra_id;
        if ($request->teacher_id != null && $request->group_group == null && $request->group_year == null && $request->group_specialty == null) {
            $sws = $this->getScienceworksForFiltratedReport($cathedra_id, $request->teacher_id);
        } elseif ($request->teacher_id == null && $request->group_group != null && $request->group_specialty != null && $request->group_year != null) {
            $sws = $this->filtratedByGroupReport($cathedra_id, $request->group_group, $request->group_year, $request->group_specialty);
        } elseif ($request->teacher_id != null && $request->group_group != null && $request->group_specialty != null && $request->group_year != null) {
            $sws = $this->filtratedByGroupAndTeacherReport($cathedra_id, $request->teacher_id, $request->group_group, $request->group_year, $request->group_specialty);
        } else {
            $sws = $this->getScienceworksForReport($cathedra_id);
        }
        return View::make('scienceworks.showForReport', [
            'sws' => $sws,
        ]);
    }


    public function disapproveByCathedraworker(Request $request, $id)
    {
        $role = auth()->user()->roles->first()->name;
        $sw = Sciencework::find($id);
        $st = $sw->status;
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
            if ($request->who == 'student') {
                $sw->status = 'disapproved_for_student';
            } elseif ($request->who == 'teacher') {
                $sw->status = 'disapproved_for_teacher';
            }
            $sw->save();
            return redirect()->action('ScienceworksController@showForCathedraworker');
        }
    }

    public function disapproveForStudent(Request $request, $id)
    {
        $role = auth()->user()->roles->first()->name;
        $sw = Sciencework::find($id);
        $st = $sw->status;
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
        $sw = Sciencework::find($id);
        $sw->application = false;
        $st = $sw->status;
        if ($st == 'approved_by_teacher' && $role == 'teacher') {
            $sw->status = 'inactive';
            $sw->save();
            return redirect()->action('ScienceworksController@showForTeacher');
        } else if ($st == 'inactive' && $role == 'teacher') {
            $sw->status = 'approved_by_teacher';
            $sw->save();
            return redirect()->action('ScienceworksController@showForTeacher');
        } else if ($st == 'approved_by_teacher' && $role == 'cathedraworker') {
            $sw->status = 'active';
            $sw->save();
            return redirect()->action('ScienceworksController@showForCathedraworker');
        } else if ($st == 'active' && $role == 'cathedraworker') {
            $sw->status = 'approved_by_teacher';
            $sw->save();
            return redirect()->action('ScienceworksController@showForCathedraworker');
        }
    }

    public function delete($id)
    {
        $role = Auth::user()->roles->first()->name;
        $sciencework = Sciencework::find($id);
        $st = $sciencework->status;
        $sciencework->delete();
        if ($st == 'approved_by_teacher') {
            return redirect()->action('TeachersController@showApproved');
        } elseif ($st == 'inactive' && $role == 'teacher') {
            return redirect()->action('ScienceworksController@showInactive');
        }
    }


    public function getFirstPage()
    {
        $auth_user = auth()->user();
        $user = Baseinfo::whereId($auth_user->baseinfo_id)->first();
        $user_name = Str::substr($user->name, 0, 1);
        $user_fathername = Str::substr($user->fathername, 0, 1);
        $student = Student::whereBaseinfo_id_for_student($auth_user->baseinfo_id)->first();
        $sciencework = Sciencework::whereStudent_id($student->id)->first();
        $cathedra = Str::lower(Cathedra::whereId($user->cathedra_id)->first()->name);
        $teacher = Teacher::whereId($sciencework->teacher_id)->first();
        $teacher_info = Baseinfo::whereId($teacher->baseinfo_id_for_teacher)->first();
        $teacher_name = Str::substr($teacher_info->name, 0, 1);
        $teacher_fathername = Str::substr($teacher_info->fathername, 0, 1);
        $view = view('html_template_for_first_page', [
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

    public function sourceTool(Request $request)
    {
        if ($request->select_source_type == 'web-source') {
            $rules = array(
                'web_source_name' => ['required', 'min:2', 'max:50'],
                'web_source_link' => ['required', 'url'],
            );
            $customMessages = [
                'web_source_name.required' => "Назва роботи повинна бути вказана",
                'web_source_name.min' => "Назва роботи повинна вміщувати не менш ніж 2 символи",
                'web_source_name.max' => "Назва роботи повинна вміщувати не більш ніж 50 символів",
                'web_source_link.required' => "Посилання на ресурс повинно бути вказане",
                'web_source_link.url' => "Посилання не ресурс повинно мати ознаки посилання",
            ];
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                return Redirect::to('/student/source-tool/')->withErrors($validator);
            } else {
                $w_s_name = $request->web_source_name;
                $w_s_surname = $request->web_source_surname;
                $w_s_link = $request->web_source_link;
                $authorname_f_l = Str::substr($request->web_source_authorname, 0, 1);
                $fathername_f_l = Str::substr($request->web_source_fathername, 0, 1);
                if ($request->web_source_authorname != null) {
                    $authorname_f_l = $authorname_f_l . ".";
                }
                if ($request->web_source_fathername != null) {
                    $fathername_f_l = $fathername_f_l . ".";
                }
                if ($request->web_source_surname == null && $request->web_source_authorname == null && $request->web_source_fathername == null) {
                    $output = "'" . $w_s_name . "' [електронний ресурс] - Режим доступу: " . $w_s_link;
                } else {
                    $output = "'" . $w_s_name . "' [електронний ресурс] / " . $authorname_f_l . " " . $fathername_f_l . " " . $w_s_surname . " - Режим доступу: " . $w_s_link;
                }
                $formatted_source = new Source();
                $formatted_source->type = $request->select_source_type;
                $formatted_source->user_id = auth()->user()->id;
                $formatted_source->formatted_source = $output;
                $formatted_source->save();
                $fws = Source::whereUser_id(auth()->user()->id)->orderBy('created_at', 'desc')->get()->slice(0, 5);
                return Redirect::to('/student/source-tool/')->with('fws', $fws);
            }
        } elseif ($request->select_source_type == 'other-sources') {
            $year = now()->year;
            $rules = array(
                'source_name' => ['required', 'min:2', 'max:50'],
                'source_type' => ['required', 'min:2', 'max:50'],
                'source_year' => ['nullable', 'digits:4', 'integer', 'min:1900', 'max:' . $year],
                'source_pages' => ['max:15'],
            );
            $customMessages = [
                'source_name.required' => "Назва роботи повинна бути вказана",
                'source_name.min' => "Назва роботи повинна вміщувати не менш ніж 2 символи",
                'source_name.max' => "Назва роботи повинна вміщувати не більш ніж 50 символів",
                'source_type.required' => "Тип роботи повинен бути вказаний",
                'source_type.min' => "Тип роботи повинен вміщувати не менш ніж 2 символи",
                'source_type.max' => "Тип роботи повинен вміщувати не більш ніж 50 символів",
                'source_year.digits' => "Поле 'Рік видання' повинно бути заповнене коректно",
                'source_year.integer' => "Поле 'Рік видання' повинно бути заповнене коректно",
                'source_year.min' => "Рік видання повинен бути з 1900",
                'source_year.max' => "Рік видання не може бути більше поточного",
                'source_pages.max' => "Поле 'сторінки' повинно мати не більш ніж 15 символів",
            ];
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                return Redirect::to('/student/source-tool/')->withErrors($validator)->withInput();
            } else {
                $s_surname = $request->source_surname;
                $s_name = $request->source_name;
                $s_year = $request->source_year;
                $s_pages = $request->source_pages;
                $s_type = $request->source_type;
                $s_authorname_f_l = Str::substr($request->source_authorname, 0, 1);
                $s_fathername_f_l = Str::substr($request->source_fathername, 0, 1);
                if ($request->source_authorname != null) {
                    $s_authorname_f_l = $s_authorname_f_l . ".";
                }
                if ($request->source_fathername != null) {
                    $s_fathername_f_l = $s_fathername_f_l . ".";
                }
                $output = $s_name . " : " . $s_type;
                if ($s_surname != null || $s_authorname_f_l != null && $s_fathername_f_l != null) {
                    $output = $s_surname . " " . $s_authorname_f_l . " " . $s_fathername_f_l . " r" . $output . " / " . $s_surname . " " . $s_authorname_f_l . " " . $s_fathername_f_l;
                }
                if ($s_year != null) {
                    $output = $output . " : " . $s_year . ".";
                }
                if ($s_pages != null) {
                    $output = $output  . " - " . $s_pages . " с.";
                }
                $formatted_source = new Source();
                $formatted_source->type = $request->select_source_type;
                $formatted_source->user_id = auth()->user()->id;
                $formatted_source->formatted_source = $output;
                $formatted_source->save();
                $fws = Source::whereUser_id(auth()->user()->id)->orderBy('created_at', 'desc')->get()->slice(0, 5);
                return Redirect::to('/student/source-tool/')->with('fws', $fws);
            }
        } else {
            $fws = Source::whereUser_id(auth()->user()->id)->orderBy('created_at', 'desc')->get()->slice(0, 5);
            return View::make('source_tool', [
                'fws' => $fws,
            ]);
        }
    }

    public function getWorkReviewingPage()
    {
        //check if work's status is active
        $student_id = Student::whereBaseinfo_id_for_student(auth()->user()->baseinfo_id)->first()->id;
        $sw = Sciencework::whereStudent_id($student_id)->first();
        if($sw!=null){
            $uploaded_work_comment = $sw->uploaded_work_comment;
            $file_exists = false;
            $file_or_note_exists = false;
            if ($sw->status == 'active') {
                //check if file exists
                if (Storage::exists($sw->uploaded_work_file)) {
                    $file_exists = true;
                }
                if(Storage::exists($sw->uploaded_work_file)||$sw->uploaded_work_file){
                    $file_or_note_exists = true;
                }
                return View::make('activework_reviewing')->with([
                    'file_exists' => $file_exists,
                    'file_or_note_exists' => $file_or_note_exists,
                    'uploaded_work_comment' => $uploaded_work_comment,
                ]);
            }
        }
        return Redirect::to('/student/show/')->with('message', 'Помилка!');
    }

    public function getReviewWorkPageForTecaher($sw){
        $sw_o = Sciencework::whereId($sw)->first();
        return View::make('work_reviewing_for_teacher')->with([
            'sw_o' => $sw_o,
        ]);
    }

    public function workUpload(Request $request)
    {
        //check if work's status is active
        $student_id = Student::whereBaseinfo_id_for_student(auth()->user()->baseinfo_id)->first()->id;
        $sw = Sciencework::whereStudent_id($student_id)->first();
        if ($sw->status != 'active') {
            return Redirect::to('/student/show/')->with('message', 'Помилка!');
        } else {
            $rules = array(
                'uploaded_work_file' => ['required', 'mimes:doc,docx,odt,pdf,rtf,tex,txt,wpd'],
            );
            $customMessages = [
                'uploaded_work_file.required' => 'Завантажте файл.',
                'uploaded_work_file.mimetypes' => "Файл повинен мати розширення, що відповідає текстовому файлу: doc,docx,odt,pdf,rtf,tex,txt,wpd.",
            ];
            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $customMessages);
            if ($validator->fails()) {
                return Redirect::to('/student/work-reviewing/')
                    ->withErrors($validator);
            } else {
                if (($request->file('uploaded_work_file')) != '') {

                    if ($sw->uploaded_work_file != '') {
                        Storage::delete($sw->uploaded_work_file);
                    }
                    $filename = str_slug(Student::whereId($sw->student_id)->first()->studnumber . 'uploaded-work-file');
                    $file =  $request->file('uploaded_work_file');
                    $path = $request->file('uploaded_work_file')->storeAs('/public/textfiles', $filename . '.' . $file->getClientOriginalExtension());
                    $sw->uploaded_work_file = $path;
                    $sw->save();
                }
                return Redirect::to('/student/show/')->with('message', 'Роботу завантажено!');
            }
        }
    }

    public function workDel()
    {
        //check if work's status is active file exists
        $student_id = Student::whereBaseinfo_id_for_student(auth()->user()->baseinfo_id)->first()->id;
        $sw = Sciencework::whereStudent_id($student_id)->first();
        if ($sw->status == 'active') {
            if (Storage::exists($sw->uploaded_work_file)) {
                Storage::delete($sw->uploaded_work_file);
            }
            if ($sw->uploaded_work_file != null) {
                $sw->uploaded_work_file = null;
                $sw->save();
            }
            return Redirect::to('/student/show/')->with('message', 'Роботу видалено!');
        } else {
            return Redirect::to('/student/show/')->with('message', 'Помилка!');
        }
    }

    public function workDownload()
    {
        //check if work's status is active file exists
        $student_id = Student::whereBaseinfo_id_for_student(auth()->user()->baseinfo_id)->first()->id;
        $sw = Sciencework::whereStudent_id($student_id)->first();
        if ($sw->status == 'active') {
            $student_id = Student::whereBaseinfo_id_for_student(auth()->user()->baseinfo_id)->first()->id;
            $sw = Sciencework::whereStudent_id($student_id)->first();
            if (Storage::exists($sw->uploaded_work_file)) {
                return Storage::download($sw->uploaded_work_file);
            }
            return Redirect::to('/student/work-reviewing/');
        } else {
            return Redirect::to('/student/show/')->with('message', 'Помилка!');
        }
    }

}
