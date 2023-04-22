<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function index()
    {
        $users = User::orderBy('rank')->get();
        return view('ranking', compact('users'));
    }

}
