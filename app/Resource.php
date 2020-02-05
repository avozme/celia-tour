<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Resource extends Model
{
    protected $fillable = ['title', 'description', 'type', 'route'];

    public function galeria(){
        return $this->belongsToMany("App\Gallery", 'resources_gallery', 'resource_id', 'gallery_id');
    }

    /**
     * Devuelve un recurso filtrado por tipo
     * 
     * @return array $data 
     */
    public static function fillType($type){

        $data = DB::table('resources')
        ->where('resources.type', '=', $type)
        ->select('resources.*')
        ->get();

        return $data;
    }
}
