<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Baseinfo;
use App\Student;
use App\Teacher;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function showProfilePage()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $user_id = auth()->user()->baseinfo_id;
        $baseinfo = Baseinfo::whereId($user->baseinfo_id)->first();
        $name_f_l = Str::substr($baseinfo->name, 0, 1);
        $fathername_f_l = Str::substr($baseinfo->fathername, 0, 1);
        if (Storage::exists($user->avatar)) {
            $url = Storage::url($user->avatar);
        } else {
            $url = null;
        }
        if ($user->hasRole('student')) {
            $student = Student::whereBaseinfo_id_for_student($user_id)->first();
            $teacher = null;
        } elseif ($user->hasRole('teacher')) {
            $teacher = Teacher::whereBaseinfo_id_for_teacher($user_id)->first();
            $student = null;
        } else {
            $student = null;
            $teacher = null;
        }
        return \Illuminate\Support\Facades\View::make('profile', [
            'user' => $user,
            'url' => $url,
            'baseinfo' => $baseinfo,
            'name_f_l' => $name_f_l,
            'fathername_f_l' => $fathername_f_l,
            'student' => $student,
            'teacher' => $teacher,
        ]);
    }
    public function updateAvatar(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $rules = array(
            'avatar' => 'image'
        );
        $customMessages = [
            'avatar.image' => "Файл повинен бути картинкою",
        ];
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules, $customMessages);
        if ($validator->fails()) {
            return Redirect::to('profile')
                ->withErrors($validator);
        } 
        if ($validator->fails()) {
            return Redirect::to('profile')
                ->withErrors($validator);
        } else {
            if (($request->file('avatar')) != '') {
                if (($user->avatar) != '') {
                    Storage::delete($user->avatar);
                }
                $filename = str_slug($user->email . 'avatar');
                $file =  $request->file('avatar');
                $path = $request->file('avatar')->storeAs('/public/images', $filename . '.' . $file->getClientOriginalExtension());
                $user->avatar = $path;
                $user->save();
            }
            return Redirect::to('profile');
        }
    }
    public function delAvatar()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if (Storage::exists($user->avatar)) {
            Storage::delete($user->avatar);
        }
        if ($user->avatar != null) {
            $user->avatar = null;
            $user->save();
        }
        return Redirect::to('profile');
    }
}
