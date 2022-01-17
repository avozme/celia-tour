<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Alert;
use Artisan;
use Carbon\Carbon;
use Log;
use \ZipArchive;
use Spatie\Backup\Helpers\Format;
use Symfony\Component\Process\Process;
use \RecursiveIteratorIterator;
use DB;

class BackupCrontroller extends Controller
{

    public function __construct(){

        $this->middleware('auth');
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA MOSTRAR LA VISTA PRINCIPAL
     */
    public function index()
    {
        return view('backend.backup.index', ['numberOfZones'=>DB::table('zones')->count()], ['numberOfScenes'=>DB::table('scenes')->count()]);
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA CREAR UNA NUEVA COPIA DE SEGURIDAD
     */
    public function create()
    {
        /*
        echo "Número de zonas : " . DB::table('zones')->count();
        if(DB::table('zones')->count() < 1){
            echo "Se requiere como mínimo una zona para realizar la copia de seguridad ❗";
        }
        */
        try {
            $fecha = date('Ymd');
            $hora = intval(date('H')) + 1;
            $min = date('i');
            $nombre = $fecha.$hora.$min.'.sql';
            //start the backup process
            Artisan::call('backup:mysql-dump '.$nombre);
            $output = Artisan::output();

            /* FUNCION PARA CREAR EL ZIP */

            //Aqui creamos el archivo zip
            $zip_file = "backup.zip"; //Nombre del archivo zip
            //Iniciamos la clase PHP
            $zip = new ZipArchive();
            $res = $zip->open($zip_file, ZipArchive::CREATE);
            if ($res === TRUE) {
                $zip->addFromString('README.txt', 'En este zip se encuentran los recursos necesarios para restaurar la aplicación CeliaTour, para poder restaurarla de forma correcta copie las carpetas Img y Marzipano dentro de la carpeta public de su servidor, por último lance contra el servidor el archivo SQL.');
                //Añadimos los archivos que queremos que contenga el zip:
                $zip->addFile(storage_path('app/'.$nombre), $nombre); //Archivo SQL
                //Marzipano
                //Comprobamos si existe el directorio marzipano
                if(!file_exists('marzipano')){
                    echo "La carpeta marzipano no existe";
                    mkdir('marzipano', 0777, false);
                    if(file_exists('marzipano')){
                        echo "La carpeta marzipano se ha creado correctamente";
                    }
                }
                $path = public_path('marzipano');
                $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
                foreach ($files as $name => $file)
                {
                    // We're skipping all subfolders
                    if (!$file->isDir()) {
                        $filePath     = $file->getRealPath();

                        // extracting filename with substr/strlen
                        $relativePath = 'marzipano/' . substr($filePath, strlen($path) + 1);

                        $zip->addFile($filePath, $relativePath);
                    }
                } 
                //Recursos
                $path = public_path('img');
                $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
                foreach ($files as $name => $file)
                {
                    // We're skipping all subfolders
                    if (!$file->isDir()) {
                        $filePath     = $file->getRealPath();

                        // extracting filename with substr/strlen
                        $relativePath = 'img/' . substr($filePath, strlen($path) + 1);

                        $zip->addFile($filePath, $relativePath);
                    }
                } 
                //Cerramos el zip
                $zip->close();
                echo '<br><br>ok';
            } else {
                echo 'falló';
            }

            // log the results
            Log::info("Backpack\BackupManager -- new backup started from admin interface \r\n" . $output);
            Log::info("Realizada con exito");
            $url = url("").'/'.$zip_file;
            return  redirect($url);
        } catch (Exception $e) {
            Flash::error($e->getMessage());
        }
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA RESTAURAR UNA COPIA DE SEGURIDAD
     */
    public function restore(Request $r){
        $name = $r->file('nombre')->getClientOriginalName();
        $fname = str_replace(' ', '', $name);
        $r->file('nombre')->move(storage_path('app/'), $fname);
        $comando = "backup:mysql-restore -f ".$fname." -y";
        Artisan::call($comando);
        return redirect()->back();
    }

}
