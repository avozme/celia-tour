<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\GuidedVisit;
use App\SceneGuidedVisit;
use App\Resource;
use App\Scene;
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
        $data['audio'] = Resource::fillType('audio');
        $data['scene'] = Scene::all();
        return view('backend.guidedvisit.scenes', $data);
    }
    
    /**
     * Guarda la relacion de SceneGuidedVisit
     * 
     * @return \Illuminate\Http\Response
     */
    public function scenesStore(Request $request, $id)
    {

        $sceneGuidedVisit = new SceneGuidedVisit();
        $sceneGuidedVisit->id_scenes = $request->scene;
        $sceneGuidedVisit->id_resources = $request->resource;
        $sceneGuidedVisit->id_guided_visit = $id;
        $sceneGuidedVisit->position = 1;
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
        $string = str_split($request->position); // 1 | 3 | , | 2 |

        // 13 | 2
        $i = 0;
        $position = array();
        foreach ($string as $value) {
            if($value != ','){
                $position[$i] = $value;
            } else {
                $i++;
            }
        }

        // Obtener las escenas de la visita guiada ordenadas por posicion
        $sgv = DB::table('scenes_guided_visit')
        ->where('scenes_guided_visit.id_guided_visit', '=', $id)
        ->orderBy('scenes_guided_visit.position', 'asc')
        ->select('scenes_guided_visit.*')
        ->get();


        // UPDATE scenes_guided_visit
        // SET position = $position[$i]
        // WHERE position = $i;

        // Actualiza las posiciones de las escenas
        for ($i=0; $i < count($position) ; $i++) { 
            if($position[$i] != ($i+1)){
                DB::table('scenes_guided_visit')
                ->where('scenes_guided_visit.id', '=', $sgv[$i]->id)
                ->update(['position' => $position[$i]]);
                
                // $sgv[$i]->position = $i;
                // $sgv[$i]->save();
            }
        }
        // echo 'work!';
    }
}
