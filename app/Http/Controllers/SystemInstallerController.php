<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SystemInstallerController extends Controller
{
	public function index(){
		\Session::remove('requirments');
	    return view('install.init');
	}
}
