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
        return view('backend.backup.index');
    }

    //---------------------------------------------------------------------------------------

    /**
     * METODO PARA CREAR UNA NUEVA COPIA DE SEGURIDAD
     */
    public function create()
    {
        try {
            $fecha = date('Ymd');
            $hora = intval(date('H')) + 1;
            $min = date('i');
            $nombre = $fecha.$hora.$min.'.sql';
            //start the backup process
            Artisan::call('backup:mysql-dump '.$nombre);
            //$process = new Process(['php', 'artisan', 'backup:run']);
            //$process->run();
            $output = Artisan::output();

            /* FUNCION PARA CREAR EL ZIP */

            //Aqui creamos el archivo zip
            $zip_file = "backup.zip"; //Nombre del archivo zip
            //Iniciamos la clase PHP
            $zip = new ZipArchive();
            $res = $zip->open($zip_file, ZipArchive::CREATE);
            if ($res === TRUE) {
                $zip->addFromString('test.txt', 'En este zip se encuentran los recursos necesarios para restaurar la aplicación CeliaTour');
                //Añadimos los archivos que queremos que contenga el zip:
                $zip->addFile(storage_path($nombre), $nombre); //Archivo SQL
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
                echo 'ok';
            } else {
                echo 'falló';
            }

            // log the results
            Log::info("Backpack\BackupManager -- new backup started from admin interface \r\n" . $output);
            Log::info("Realizada con exito");
            //Storage::move(url("").'/'.$zip_file, 'app/'.$zip_file);
            $url = url("").'/'.$zip_file;
            return  redirect($url);

            //return redirect()->back();
        } catch (Exception $e) {
            Flash::error($e->getMessage());
            //return redirect()->back();
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
