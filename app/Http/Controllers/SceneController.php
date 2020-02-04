<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
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

    public function show($id) {
        $scene = Scene::find($id);
        return response()->json($scene);
    }

    //----------------------------------------------------------------------------------------------

    public function create()
    {
        
    }

    //----------------------------------------------------------------------------------------------

    /**
     * METODO PARA ALMACENAR UNA NUEVA ESCENA EN LA BASE DE DATOS
     */
    public function store(Request $request){
        //Creacion previa del objeto sin contenido
        $scene = new Scene();
        $scene->name = $request->name;
        $scene->pitch = 0;
        $scene->yaw = 0;
        $scene->id_zone = $request->idZone; 
        $scene->top = $request->top;
        $scene->left = $request->left;
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
                unlink(public_path('img/scene-original/').$name);
                //guardar cambios
                $scene->save();
                //Abrir vista para editar la zona
                //return redirect()->route('scene.edit', ['scene' => $scene]);  
                return redirect()->route('zone.edit', ['zone' => $request->idZone]);  
                /*if($scene->save()){
                    return response()->json(['status'=> true]);
                }else{
                    return response()->json(['status'=> false]);
                }*/
            }else{
                //En caso de error eliminar la escena de
                $mov->delete();
                //Eliminar imagen fuente
                unlink(public_path('img/scene-original/').$name);

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
    * METODO PARA ACTUALIZAR UNA ESCENA EN LA BASE DE DATOS
    */
    public function update(Request $request, Scene $scene){    
        //Actualizar nombre
        $scene->name = $request->name;
        //Actualizar foto 360
        if($request->hasFile('image360')){
            //Crear un nombre para almacenar la imagen fuente plano 360
            $idFile = "s".$scene->id;
            $name = $idFile.".".$request->file('image360')->getClientOriginalExtension();
            //Almacenar la imagen en el directorio
            $request->file('image360')->move(public_path('img/scene-original/'), $name);

            /**************************************************/
            /* CREAR TILES (division de imagen 360 en partes) */
            /**************************************************/
            //Eliminar directorio antiguo
            File::deleteDirectory(public_path('marzipano/tiles/'.$scene->directory_name));
            $scene->directory_name = ""; 
            //Ejecucion comando
            $image="img/scene-original/".$name;
            $process = new Process(['krpano\krpanotools', 'makepano', '-config=config', $image]);
            $process->run();
            
            //Comprobar si el comando se ha completado con exito
            if ($process->isSuccessful()) {
                $scene->directory_name = $idFile; 
                //Eliminar imagen fuente que utiliza para trozear y crear el tile
                unlink(public_path('img/scene-original/').$name);
                //guardar cambios
                $scene->save();
                //Abrir vista para editar la zona
                return redirect()->route('zone.edit', ['zone' => $request->idZone]);  
            }else{
                //En caso de error eliminar la escena de
                $mov->delete();
                //Eliminar imagen fuente
                unlink(public_path('img/scene-original/').$name);

                echo "error al crear";
            }
            
        }
    }

    //----------------------------------------------------------------------------------------------

    /**
     * METODO PARA ACTUALIZAR LA VISTA INICIAL DE UNA ESCENA (PITCH Y YAW)
     */
    public function setViewDefault(Request $request, Scene $scene){
        $scene->pitch = $request->pitch;
        $scene->yaw = $request->yaw;
        //Indicamos si los cambios se realizan correctamente
        if($scene->save()){
            return response()->json(['status'=> true]);
        }else{
            return response()->json(['status'=> false]);
        }
    }


    public function pruebas()
    {
        return view('backend/scene/pruebas');
    }

    //----------------------------------------------------------------------------------------------

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $scene = Scene::find($id);
        File::deleteDirectory(public_path('marzipano/tiles/'.$scene->directory_name));
        $result = $scene->delete();
        if($result){
            return response()->json(['status' => true]);
        }else{
            return response()->json(['status' => false]);
        }
    }
}
