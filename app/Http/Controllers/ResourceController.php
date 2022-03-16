<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resource;
use App\ResourceGallery;
use App\SceneGuidedVisit;
use App\HotspotType;
use Intervention\Image\ImageManagerStatic;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use DB;

class ResourceController extends Controller
{
    private $photos_path;

    public function __construct(){
        $this->middleware('auth')->except("getRoute");
        $this->photos_path = public_path('/img/resources');
    }

    /**
     * METODO PARA MOSTRAR LA VISTA PRINCIPAL DE RECURSOS
     */
    public function index(){
        $resource = Resource::orderBy("created_at", 'DESC')->get();
        foreach($resource as $key=>$res){
            //Obtener las miniaturas de vimeo para los videos
            if($res['type'] == 'video'){
                $imgid = $res['route'];
                $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$imgid.php"));
                $resource[$key]['preview'] = $hash[0]['thumbnail_medium'];
            }

            //Obtener los subtitulos de los audios
            if($res['type'] == 'audio' && file_exists(public_path("img/resources/subtitles"))){
                $subs = scandir(public_path('img/resources/subtitles'));
                $subsName = array();
                for($i=0;$i<count($subs);$i++){
                    $name = explode( '.', $subs[$i]);
                    if($name[0]==$res['id']){
                        array_push($subsName, $subs[$i]);
                    }
                }
                $resource[$key]['subs'] = $subsName;
            }
        }
        $data["resources"] = $resource;
        return view('backend.resources.index', $data);
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ALMACENAR RECURSOS NUEVOS
     */
    public function store(Request $request){
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
            $replaced = Str::replaceArray(' ', ['_'], $name);
            $save_name = $replaced;
            $buscar = ".";
            $posicion = strpos($save_name, $buscar);
            $extension = substr($save_name, $posicion);
            if($extension == ".png" || $extension == ".jpg" ){
                $ruta = public_path('img/resources/miniatures/'.$save_name);
                ImageManagerStatic::make($photo->getRealPath())->resize(300, 300, function($const){
                    $const->aspectRatio();
                })->save($ruta);
                $ext="image";
            }elseif($extension == ".pdf"){
                $ext="document";
            }elseif($extension == ".glb"){
                $ext="model3D";
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

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ALMACENAR VIDEOS NUEVOS
     */
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

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ACTUALIZAR LOS DATOS DE UN RECURSO EN LA BASE DE DATOS
     */
    public function update(Request $request, $id)
    {
        $correctFile=true;
        $nameSubt=null;
        //Comprobar si existe un archivo de subtitulo adjunto
        if($request->hasFile('subt')){

            //Crear un nombre para almacenar el fichero
            $extension = explode( '.', $request->file('subt')->getClientOriginalName());
            if(count($extension)<3){
                $correctFile=false;
            }else{
                //Comprobar extensión correcta
                if($extension[count($extension)-1]=="vtt"){
                    $nameSubt = $id.".".$extension[count($extension)-2].".".$extension[count($extension)-1];
                    //Almacenar el archivo en el directorio creandolo si no existe
                    $request->file('subt')->move(public_path('img/resources/subtitles'), $nameSubt);
                }else{
                    $correctFile=false;
                }
            }
        }

        $resource = Resource::find($id);
        $resource->fill($request->all());
        if($resource->save() && $correctFile){
            return response()->json(['status'=> true, 'nameSubt'=>$nameSubt]);
        }else{
            //Enviar error con un codigo para identificar la causa
            if(!$correctFile){
                return response()->json(['status'=> false, 'errorCode'=>1]);
            }else{
                return response()->json(['status'=> false, 'errorCode'=>0]);
            }
        }
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ELIMINAR UN RECURSO DE LA BASE DE DATOS
     */
    public function destroy($id){
        $resource = Resource::find($id);
        $relacion = ResourceGallery::where("resource_id", $id)->get();
        $visitaGuiada = SceneGuidedVisit::where("id_resources", $id)->get();

        $contVG = count($visitaGuiada);
        $contR = count($relacion);

        if($contR == 0 && $contVG == 0){
            unlink(public_path("img/resources/").$resource->route);
            if(file_exists(public_path("img/resources/miniatures/").$resource->route)){
                unlink(public_path("img/resources/miniatures/").$resource->route);
            }
            $resource->delete();

        // Modificar el ID_TYPE para que vuelva a -1, indicando que esta vacío.
        $hotspot = HotspotType::where("id_type", $id)->get();
        $ht = HotspotType::find($hotspot[0]->id);
        $ht -> id_type = -1;

        if($ht->save()){
            return response()->json(['status' => true]);
        }else{
            return response()->json(['status' => false]);
        }

            return response()->json(['status'=> true]);
        }else{
            return response()->json(['status'=> false, 'guidedVisit' => $contVG, 'resourceGallery' => $contR]);
        }
    }

    //--------------------------------------------------------

    /*
     * METODO PARA ELIMINAR UN SUBTITULO
     */
    public function deleteSubtitle(Request $request){
        return response()->json(['status'=> unlink(public_path("img/resources/subtitles/").$request->subt)]);
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
     * METODO PARA OBTENER LOS MODELOS ALMACENADOS EN LA BASE DE DATOS
     */
    public function getModel3D(){
        $resources = Resource::where('type','model3D')->get();
        return response()->json($resources);
    }

    /**
     * METODO PARA OBTENER EL NOMBRE DEL MODELO 3D ALMACENADO EN UN HOTSPOT
     */
    public function getNameModel3D($id){
        $name = DB::select(DB::raw("SELECT id_type, title FROM hotspot_types
        INNER JOIN resources
        ON hotspot_types.id_type = resources.id
        WHERE id_type = $id"));
        $name = $name[0]->title;
        //return response()->json($name);
        echo $name;
    }

    //--------------------------------------------------------

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

    /*
    * FUNCIÓN PARA OBTENER UN RECURSO CONCRETO
    */
    public function getOneResource($id){
        $resource = Resource::find($id);
        return response()->json(['resource' => $resource]);
    }

    //---------------------------------------------------------------------------------------

    /**
    * METODO PARA BUSCAR ELEMENTOS DENTRO DE RECURSOS CON UNA CLAVE
    */
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

    /* METODO PARA ELIMINAR VARIOS RECURSOS A LA VEZ */
    public function eliminarRecursos(Request $request){
        $ids = $request->ids;
        for($i=0; $i<count($ids); $i++){
            $recurso = Resource::find($ids[$i]);
            $recurso->delete();
        }

        return redirect()->action('ResourceController@index');
    }

    /* DEVUELVE EL ID DE LOS RECURSOS SEGUN LA BUSQUEDA ESPECIFICADA  */
    public function searchResources(Request $request){
        $resources = DB::table('resources')->where([
                        ['type', '=', $request->typeResource],
                        ['title', 'like', '%'.$request->search.'%'],
                    ])
                    ->orWhere('description', 'like',"%".$request->search."%")
                    ->select('id')
                    ->get();
        return response()->json($resources);
    }
}
