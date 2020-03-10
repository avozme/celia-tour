<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resource;
use App\ResourceGallery;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class ResourceController extends Controller
{
    private $photos_path;

    public function __construct()
    {
        $this->middleware('auth')->except("getRoute");

        $this->photos_path = public_path('/img/resources');

        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resource = Resource::orderBy("created_at", 'DESC')->get();
        //Obtener las miniaturas de vimeo para los videos
        foreach($resource as $key=>$res){
            if($res['type'] == 'video'){
                $imgid = $res['route'];
                $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$imgid.php"));
                $resource[$key]['preview'] = $hash[0]['thumbnail_medium'];
            }
        }
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
        echo("create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $photos = $request->file('file');

        if (!is_array($photos)) {
            $photos = [$photos];
        }

        if (!is_dir($this->photos_path)) {
            mkdir($this->photos_path, 0777);
        }

        for ($i = 0; $i < count($photos); $i++) {
            $photo = $photos[$i];
            $name = $photo->getClientOriginalName();
            $save_name = $name;
            $buscar = ".";
            $posicion = strpos($save_name, $buscar);
            $extension = substr($save_name, $posicion);
            if($extension == ".png" || $extension == ".jpg" ){
                $ext="image";
            }elseif($extension == ".pdf"){
                $ext="document";
            }elseif($extension == ".mp3" || $extension == ".wav" ){
                $ext="audio";
            }
            $photo->move($this->photos_path, $save_name);
            $resource = new Resource();
            $resource->title = $save_name;
            $resource->route = $save_name;
            $resource->type= $ext;
            $resource->save();
        }
        return Response::json([
            'message' => 'Image saved Successfully',
            'id' => $resource->id,
            'type' => $resource->type,
            'route' => $resource->route,
            'title' => $resource->title
        ], 200);
    }

    public function store_video(Request $request){
        $v = \Validator::make($request->all(), [
            'title' => 'required',
            'route' => 'required'
        ]);
        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }
            $buscar = "m/";
            $posicion = strpos($request->route, $buscar);
            $ruta = substr($request->route, $posicion+2);
            $resource = new Resource();
            $resource->title = $request->title;
            $resource->route = $ruta;
            $resource->type = "video";
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        echo("edit");
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
        if($resource->save()){
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
        $resource = Resource::find($id);
        $relacion = ResourceGallery::where("resource_id", $id)->get();
        //dd($relacion);
        $num = count($relacion);
        //echo($num);
        if($num == 0){
            $resource->delete();
            unlink(public_path("img/resources/").$resource->route);
            return response()->json(['status'=> true]);
        }else{
            return response()->json(['status'=> false]);
        }
    }

    //------------------------------------------------------

    /**
     * METODO PARA OBTENER LOS VIDEOS ALMACENADOS EN LA BASE DE DATOS Y SU PREVIEW
     */
    public function getVideos(){
        $resources = Resource::where('type','video')->get();
        //Obtener miniatura de vimeo y adjuntarla al array
        foreach($resources as $key=>$res){
            $imgid = $res['route'];
            $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$imgid.php"));
            $resources[$key]['preview'] = $hash[0]['thumbnail_medium'];
        }
        return response()->json($resources);
    }

    //-------------------------------------------------------

    /**
     * METODO PARA OBTENER LOS AUDIOS ALMACENADOS EN LA BASE DE DATOS
     */
    public function getAudios(){
        $resources = Resource::where('type','audio')->get();
        return response()->json($resources);
    }

    //--------------------------------------------------------
    
    /*
     * METODO PARA OBTENER LA RUTA DE UN RECURSO
     */
    public function getRoute(Resource $id){
        return response()->json($id->route);
    }

    /*METODO PARA EL BUSCADOR*/
    public function buscador(Request $request){
        $resources = Resource::where('title', 'like', $request->texto.'%')
        ->orWhere('description', 'like',"%".$request->texto."%")->get();

        foreach($resources as $key=>$res){
            if($res['type'] == 'video'){
                $imgid = $res['route'];
                $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$imgid.php"));
                $resources[$key]['preview'] = $hash[0]['thumbnail_medium'];
            }
        }
        $data["resources"] = $resources;
        return view('backend.resources.index', $data);
    }
}
