<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function index(){
        return view ('dokter_index') ;
    }

    public function create()
    {
        return view('dokter_create');
    }

    public function store(){

    }

    public function show(){

    }

    public function edit(){

    }

    public function update(){

    }

    public function destroy(){
        
    }
}
