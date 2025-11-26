<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CordinatorController extends Controller
{
    public function dashboard(){
        return view('cordinator.dashboard');
    }
}
