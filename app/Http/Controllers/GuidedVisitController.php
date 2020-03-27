<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\GuidedVisit;
use App\SceneGuidedVisit;
use App\Resource;
use App\Scene;
use App\Zone;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\respone;


class GuidedVisitController extends Controller
{

    public function __construct(){

        $this->middleware('auth');
    }

    /**
     * METODO PARA MOSTRAR LA VISTA PRINCIPAL
     */
    public function index(){
        $data['guidedVisit'] = GuidedVisit::all();
        return view('backend.guidedvisit.index', $data);
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA MOSTRAR LA VISTA DE CREAR UNA NUEVA VISITA GUIADA
     */
    public function create(){
        return view('backend.guidedvisit.form');
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ALMACENAR UNA NUEVA VISITA GUIADA EN LA BASE DE DATOS
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'file_preview' => 'file | image',
        ]);

        $guidedVisit = new GuidedVisit($request->all());
        $path = $request->file('file_preview')->store('', 'guidedVisitMiniature');
        $guidedVisit->file_preview = $path;
        $guidedVisit->save();

        $data['guidedVisit'] = $guidedVisit;
        $data['routeScene'] = route('guidedVisit.scenes', $guidedVisit->id);
        $data['routeUpdate'] = route('guidedVisit.openUpdate', $guidedVisit->id);

        return response()->json($data);
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA MOSTRAR LA VISTA DE EDICIÓN DE UNA VISITA GUIADA
     */
    public function edit($id){
        $data['guidedVisit'] = GuidedVisit::find($id);
        return view('backend.guidedVisit.form', $data);
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ACTUALIZAR LOS DATOS DE UNA VISITA GUIADA EN LA BASE DE DATOS
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $guidedVisit = GuidedVisit::find($id);
        $guidedVisit->fill($request->all());

        // Se elimina el archivo anterior y guarda el nuevo.
        if(!isset($request->not_file)){
            Storage::disk('guidedVisitMiniature')->delete($guidedVisit->file_preview);
            $path = $request->file('file_preview')->store('', 'guidedVisitMiniature');
            $guidedVisit->file_preview = $path;
        }
        $guidedVisit->save();

        $data['guidedVisit'] = $guidedVisit;
        $data['route'] = route('guidedVisit.scenes', $guidedVisit->id);

        return response()->json($data);
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ELIMINAR UNA VISITA GUIADA EN LA BASE DE DATOS
     */
    public function destroy($id){
        $count = DB::table('scenes_guided_visit')
                ->where('id_guided_visit', $id)
                ->count();
        
        // Se comprueba que no haya escenas asignadas a esta visita guiada
        if($count > 0){
            $data['error'] = true;
        } else {
            $data['error'] = false;
            $guidedVisit = GuidedVisit::find($id);
            Storage::disk('guidedVisitMiniature')->delete($guidedVisit->file_preview);
            GuidedVisit::destroy($id);
        }
        return response()->json($data);
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ENVIAR LOS DATOS PARA ACTUALIZAR UNA VISITA GUIADA
     */
    public function openUpdate($id){
        $guidedVisit = GuidedVisit::find($id);
        return response()->json($guidedVisit);
    }

    /*------------------------------------------------- Metodos relacion SceneGuidedVisit -------------------------------------------------------------------*/

    /**
     * METODO PARA MODIFICAR LAS ESCENAS QUE PERTENECEN A LA VISITA GUIADA
     */
    public function scenes($id){
        $data['guidedVisit'] = GuidedVisit::find($id);
        $scenesIds = array();
        $data['sgv'] = DB::table('scenes_guided_visit')
                        ->where('scenes_guided_visit.id_guided_visit', '=', $id)
                        ->orderBy('scenes_guided_visit.position', 'asc')
                        ->select('scenes_guided_visit.*')
                        ->get();

        // Cambia el valor del id_resource y id_scene a la ruta del recurso y nombre de la escena respectivamente
        foreach ($data['sgv'] as $value) {
            $audio = DB::table('resources')
                ->where('id', '=', $value->id_resources)
                ->select('route')
                ->get();
            $value->id_resources = url('/img/resources') . "/". $audio[0]->route;

            $scene = DB::table('scenes')
                ->where('id', '=', $value->id_scenes)
                ->select('name')
                ->get();
            $scenesIds[] = $value->id_scenes;
            $value->id_scenes = $scene[0]->name;
        }
        // Se recuperan todos los audios
        $data['audio'] = Resource::fillType('audio');

        // Se recuperan las zonas y la zona a previsualizar
        $data['zones'] = Zone::all();
        $data['firstZoneId'] = 1;
        $data['scenesIds'] = $scenesIds;

        return view('backend.guidedvisit.scenes', $data);
    }

    //---------------------------------------------------------------------------------------
    
    /**
     * METODO PARA GUARDAR LA RELACION CON LA TABLA SceneGuidedVisit
     */
    public function scenesStore(Request $request, $id)
    {
        // Obtiene la cantidad de escenas que tiene la visita guiada
        $lastPosition = DB::table('scenes_guided_visit')
        ->where('id_guided_visit', $id)
        ->count();

        $sceneGuidedVisit = new SceneGuidedVisit();
        $sceneGuidedVisit->id_scenes = $request->scene;
        $sceneGuidedVisit->id_resources = $request->resource;
        $sceneGuidedVisit->id_guided_visit = $id;
        $sceneGuidedVisit->position = ++$lastPosition;
        $sceneGuidedVisit->save();


        // Recupera el nombre de la escena
        $sceneName = DB::table('scenes')
                ->where('id', '=', $sceneGuidedVisit->id_scenes)
                ->select('name')
                ->get();

        // Devuelve los datos necesarios para generar una fila de la vista

        $data['sgv'] = $sceneGuidedVisit;
        $data['scene'] = $sceneName[0];

        $data['sgv']->id_resources = DB::table('resources')
                                    ->where('id', $sceneGuidedVisit->id_resources)
                                    ->select('route')
                                    ->get();
        // Se elimina el array y el objeto en el que viene el recurso.
        $data['sgv']->id_resources = $data['sgv']->id_resources[0]->route;  

        return response()->json($data);
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ELIMIANAR ESCENAS ASOCIADAS A UNA VISITA GUIADA
     */
    public function destroyScenes($id){
        // Obtiene la escena_visita_guiada
        $sgv = DB::table('scenes_guided_visit')
        ->where('id', $id)
        ->select('*')
        ->get();

        // Obtiene las escenas que esta en posicion por encima de esta visita guiada
        $data = DB::table('scenes_guided_visit')
        ->where([
            ['id_guided_visit', '=', $sgv[0]->id_guided_visit],
            ['position', '>', $sgv[0]->position]
        ])
        ->select('*')
        ->get();
        
        // Actualiza las nuevas posiciones de las escenas_visitas_guiadas
        foreach ($data as $value) {
            DB::table('scenes_guided_visit')
            ->where('id', $value->id)
            ->update(['position' => ($value->position - 1)]);
        }

        SceneGuidedVisit::destroy($id);
        echo '1';
    }

    //---------------------------------------------------------------------------------------

    /**
     * ACTUALIZAR LA LISTA DE POSICIONES DE LAS ESCENAS
     */
    public function scenesPosition(Request $request, $id)
    {
        // Se pasa el orden a array
        // [1][3][,][2]
        $string = str_split($request->position);

        // Se eliminan las comas y se guardan las posiciones correctamente
        // [13][2]
        $i = 0;
        $position = array();
        foreach ($string as $value) {
            if($value != ','){

                if(isset($position[$i])) {
                    $position[$i] = ( $position[$i] . $value );
                } else {
                    $position[$i] = $value;
                } 

            } else {
                $i++;
            }
        }

        // Actualiza las posiciones de las escenas
        for ($j=0; $j < count($position) ; $j++) {

            DB::table('scenes_guided_visit')
            ->where('id', $position[$j])
            ->update(['position' => ($j+1)]);
            
        }
    }
}