<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MailController extends Controller
{
    public function send() {
        $data = array('name'=>"Judith Johnson");
     
        Mail::send(['text'=>'mail'], $data, function($message) {
           $message->to('veronika.chuhalova@uvoteam.com', 'Tutorials Point')->subject
              ('Laravel Basic Testing Mail');
           $message->from('judith2019johnson@gmail.com','Judith Johnson');
        });
     }
}
