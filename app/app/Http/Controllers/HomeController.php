<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Animal;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $animal = new Animal;
        $animal->nombre = "Andrés";
        $animal->save();

        return view('home', ['animal' => $animal]);
    }
}
