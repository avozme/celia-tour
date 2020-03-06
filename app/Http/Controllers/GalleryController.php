<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resource;
use App\Gallery;
use App\ResourceGallery;

class GalleryController extends Controller
{

    public function __construct(){

        $this->middleware('admin');
    }

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
        $v = \Validator::make($request->all(), [
            'titleadd' => 'required',
            'descriptionadd' => 'required'
        ]);
        if ($v->fails()){
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

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

    public function save_resource($idG, $idR){
        $recurso = new ResourceGallery();
        $recurso->resource_id=$idR;
        $recurso->gallery_id=$idG;
        $recurso->save();
    }

    public function delete_resource($idG, $idR){
        $recurso = ResourceGallery::where('gallery_id', '=' ,$idG)->where('resource_id' , '=', $idR)->get();
        echo($recurso);
        for($i=0; $i<count($recurso); $i++){
            $recurso[$i]->delete();
        }
    }

    public function edit($id)
    {
        $gallery = Gallery::find($id);
        $data["gallery"] = $gallery;
        return view('backend.gallery.update', $data);
    }

    public function edit_resources($id, $resultado=null)
    {
        $gallery = Gallery::find($id);
        $data["gallery"] = $gallery;
        if($resultado==null){
        $resources = Resource::fillType("image");
        $data["resources"] = $resources;
        $data["estado"]="false";
        }else{
            $resources = Resource::where('title', 'like', $resultado.'%')
            ->orWhere('description', 'like',"%".$resultado."%")->get();
            $data["resources"]="";
            if($resources->type="image"){
                $data["resources"] = $resources;
            }
            $data["estado"]="true";
        }
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

    
    /*METODO PARA EL BUSCADOR*/
    public function buscador(Request $request){
        $resources = Resource::where('title', 'like', $request->texto.'%')
        ->orWhere('description', 'like',"%".$request->texto."%")->get();
        $data["resources"]="";
        if($resources->type="image"){
            $data["resources"] = $resources;
        }
        return view('backend.gallery.resourceUpdate', $data);
    }
}
