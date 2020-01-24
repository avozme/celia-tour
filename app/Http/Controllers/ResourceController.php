<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resource;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resource = Resource::all();
        $data["resources"] = $resource;
        return view('backend.resources.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = Input::file('file');
        $destinationPath = '/img/resources';
        // If the uploads fail due to file system, you can try doing public_path().'/uploads' 
        $filename = str_random(12);
        //$filename = $file->getClientOriginalName();
        //$extension =$file->getClientOriginalExtension(); 
        $upload_success = Input::file('file')->move($destinationPath, $filename);
        
        if( $upload_success ) {
           return Response::json('success', 200);
        } else {
           return Response::json('error', 400);
        }
        $source = new Resource($request->all());
        $resource->title = $fileName;
        $resource->save();
        return redirect()->route('resources.index');
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
        $resource = Resource::find($id);
        $data["resource"]=$resource;
        return view("backend.resources.update",$data);
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
        $resource = Resource::find($id);
        $resource->fill($request->all());
        $resource->save();
        return redirect()->route('resources.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resource = Resource::find($id);
        $resource->delete();
        //return redirect()->route('resources.index');
    }
}
