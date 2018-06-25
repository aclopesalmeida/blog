<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;


class GerirImagens 
{
    public static function redimensionar($ficheiro)
    { 
        $imagem = Image::make($ficheiro);
        if(getImageSize($ficheiro) > 850) {
            $imagem->resize(850, null, function($constraint) {
                $constraint->aspectRatio();
            });
        }
        return $imagem;
    }


    public static function guardar($ficheiro)
    {
        try {
            $nomeFicheiro = 'img ' . time() . '_' . $ficheiro->getClientOriginalName();
            $localizacao = public_path('\imagens\\');
            $ficheiro = self::redimensionar($ficheiro);
            $ficheiro->save($localizacao . $nomeFicheiro);
            
            return $nomeFicheiro;   
        }
        catch(Exception $e)
        {
            return false;
        }
   
    }


    public static function Apagar(string $nomeImagem)
    {
        $ficheiro = '/imagens/' . $nomeImagem;
        if(File::exists($ficheiro))
        {
            File::delete($ficheiro);
        }
    }
}