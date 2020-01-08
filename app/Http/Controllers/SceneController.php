<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;


class SceneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend/scene/index');
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
    public function store(Request $request){
        //Comprobar si existe un archivo "image360" adjunto
        if($request->hasFile('image360')){
            //Crear un nombre para almacenar el fichero
            $random = rand(0,1000000);
            $name = $random.".".$request->file('image360')->getClientOriginalExtension();
            //Almacenar el archivo en el directorio
            $request->file('image360')->move(public_path('img/scene-original/'), $name);

            /**************************************************/
            /* CREAR TILES (division de imagen 360 en partes) */
            /**************************************************/
            //Ejecucion comando
            $image="img/scene-original/".$name;
            $process = new Process(['krpano\krpanotools', 'makepano', '-config=config', $image]);
            $process->run();
            
            //Comprobar si el comando se ha completado con exito
            if ($process->isSuccessful()) {
                return view('backend/scene/edit', ['code'=>$random]);
            }else{
                echo "error al crear";
            }

        }
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
