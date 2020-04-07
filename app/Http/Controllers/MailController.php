<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;

class MailController extends Controller
{
    public function send(){
        Mail::send(['text'=>'mail'], ['name'=>'Web dev blog'], function($message){
            $message->to('veronika.chuhalova@uvoteam.com', 'To web dev blog')->subject('Test email');
            $message->from('chuhalovaveronika@gmail.com', 'Web dev blog');
        });
    }
}
