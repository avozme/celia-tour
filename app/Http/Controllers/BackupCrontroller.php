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
    public function create()
    {
        try {
            //start the backup process
            Artisan::call('backup:run');
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

    public function restore(){
        
    }

}
