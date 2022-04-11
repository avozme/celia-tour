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

        echo ($archivoImgName);
        echo ("<br>");
        echo ("=> ");
        echo ($archivoImg);

        //Verifico la extension de la Imagen 
        $explode        = explode('.', $archivoImgName);
        $extension      = array_pop($explode);
        $grado_90 = -90;

        echo ("<br>");
        echo ("extension => " . $extension);


        if ($extension == "png" || $extension == "PNG") {
            $imgpngTwo =  imagecreatefrompng("img/zones/images/" . $file_name);
            echo ($imgpngTwo);
            $rotatepng = imagerotate($imgpngTwo, $grado_90, 0);
            imagepng($rotatepng, "img/zones/images/" . $archivoImgName);
        } elseif ($extension == "jpg" || $extension == "jpeg") {
            $imgjpgOne  = imagecreatefromjpeg("img/zones/images/" . $file_name);
            $rotatejpg  = imagerotate($imgjpgOne, $grado_90, 0);
            imagejpeg($rotatejpg, "img/zones/images/" . $archivoImgName);
        }elseif ($extension == "BMP" || $extension == "jpeg") {
            $imgBMP   = imagecreatefrombmp("img/zones/images/" . $file_name);
            $rotategif  = imagerotate($imgBMP, $grado_90, 0);
            imagegif($rotategif, "img/zones/images/" . $archivoImgName);
        }elseif ($extension == "WebP" || $extension == "webp") {
            $imgif   = imagecreatefromwebp("img/zones/images/" . $file_name);
            $rotategif  = imagerotate($imgif, $grado_90, 0);
            imagegif($rotategif, "img/zones/images/" . $archivoImgName);
        }else {
            $imgif   = imagecreatefromgif("img/zones/images/" . $file_name);
            $rotategif  = imagerotate($imgif, $grado_90, 0);
            imagegif($rotategif, "img/zones/images/" . $archivoImgName);
        }





        return redirect()->route('zone.index');

    }
}
