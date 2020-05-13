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
        $addKey->finish = $request->finish;
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
        $key = Key::find($id);
        return response()->json($key);
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
        $updateKey = Key::find($id);
        $updateKey->name = $request->name;
        $updateKey->scenes_id = $request->scenes_id;
        $updateKey->id_question = $request->id_question;
        $updateKey->finish = $request->finish;
        $updateKey->save();
        
        return response()->json($updateKey);
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
