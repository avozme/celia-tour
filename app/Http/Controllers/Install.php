<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Artisan;
class Install extends Controller
{
    /**
     * METODO PARA MOSTRAR LA VISTA PRINCIPAL DE INSTALACION
     */
    public function index($data = null){
        
        if($data == null)
            return view('install');
        else
            return view('install', $data);
        
    }

    public function checkData(Request $r){
        // Datos de la base de datos y usuarios
        if($r->SName != "" && $r->UName != "" && $r->BName != "" && $r->Sys != NULL && $r->Name != "" && (preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!¡%*#?¿&()])[A-Za-z\d@$!¡%*#?¿&()]{8,}$/', $r->pass))){
            $servidor = $r->SName;
            $usuarioDB = $r->UName;
            // $contrasenaDB = $r->PName;
            $baseDeDatos = $r->BDName;
            $sistema = $r->Sys;
            $usuario = $r->Name;
            $contrasena = Hash::make($r->Pass);
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function instalation(Request $r){

        $servidor = $r->SName;
        $usuarioDB = $r->UName;
        $contrasenaDB = $r->PName;
        $baseDeDatos = $r->BDName;
        $sistema = $r->Sys;
        $usuario = $r->Name;
        $contrasena = Hash::make($r->Pass);
        
        $fh = fopen(".env", 'w') or die("Se produjo un error al crear el archivo");
  
  $texto = <<<_END
  APP_NAME=Laravel
  APP_ENV=local
  APP_KEY=base64:LmnXuCC2k6B1E4Rc1s0vCoYW26/8DzeUTtQRVZNTsbo=
  APP_DEBUG=true
  APP_URL=http://$servidor
  
  LOG_CHANNEL=stack
  
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=$baseDeDatos
  DB_USERNAME=$usuarioDB
  DB_PASSWORD=$contrasenaDB
  
  BROADCAST_DRIVER=log
  CACHE_DRIVER=file
  QUEUE_CONNECTION=sync
  SESSION_DRIVER=file
  SESSION_LIFETIME=120
  
  REDIS_HOST=127.0.0.1
  REDIS_PASSWORD=null
  REDIS_PORT=6379
  
  MAIL_DRIVER=smtp
  MAIL_HOST=smtp.mailtrap.io
  MAIL_PORT=2525
  MAIL_USERNAME=null
  MAIL_PASSWORD=null
  MAIL_ENCRYPTION=null
  
  AWS_ACCESS_KEY_ID=
  AWS_SECRET_ACCESS_KEY=
  AWS_DEFAULT_REGION=us-east-1
  AWS_BUCKET=
  
  PUSHER_APP_ID=
  PUSHER_APP_KEY=
  PUSHER_APP_SECRET=
  PUSHER_APP_CLUSTER=mt1
  
  MIX_PUSHER_APP_KEY=\${PUSHER_APP_KEY}
  MIX_PUSHER_APP_CLUSTER=\${PUSHER_APP_CLUSTER}
_END;
  
    fwrite($fh, $texto) or die("El fichero no se ha podido crear con éxito, realice una copia de este contenido en su fichero .env: <br> <br>
    APP_NAME=Laravel <br>
    APP_ENV=local <br>
    APP_KEY=base64:LmnXuCC2k6B1E4Rc1s0vCoYW26/8DzeUTtQRVZNTsbo= <br>
    APP_DEBUG=true <br>
    APP_URL=http://$servidor <br> <br>
    
    LOG_CHANNEL=stack <br> <br>
    
    DB_CONNECTION=mysql <br>
    DB_HOST=127.0.0.1 <br>
    DB_PORT=3306 <br>
    DB_DATABASE=$baseDeDatos <br>
    DB_USERNAME=$usuarioDB <br>
    DB_PASSWORD=$contrasenaDB <br> <br>
    
    BROADCAST_DRIVER=log <br>
    CACHE_DRIVER=file <br>
    QUEUE_CONNECTION=sync <br>
    SESSION_DRIVER=file <br>
    SESSION_LIFETIME=120 <br> <br>
    
    REDIS_HOST=127.0.0.1 <br>
    REDIS_PASSWORD=null <br>
    REDIS_PORT=6379 <br> <br>
    
    MAIL_DRIVER=smtp <br>
    MAIL_HOST=smtp.mailtrap.io <br>
    MAIL_PORT=2525 <br>
    MAIL_USERNAME=null <br>
    MAIL_PASSWORD=null <br>
    MAIL_ENCRYPTION=null <br> <br>
    
    AWS_ACCESS_KEY_ID= <br>
    AWS_SECRET_ACCESS_KEY= <br>
    AWS_DEFAULT_REGION=us-east-1 <br>
    AWS_BUCKET= <br> <br>
    
    PUSHER_APP_ID= <br>
    PUSHER_APP_KEY= <br>
    PUSHER_APP_SECRET= <br>
    PUSHER_APP_CLUSTER=mt1 <br> <br>
    
    MIX_PUSHER_APP_KEY=\${PUSHER_APP_KEY} <br>
    MIX_PUSHER_APP_CLUSTER=\${PUSHER_APP_CLUSTER} <br> <br>
    
    SYSTEM_HOST=$sistema");
    
    fclose($fh);
  
    rename(".env", "../.env");
  

        // creación de la conexión a la base de datos con mysql_connect()
        $conexion = mysqli_connect( $servidor, $usuarioDB, $contrasenaDB ) or die ("No se ha podido conectar al servidor de Base de datos");
        // Selección de la base de datos a utilizar
        $db = mysqli_select_db( $conexion, $baseDeDatos ) or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos" );
        // lanza las migraciones
        Artisan::call('migrate:fresh');
        // lanza el seeder necesario
        Artisan::call('db:seed --class=OptionsTableSeeder');
        // crea el usuario indicado por el administrador
        $sql = "INSERT INTO users (name, email, password, type) 
        VALUES ('$usuario' , '$usuario@gmail.com', '$contrasena', '1')";
        // inserta el usuario creado
        $db = mysqli_query($conexion, $sql);
        // cerrar conexión de base de datos
        mysqli_close( $conexion ); 

    //unlink("../resources/views/install.blade.php");

        return view('install');
        //return redirect("/login");
    }
}
