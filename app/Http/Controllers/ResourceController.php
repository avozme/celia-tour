<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resource;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class ResourceController extends Controller
{
    private $photos_path;

    public function __construct()
    {
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
            }elseif($extension == ".pdf" || $extension == ".docx" ){
                $ext="document";
            }elseif($extension == ".mp3" || $extension == ".wav" ){
                $ext="audio";
            }
            $photo->move($this->photos_path, $save_name);
            $resource = new Resource();
            $resource->title = $save_name;
            $resource->route = "img/resources/".$save_name;
            $resource->type= $ext;
            $resource->save();
        }
        return Response::json([
            'message' => 'Image saved Successfully'
        ], 200);
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
}
