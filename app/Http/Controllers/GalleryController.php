<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resource;
use App\Gallery;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gallery = Gallery::all();
        $resources = Resource::fillType("image");
        $data["resources"] = $resources;
        $data["gallery"] = $gallery;
        return view('backend.gallery.index', $data);
    }

    public function store(Request $request)
    {
        $gallery = new Gallery();
        $gallery->title = $request->titleadd;
        $gallery->description = $request->descriptionadd;
        $gallery->save();
        return redirect()->route('gallery.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $gallery = Gallery::find($id);
        $data["gallery"] = $gallery;
        return view('backend.gallery.update', $data);
    }

    public function edit_resources($id)
    {
        $gallery = Gallery::find($id);
        $resources = Resource::fillType("image");
        $data["gallery"] = $gallery;
        $data["resources"] = $resources;
        return view('backend.gallery.resourceUpdate', $data);
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
        $gallery = Gallery::find($id);
        $gallery->fill($request->all());
        if( $gallery->save()){
            return response()->json(['status'=> true]);
        }else{
            return response()->json(['status'=> false]);
        }
    }

    public function update_resources(Request $request, $id)
    {
        $gallery = Gallery::find($id);
        $gallery->fill($request->all());
        $gallery->save();
        $gallery->resources()->sync($request->resources);
        return redirect()->route('gallery.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gallery = Gallery::find($id);
        $gallery->delete();
    }

    public function getImagesFromGallery($galleryId){
        $gallery = Gallery::find($galleryId);
        $images = $gallery->resources()->get();
        return response()->json(['resources' => $images]);
    }

    public function getAllGalleries(){
        $galleries = Gallery::all();
        return response()->json($galleries);
    }
}
