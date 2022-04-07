<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
  public function index(Request $request) {
    return view('index');
  }

  public function courses(Request $request) {
    return view('courses');
  }

  public function users(Request $request) {
    return view('users');
  }

  public function schoolYears(Request $request) {
    return view('school_years');
  }

  public function enrollment(Request $request) {
    return view('enrollment');
  }
}
