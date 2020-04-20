<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Zone;
use DB;

class EscapeRoomController extends Controller
{
    
    public function index(){
        $data['zones'] = Zone::orderBy('position')->get();
        $data['firstZoneId'] = 1;
        return view('backend/escaperoom/index', $data);
    }

}
