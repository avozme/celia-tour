<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Option;

class OptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function edit()
    {
        $options = Option::all();
        return view('admin.options', array('options' => $options));
    }

    public function update(Request $r)
    {
        $ops = Option::all();
        $i=0;
        foreach ($ops as $op) {
        	$op->value = $r->option[$i];
        	$i++;
        	$op->save();
        }
        return redirect()->route('options.edit');
    }
}
