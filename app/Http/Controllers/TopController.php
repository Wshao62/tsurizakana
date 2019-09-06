<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fish;

class TopController extends Controller
{
    public function index()
    {
        $fish = Fish::getPickup();
        return view('top', ['fish' => $fish]);
    }
}
