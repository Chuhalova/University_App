<?php

namespace App\Http\Controllers;
use App\Baseinfo;
use View;
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
}
