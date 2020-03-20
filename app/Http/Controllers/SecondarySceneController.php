<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SecondaryScene;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Response;
use App\Scene;
use App\Zone;
use App\Gallery;
use App\Portkey;

class SecondarySceneController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * METODO PARA ALMACENAR UNA ESCENA SECUNDARIA EN LA BASE DE DATOS
     */
    public function store(Request $request)
    {
        //Creación previa del objeto vacio
        $s_scene = new SecondaryScene();
        $s_scene->name = $request->name;
        $s_scene->date = $request->date;
        $s_scene->pitch = 0;
        $s_scene->yaw = 0;
        $s_scene->directory_name = "0"; 
        $s_scene->id_scenes = $request->idScene; 
        //Guardamos la escena
        $s_scene->save();
        //Comprobar si existe el archivo 360
        if($request->hasFile('image360')){
            //Crear un nombre para almacenar el fichero
            $idFile = "ss".$s_scene->id;
            $name = $idFile.".".$request->file('image360')->getClientOriginalExtension();
            //Almacenar el archivo en el directorio
            $request->file('image360')->move(public_path('img/scene-original/'), $name);

            /**************************************************/
            /* CREAR TILES (division de imagen 360 en partes) */
            /**************************************************/
            //Ejecucion comando
            $image="img/scene-original/".$name;
            $process = null;
            if(getenv('SYSTEM_HOST') == 'windows'){
                $process = new Process(['krpano\krpanotools', 'makepano', '-config=config', $image]);
            }else if(getenv('SYSTEM_HOST') == 'linux'){
                $process = new Process(['./krpano/krpanotools', 'makepano', '-config=config', $image]);
            }else{
                echo ('Sentimos comunicarle que la aplicación Celia Tour no está disponible para su sistema');;
            }
            $process->run();
            
            //Comprobar si el comando se ha completado con exito
            if ($process->isSuccessful()) {
                $s_scene->directory_name = $idFile; 
                //Eliminar imagen fuente que utiliza para trozear y crear el tile
                unlink(public_path('img/scene-original/').$name);
                //guardar cambios
                $s_scene->save();
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
                $s_scene->delete();
                //Eliminar imagen fuente
                unlink(public_path('img/scene-original/').$name);

                echo "error al crear";
            }

        }
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA OBTENER LOS DATOS UNA ESCENA SECUDARIA A TRAVES DEL ID DE LA PRIMARIA
     */
    public function show($id_scene)
    {
        $s_scene = SecondaryScene::where('id_scenes', $id_scene)->get();
        return response()->json($s_scene);
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA OBTENER LOS DATOS UNA ESCENA SECUDARIA A TRAVES DE SU ID
     */
    public function showScene($id)
    {
        $s_scene = SecondaryScene::find($id);
        return response()->json($s_scene);
    }

    //----------------------------------------------------------------------------------------------

    /**
     * METODO PARA ACTUALIZAR LA VISTA INICIAL DE UNA ESCENA (PITCH Y YAW)
     */
    public function setViewDefault(Request $request, $id){
        $sScene = SecondaryScene::find($id);
        $sScene->pitch = $request->pitch;
        $sScene->yaw = $request->yaw;
        //Indicamos si los cambios se realizan correctamente
        if($sScene->save()){
            return response()->json(['status'=> true]);
        }else{
            return response()->json(['status'=> false]);
        }
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ACTUALIZAR UNA ESCENA SECUNDARIA
     */
    public function update(Request $request){
            $id = $request->id;
            $s_scene = SecondaryScene::find($id);
            //Actualizar nombre
            $s_scene->name = $request->name;
            //Actualizar fecha
            $s_scene->date = $request->date;
            //Actualizar foto 360  
            if($request->hasFile('image360')){
                //Crear un nombre para almacenar la imagen fuente plano 360
                $idFile = "ss".$s_scene->id;
                $name = $idFile.".".$request->file('image360')->getClientOriginalExtension();
                //Almacenar la imagen en el directorio
                $request->file('image360')->move(public_path('img/scene-original/'), $name);
    
                /**************************************************/
                /* CREAR TILES (division de imagen 360 en partes) */
                /**************************************************/
                //Eliminar directorio antiguo
                File::deleteDirectory(public_path('marzipano/tiles/'.$s_scene->directory_name));
                $s_scene->directory_name = ""; 
                //Ejecucion comando
                $image="img/scene-original/".$name;
                $process = null;
                if(getenv('SYSTEM_HOST') == 'windows'){
                    $process = new Process(['krpano\krpanotools', 'makepano', '-config=config', $image]);
                }else if(getenv('SYSTEM_HOST') == 'linux'){
                    $process = new Process(['./krpano/krpanotools', 'makepano', '-config=config', $image]);
                }else{
                    echo ('Sentimos comunicarle que la aplicación Celia Tour no está disponible para su sistema');;
                }
                $process->run();
                
                //Comprobar si el comando se ha completado con exito
                if ($process->isSuccessful()) {
                    $s_scene->directory_name = $idFile; 
                    //Eliminar imagen fuente que utiliza para trozear y crear el tile
                    unlink(public_path('img/scene-original/').$name);
                    //guardar cambios
                    $s_scene->save();
                    //Abrir vista para editar la zona
                    return redirect()->route('zone.edit', ['zone' => $request->idZone]);  
                }else{
                    //En caso de error eliminar la escena de
                    $s_scene->delete();
                    //Eliminar imagen fuente
                    unlink(public_path('img/scene-original/').$name);
    
                    echo "error al crear";
                }
                
            }
            $s_scene->save();
            return redirect()->route('zone.edit', ['zone' => $request->idZone]);
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA ELIMINAR UNA ESCENA SECUNDARIA DE LA BASE DE DATOS
     */
    public function destroy($id){
        $s_scene = SecondaryScene::find($id);
        $s_scene->delete();
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA MOSTRAR LA VISTA CORRESPONDIENTE CON LA EDICION DE LA ESCENA
     */
    public function edit($id){
        $sScene = SecondaryScene::find($id);
        $idPrincipalScene = $sScene->id_scenes;
        $scene = Scene::find($idPrincipalScene);
        $idZone = $scene->id_zone;
        $zone = Zone::find($idZone);
        $scenes = $zone->scenes()->get();
        $galleries = Gallery::all();
        $portkeys = Portkey::all();
        return view('backend/scene/edit', ['scene'=>$sScene, 'scenes' => $scenes, 'zone' => $zone, 'galleries' => $galleries, 'portkeys' => $portkeys]);
    }
}