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
            //start the backup process
            Artisan::call('backup:mysql-dump backup.sql');
            //$process = new Process(['php', 'artisan', 'backup:run']);
            //$process->run();
            $output = Artisan::output();
            // log the results
            $fecha = date('');
            Log::info("Backpack\BackupManager -- new backup started from admin interface \r\n" . $output);
            Log::info("Realizada con exito");
            return Storage::disk('local')->download('backup.sql');

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
    public function restore(Request $request){
        $name = $r->file('name')->getClientOriginalName();
        $r->file('name')->move(public_path('backups'), $name);
        Artisan::call("backup:mysql-restore --filename=backups/".$nombre." --yes");
        return redirect()->back();
    }

}
