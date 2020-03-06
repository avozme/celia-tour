<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Alert;
use Artisan;
use Carbon\Carbon;
use Log;
use Spatie\Backup\Helpers\Format;
use Storage;
use Symfony\Component\Process\Process;

class BackupCrontroller extends Controller
{

    /*public function __construct(){

        $this->middleware('auth');
    }*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.backup.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            //start the backup process
            Artisan::call('backup:mysql-dump');
            //$process = new Process(['php', 'artisan', 'backup:run']);
            //$process->run();
            $output = Artisan::output();
            // log the results
            Log::info("Backpack\BackupManager -- new backup started from admin interface \r\n" . $output);
            Log::info("Realizada con exito");
            return redirect()->back();
        } catch (Exception $e) {
            Flash::error($e->getMessage());
            return redirect()->back();
        }
    }

    public function restore(Request $request){
        $nombre = $request->get('nombre');
        Artisan::call("backup:mysql-restore --filename=".$nombre." --yes");
        return redirect()->back();
    }

}
