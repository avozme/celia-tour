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
    public function rotateImage()
    {
        return redirect()->route('zone.index');
    }

    /**
     * Rotate Image Preview
     *
     * @return void
     */
    public function rotateImageStore($file_name)
    {
        /*
        echo("Nombre de la imagen: " . $file_name);
        $rutaDeImagenDeZona = "img/zones/images/" . $file_name;
        echo("<br>");
        echo($rutaDeImagenDeZona);
        echo("<br>");
        echo('<img src="' . $rutaDeImagenDeZona . '">');
       */

        
        

        //echo ("😎 <br>");

        //echo($file_name);

        //$parts = pathinfo($file_name);

        /*
        $degrees = -90;

        $source = imagecreatefromjpeg("img/zones/images/" . $file_name);


        $rotate = imagerotate($source, $degrees, 0);

        imagejpeg($rotate, "myUpdateImage.jpeg");
        */

        //$archivoImgName = $_FILES["file"]["name"];
        $archivoImgName = $file_name;

        //$archivoImg   = $_FILES["file"]["tmp_name"];
        $archivoImg   = $file_name;

        //$archivoImg = "https://iescelia.org/padresuarez360/public/img/zones/images/Plano%20Museo%201%20(3).png";

        /*
        echo ($archivoImgName);
        echo ("<br>");
        echo ("=> ");
        echo ($archivoImg);
        */

        //Verifico la extension de la Imagen 
        $explode        = explode('.', $archivoImgName);
        $extension      = array_pop($explode);
        $grado_90 = -90;

        /*
        echo ("<br>");
        echo ("extension => " . $extension);
        */

        if ($extension == "png" || $extension == "PNG") {
            // Imagen normal
            $imgpngTwo =  imagecreatefrompng("img/zones/images/" . $file_name);
            //echo ($imgpngTwo);
            $rotatepng = imagerotate($imgpngTwo, $grado_90, 0);
            imagepng($rotatepng, "img/zones/images/" . $archivoImgName);

            // Miniatura
            $imgpngTwo =  imagecreatefrompng("img/zones/miniatures/" . $file_name);
            $rotatepng = imagerotate($imgpngTwo, $grado_90, 0);
            imagepng($rotatepng, "img/zones/miniatures/" . $archivoImgName);

        } elseif ($extension == "jpg" || $extension == "jpeg") {
            // Imagen normal
            $imgjpgOne  = imagecreatefromjpeg("img/zones/images/" . $file_name);
            $rotatejpg  = imagerotate($imgjpgOne, $grado_90, 0);
            imagejpeg($rotatejpg, "img/zones/images/" . $archivoImgName);


            // Miniatura
            $imgjpgOne  = imagecreatefromjpeg("img/zones/miniatures/" . $file_name);
            $rotatejpg  = imagerotate($imgjpgOne, $grado_90, 0);
            imagejpeg($rotatejpg, "img/zones/miniatures/" . $archivoImgName);


        }


        return redirect()->route('zone.index');

    }
}
