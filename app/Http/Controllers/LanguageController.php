<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function change(Request $reuqest)
    {
        $lang = $reuqest->lang;

        if (in_array($lang, ['en', 'mk'])) {
            Session::put('locale', $lang);
        }

        return redirect()->back();
    }
}
