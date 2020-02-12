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
        $data["gallery"] = $gallery;
        return view('backend.gallery.index', $data);
    }

    public function store(Request $request)
    {
        $gallery = new Gallery($request->all());
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
        $gallery->save();
        return redirect()->route('gallery.index');
    }

    public function update_resources(Request $request, $id)
    {
        $gallery = Gallery::find($id);
        $gallery->fill($request->all());
        $gallery->save();
        $gallery->recursos()->sync($request->recursos);
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
}