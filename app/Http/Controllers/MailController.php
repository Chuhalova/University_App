<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;
use DB;
use App\Baseinfo;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class MailController extends Controller
{
    public function appSendLetters() {
       $users = DB::table('scienceworks')
        ->select('users.*')
        ->leftJoin('students', 'scienceworks.student_id', '=', 'students.id')
        ->leftJoin('users', 'students.baseinfo_id_for_student', '=', 'users.baseinfo_id')
        ->where('scienceworks.application','=',false)
        ->whereNotNull('users.email')
        ->get();
        $users = json_decode($users, true);

        if (!empty($users)) {
            foreach ($users as $user) {
                Mail::send('mail', ['user' => $user],
                    function ($message) use ($user) {
                        $message->subject('Інформація по твоїй курсовій/дипломній роботі');
                        $message->to($user['email']);
                        $message->from('knushevchenko2020@gmail.com','KNU Scienceworks app');
                });
            }
        }
        return Redirect::to('/cathedraworker/application-report');

    }

    public function worksSendLetters() {
        $cathedra_id = Baseinfo::whereId(auth()->user()->baseinfo_id)->first()->cathedra_id;
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
        $users = DB::table('students')
        ->select('users.*')
        ->leftJoin('baseinfos', 'students.baseinfo_id_for_student', '=', 'baseinfos.id')
        ->leftJoin('users', 'students.baseinfo_id_for_student', '=', 'users.baseinfo_id')
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
         ->whereNotNull('users.email')
        ->get();
         $users = json_decode($users, true);
 
         if (!empty($users)) {
             foreach ($users as $user) {
                 Mail::send('worksMail', ['user' => $user],
                     function ($message) use ($user) {
                         $message->subject('Інформація по твоїй курсовій/дипломній роботі');
                         $message->to($user['email']);
                         $message->from('knushevchenko2020@gmail.com','KNU Scienceworks app');
                     });
             }
         }
         return Redirect::to('/cathedraworker/works-report');

     }
}
