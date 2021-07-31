<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        if (Session()->get('session_id') != null) {
            return view('welcome')->with([
                'pageTitle' => 'Dashboard', 
                'title' => 'Dashboard', 
                'sidebar' => 'dashboard'
            ]);
        } else {
            return view('login');
        }
    }
}
