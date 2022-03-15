<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{   
    /**
     * Rotate Image View
     *
     * @return void
    */
    public function rotateImage(){
        return redirect()->route('zone.index');
    }

    /**
     * Rotate Image Preview
     *
     * @return void
    */
    public function rotateImageStore($file_name){
        
        $parts = pathinfo($file_name);

            $degrees = 90;

            $source = imagecreatefromjpeg("img/zones/images/".$file_name);

            $rotate = imagerotate($source, $degrees, 0);

            imagejpeg($rotate, "myUpdateImage.jpeg");

            return redirect()->route('zone.index');
    }
}