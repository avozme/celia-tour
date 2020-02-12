<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SecondaryScene;

class SecondarySceneController extends Controller
{
  

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $s_scene->fill($request->all());
        $s_scene->save();
        return Response::json([
            'id' => $s_scene->id,
            'name' => $s_scene->name,
            'date' => $s_scene->date
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_scene)
    {
        $s_scene = SecondaryScene::where('id_scenes', $id_scene)->get();
        //dd($s_scene);
        return Response::json([
            'id' => $s_scene->id,
            'name' => $s_scene->name,
            'date' => $s_scene->date
        ], 200);
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
        $s_scene = SecondaryScene::find($id);
        $s_scene->fill($request->all());
        if( $s_scene->save()){
            return response()->json(['status'=> true]);
        }else{
            return response()->json(['status'=> false]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $s_scene = SecondaryScene::find($id);
        $s_scene->destroy();
    }
}
