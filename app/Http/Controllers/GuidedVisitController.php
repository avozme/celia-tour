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


class GuidedVisitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['guidedVisit'] = GuidedVisit::all();
        return view('backend.guidedvisit.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.guidedvisit.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $guidedVisit = new GuidedVisit($request->all());
        $path = $request->file('file_preview')->store('', 'guidedVisitMiniature');
        $guidedVisit->file_preview = $path;
        $guidedVisit->save();

        return redirect()->route('guidedVisit.index');
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
        $data['guidedVisit'] = GuidedVisit::find($id);
        return view('backend.guidedVisit.form', $data);
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
        $guidedVisit = GuidedVisit::find($id);
        $guidedVisit->fill($request->all());

        // Se elimina el archivo anterior y guarda el nuevo.
        Storage::disk('guidedVisitMiniature')->delete($guidedVisit->file_preview);
        $path = $request->file('file_preview')->store('', 'guidedVisitMiniature');
        $guidedVisit->file_preview = $path;
        $guidedVisit->save();

        return redirect()->route('guidedVisit.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $guidedVisit = GuidedVisit::find($id);
        Storage::disk('guidedVisitMiniature')->delete($guidedVisit->file_preview);
        GuidedVisit::destroy($id);
        echo '1';
    }


    /*------------------------------------------------- Metodos relacion SceneGuidedVisit -------------------------------------------------------------------*/


    /**
     * Muestra la vista para modificar las escenas a la que pertenece la Visita Guiada
     * 
     * @return \Illuminate\Http\Response
     */
    public function scenes($id)
    {
        $data['guidedVisit'] = GuidedVisit::find($id);
        $data['sgv'] = DB::table('scenes_guided_visit')
                        ->where('scenes_guided_visit.id_guided_visit', '=', $id)
                        ->orderBy('scenes_guided_visit.position', 'asc')
                        ->select('scenes_guided_visit.*')
                        ->get();

        // Cambia el valor del id_resource y id_scene a la ruta al recurso y nombre de la escena
        foreach ($data['sgv'] as $value) {
            $audio = DB::table('resources')
                ->where('id', '=', $value->id_resources)
                ->select('route')
                ->get();
            $value->id_resources = $audio[0]->route;

            $scene = DB::table('scenes')
                ->where('id', '=', $value->id_scenes)
                ->select('name')
                ->get();
            $value->id_scenes = $scene[0]->name;

        }
        $data['audio'] = Resource::fillType('audio');
        $data['scene'] = Scene::all();


        $data['zone'] = Zone::find(2);
        $data['scenes'] = $data['zone']->scenes()->get();

        return view('backend.guidedvisit.scenes', $data);
    }
    
    /**
     * Guarda la relacion de SceneGuidedVisit
     * 
     * @return \Illuminate\Http\Response
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

        return redirect()->route('guidedVisit.scenes', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyScenes($id)
    {

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

    /**
     * Actualiza la lista de posiciones
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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

        return redirect()->route('guidedVisit.scenes', $id);

    }



}
