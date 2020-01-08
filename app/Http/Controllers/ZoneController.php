<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Zone;

class ZoneController extends Controller
{
    public function index(){
        //index
    }

    public function show(){
        $data["zone"] = Zone::all();
        return view('zone/tryshow', $data);
    }

    public function create(Request $r){
        return view('zone/trycreate');
    }

    public function store(Request $r){
        $zone = new Zone($r->all());
        $zone->save();
        return redirect()->route('zone.create');
    }

    public function edit(Request $r){
        //edit
    }

    public function update(Request $r){
        //update
    }

    public function destroy(Request $r){
        //destroy
    }

}
