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
        return view('index');
    }

    /**
     * Rotate Image Preview
     *
     * @return void
    */
    public function rotateImageStore(Request $request){

        $image = $request->file('name');

        $file_name = time().'_'.$image->getClientOriginalName();

        $parts = pathinfo($file_name);

        $extensions = $parts['extension'];

        if($extensions == "jpeg"){

            $degrees = 90;

            $source = imagecreatefromjpeg($image);

            $rotate = imagerotate($source, $degrees, 0);

            imagejpeg($rotate, "myUpdateImage.jpeg");

            return response()->file(public_path('myUpdateImage.jpeg'));

        }elseif($extensions == "png"){  
                
            $degrees = 90;

            $source = imagecreatefrompng($image);

            $rotate = imagerotate($source, $degrees, 0);

            imagepng($rotate, "myUpdateImage.png");

            return response()->file(public_path('myUpdateImage.png'));

        }else{
            echo "Plz Select jpeg And Png File.";
        }
       
    }
}