<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resource;
use App\Gallery;
use App\ResourceGallery;
use App\HotspotType;

class GalleryController extends Controller
{

    public function __construct(){

        $this->middleware('auth')->except("getImagesFromGallery");
    }

    /* METODO PARA MOSTRAR LA VISTA PRINCIPAL DE GALERIAS */
    public function index()
    {
        $gallery = Gallery::all();
        $data["gallery"] = $gallery;
        return view('backend.gallery.index', $data);
    }

    //---------------------------------------------------------------------------------------

    /* METODO PARA GUARDAR UNA NUEVA GALERIA EN LA BASE DE DATOS */
    public function store(Request $request){
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

    //---------------------------------------------------------------------------------------

    /* METODO PARA GUARDAR RECURSOS EN UNA GALERIA */
    public function save_resource($idG, $idR){
        $recurso = new ResourceGallery();
        $recurso->resource_id=$idR;
        $recurso->gallery_id=$idG;
        $recurso->save();
    }

    //---------------------------------------------------------------------------------------

    /* METODO PARA ELIMINAR RECURSOS DE UNA GALERIA */
    public function delete_resource($idG, $idR){
        $recurso = ResourceGallery::where('gallery_id', '=' ,$idG)->where('resource_id' , '=', $idR)->get();
        for($i=0; $i<count($recurso); $i++){
            $recurso[$i]->delete();
        }
    }

    //---------------------------------------------------------------------------------------

    /* METODO PARA MOSTRAR LA VISTA DE EDICIÓN DE UNA GALERIA */
    public function edit($id){
        $gallery = Gallery::find($id);
        $data["gallery"] = $gallery;
        return view('backend.gallery.update', $data);
    }

    //---------------------------------------------------------------------------------------

    /*     */
    public function edit_resources($id, $resultado=null){
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

    //---------------------------------------------------------------------------------------

    /* METODO PARA ACTUALIZAR UNA GALERIA DE IMAGENES */
    public function update(Request $request, $id){
        $gallery = Gallery::find($id);
        $gallery->fill($request->all());
        if( $gallery->save()){
            return response()->json(['status'=> true]);
        }else{
            return response()->json(['status'=> false]);
        }
    }

    //---------------------------------------------------------------------------------------

    /* METODO PARA ACTUALIZAR LOS RECURSOS DE UNA GALERIA DE IMAGENES */
    public function update_resources(Request $request, $id)
    {
        $gallery = Gallery::find($id);
        $gallery->fill($request->all());
        $gallery->save();
        $gallery->resources()->sync($request->resources);
        return redirect()->route('gallery.index');
    }

    //---------------------------------------------------------------------------------------

    /* METODO PARA COMPROBAR SI TIENE DATOS LA GALERIA A ELIMINAR */
    public function contenido($id)
    {
        $relacion = ResourceGallery::where("gallery_id", $id)->get();
        $num = count($relacion);
        if($num == 0){
            return response()->json(['status'=> true]);
        }else{
            return response()->json(['status'=> false, 'num' => $num]);
        }
    }


    //---------------------------------------------------------------------------------------

    /* METODO PARA ELIMINAR UNA GALERIA DE IMAGENES */
    public function destroy($id)
    {
        $gallery = Gallery::find($id);
        $relacion = ResourceGallery::where("gallery_id", $id)->get();
        for($i=0; $i<count($relacion); $i++){
            $relacion[$i]->delete();
        }
        $gallery->delete();
    // Modificar el ID_TYPE para que vuelva a -1, indicando que esta vacío.
        $hotspot = HotspotType::where("id_type", $id)->get();
        $ht = HotspotType::find($hotspot[0]->id);
        $ht -> id_type = -1;
        
        if($ht->save()){
            return response()->json(['status' => true]);
        }else{
            return response()->json(['status' => false]);
        }        
    }

    

    //---------------------------------------------------------------------------------------

    /* METODO PARA OBTENER LAS IMAGENES DE UNA GALERIA DE IMAGENES */
    public function getImagesFromGallery($galleryId){
        $gallery = Gallery::find($galleryId);
        $images = $gallery->resources()->get();
        return response()->json(['resources' => $images]);
    }

    //---------------------------------------------------------------------------------------

    /* METODO PARA RECUPERAR TODAS LAS GALERIAS DE IMAGENES */
    public function getAllGalleries(){
        $galleries = Gallery::all();
        return response()->json($galleries);
    }

    //---------------------------------------------------------------------------------------
    
    /* METODO PARA BUSCAR IMAGENES A TRAVES DE UNA CLAVE ENTRE LOS RECURSOS */
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