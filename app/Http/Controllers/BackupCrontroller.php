<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Alert;
use Artisan;
use Carbon\Carbon;
use Log;
use Spatie\Backup\Helpers\Format;
use Symfony\Component\Process\Process;

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
            // log the results
            Log::info("Backpack\BackupManager -- new backup started from admin interface \r\n" . $output);
            Log::info("Realizada con exito");
            return Storage::disk('local')->download($nombre);

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
