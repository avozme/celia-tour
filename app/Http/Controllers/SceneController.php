<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use App\Scene;


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

    //----------------------------------------------------------------------------------------------

    public function show($id)
    {
        
    }

    //----------------------------------------------------------------------------------------------

    public function create()
    {
        
    }

    //----------------------------------------------------------------------------------------------

    /**
     * METODO PARA CREAR Y ALMACENAR UNA NUEVA ESCENA
     */
    public function store(Request $request){
        //Creacion previa del objeto sin contenido
        $scene = new Scene();
        $scene->name = "Sin Titulo";
        $scene->pitch = 0;
        $scene->yaw = 0;
        $scene->id_zone = 0; 
        $scene->top = 0;
        $scene->left = 0;
        $scene->directory_name = "0"; 
        //Guardar escena
        $scene->save();

        //Comprobar si existe un archivo "image360" adjunto
        if($request->hasFile('image360')){
            //Crear un nombre para almacenar el fichero
            $idFile = "s".$scene->id;
            $name = $idFile.".".$request->file('image360')->getClientOriginalExtension();
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
                $scene->directory_name = $idFile; 
                //Eliminar imagen fuente que utiliza para trozear y crear el tile
                unlink(public_path('img/scene-original/'), $name);
                //guardar cambios
                $scene->save();
                //Abrir vista para editar la zona
                return redirect()->route('scene.edit', ['scene' => $scene]);  
            }else{
                //En caso de error eliminar la escena de
                $mov->delete();
                //Eliminar imagen fuente
                unlink(public_path('img/scene-original/'), $name);

                echo "error al crear";
            }

        }
    }

    //----------------------------------------------------------------------------------------------

    /**
     * METODO PARA MOSTRAR LA VISTA CORRESPONDIENTE CON LA EDICION DE LA ESCENA
     */
    public function edit(Scene $scene){
        return view('backend/scene/edit', ['scene'=>$scene]);
    }

    //----------------------------------------------------------------------------------------------

    /**
    *
    */
    public function update(Request $request, $id){
        
    }

    //----------------------------------------------------------------------------------------------

    /**
     * METODO PARA ACTUALIZAR LA VISTA INICIAL DE UNA ESCENA (PITCH Y YAW)
     */
    public function setViewDefault(Request $request, $scene){
        $scene = Scene::find($scene);
        $scene->pitch = $request->pitch;
        $scene->yaw = $request->yaw;
        //Actualizar cambios
        $mov->save();
    }

    //----------------------------------------------------------------------------------------------

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
