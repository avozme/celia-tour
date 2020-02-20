<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hotspot;
use App\Jump;
use App\HotspotType;

class HotspotTypeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
    public function store(Request $request)
    {
        //
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
        //
    }

    public function getIdJump($hotspot){
        $hotspottype = HotspotType::where('id_hotspot', $hotspot)->get();
        return response()->json(['jump' => $hotspottype[0]['id_type']]);
        //echo $hotspottype[0]['id_type'];
    }

    public function getIdGallery($hotspot){
        $hotspottype = HotspotType::where('id_hotspot', $hotspot)->get();
        return response()->json(['gallery' => $hotspottype[0]['id_type']]);
    }

    public function getIdPortkey($hotspot){
        $hotspottype = HotspotType::where('id_hotspot', $hotspot)->get();
        return response()->json(['portkey' => $hotspottype[0]['id_type']]);
    }

    public function getIdType($hotspot){
        $hotspottype = HotspotType::where('id_hotspot', $hotspot)->get();
        return response()->json(['id_type' => $hotspottype[0]['id_type']]);
    }

    public function updateIdType(Request $r){
        $hotspottype = HotspotType::where('id_hotspot', $r->hotspot)->get();
        $ht = HotspotType::find($hotspottype[0]->id);
        $ht->id_type = $r->id_type;
        if($ht->save()){
            return response()->json(['status' => true]);
        }else{
            return response()->json(['status' => false]);
        }
    }

    
}
