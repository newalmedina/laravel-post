<?php

/**
 * Created by PhpStorm.
 * User: toni
 * Date: 28/10/2015
 * Time: 10:03
 */

namespace App\Services;

class UtilsServices
{
    public static function makeTextShort($text=null, $lenght )
    {
         // Verifica si el text tiene más de 10 caracteres
    if (strlen($text) > $lenght) {
        // Recorta el text a un máximo de $lenght caracteres
        $textShort = substr($text, 0, $lenght)."...";
    } else {
        // Si el text tiene 10 caracteres o menos, no lo recorta
        $textShort = $text;
    }
    
    return $textShort;
    }
  
}
