<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function change(Request $reuqest) {
        $lang = $reuqest->lang;

        Session::put('locale' , $lang);

        dd(session());

        return redirect()->back();
    }
}
