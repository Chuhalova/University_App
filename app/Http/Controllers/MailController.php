<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class MailController extends Controller
{
    public function appSendLetters() {
       $users = DB::table('scienceworks')
        ->select('users.*')
        ->leftJoin('students', 'scienceworks.student_id', '=', 'students.id')
        ->leftJoin('users', 'students.baseinfo_id_for_student', '=', 'users.baseinfo_id')
        ->where('scienceworks.application','=',false)
        ->get();
        $users = json_decode($users, true);

        if (!empty($users)) {
            foreach ($users as $user) {
                Mail::send('mail', ['user' => $user],
                    function ($message) use ($user) {
                        $message->subject('Інформація по твоїй курсовій/дипломній роботі');
                        $message->to($user['email']);
                        $message->from('judith2019johnson@gmail.com','KNU Scienceworks app');
                    });
            }
        }
    }
}
