<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Hide;
use App\HotspotType;

class HideController extends Controller
{

    public function __construct(){

        $this->middleware('auth');
    }

    public function index()
    {
        //
    }

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
    public function store(Request $r) {
        $hide = new Hide();
        $hide->width = $r->width *4;
        $hide->height = $r->height *4;
        $hide->type = $r->type;

        if($hide->save()){
            return response()->json(['status'=> true, 'hideId'=>$hide->id]);
        }else{
            return response()->json(['status'=> false]);
        }

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
        $hide = Hide::find($id);
        $rst = $hide->delete();
        if($rst){
            return response()->json(['status' => true]);
        }else{
            return response()->json(['status' => false]);
        }
    }

    public function getHideFromHotspot($id){
        $hotspottype = HotspotType::where('id_hotspot', $id)->get();
        $hide = Hide::find($hotspottype[0]['id_type']);
        return response()->json(['hide' => $hide]);
        
    }
}
