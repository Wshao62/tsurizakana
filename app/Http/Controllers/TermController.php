<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TermController extends Controller
{
    public function index()
    {
        return view('term.term');
    }

    public function company()
    {
        return view('company');
    }

    public function privacy()
    {
        return view('term.privacy');
    }

    public function law()
    {
        return view('term.law');
    }
}
