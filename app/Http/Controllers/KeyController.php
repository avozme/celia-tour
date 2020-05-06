<?php

namespace App\Http\Controllers;
use App\Key;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KeyController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'question' => 'required',
        ]);

        $addKey = new Key();
        $addKey->name = $request->name;
        $addKey->id_question = $request->question;
        $addKey->scenes_id = $request->scenes_id;
        $addKey->save();
        
        return response()->json($addKey);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $key = Key::find($id);
        if($key->delete()){  
            return response()->json(['status'=> true]);
        }else{
            return response()->json(['status'=> false]);
        }
    }
}
