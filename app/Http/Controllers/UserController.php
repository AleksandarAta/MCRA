<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Adress;
use App\Models\Biography;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $userEmail)
    {
        $user = User::where('email', $userEmail)->first();

        $user->load('adress', 'biography');
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function info()
    {
        return view('profile.additionalInformation');
    }
    public function addInfo(Request $request)
    {

        $request->validate([
            'city' => 'required|string',
            'country' => 'required|string',
            'street' => 'required|string',
            'postal_code' => 'required|integer|min:4',
            'title' => 'required|string',
            'biography' => 'required|string',
            'user_id' => "unique:biographies,user_id",
        ]);
        Adress::create([
            'country' => $request->country,
            'city' => $request->city,
            'street' => $request->street,
            'postal_code' => $request->postal_code,
            'user_id' => $request->user_id,
        ]);
        Biography::create([
            'title' => $request->title,
            'biography' => $request->biography,
            'user_id' => $request->user_id,

        ]);





        return redirect()->route('dashboard');
    }
}
