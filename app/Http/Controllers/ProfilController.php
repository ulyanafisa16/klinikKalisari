<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $data['user'] = Auth::user();
    return view('profil', $data);
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'username' => 'required|unique:users,email,' . Auth::id(),
        'password' => 'nullable',
    ]);
    $user = \App\Models\User::find(Auth::id());
    if ($request->password != null) {
        $user->password = bcrypt($request->password);
    }
    $user->name = $request->name;
    $user->email = $request->username;
    $user->save();
    flash('Profil berhasil diubah')->success();
    return back();
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
}
