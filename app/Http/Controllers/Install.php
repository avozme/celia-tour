<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Artisan;
class Install extends Controller
{
    /**
     * METODO PARA MOSTRAR LA VISTA PRINCIPAL DE INSTALACION
     */
    public function index(){
        return view('install');
    }

    public function instalation(Request $r){
        
        // Datos de la base de datos
        $servidor = $r->SName;
        $usuarioDB = $r->UName;
        $contrasenaDB = $r->PName;
        $baseDeDatos = $r->BDName;
        $sistema = $r->Sys;
        $usuario = $r->Name;
        $contrasena = $r->Pass;
        
        
        $fh = fopen(".prueba", 'w') or die("Se produjo un error al crear el archivo");
  
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
  
  SYSTEM_HOST=$sistema
_END;
  
  fwrite($fh, $texto) or die("No se pudo escribir en el archivo");
  
  fclose($fh);
  
  echo "Se ha escrito sin problemas";
        

  rename(".prueba", "../.prueba");
  

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

        return view('install');
    }
}
