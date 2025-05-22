<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ConferenceController extends Controller
{
    public function room()
    {
        $users = User::all();
        return view('users.conference', compact("users"));
    }
    public function test()
    {
        return view('conferenceTest');
    }
}
