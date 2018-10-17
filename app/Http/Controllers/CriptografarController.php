<?php
/**
 * Created by PhpStorm.
 * User: Arthur
 * Date: 15/10/2018
 * Time: 21:18
 */

namespace App\Http\Controllers;

use App\Constants\BASE64;
use Illuminate\Http\Request;

class CriptografarController extends Controller
{
    public function index(){
        $textoCriptografado = '';
        $textoDescriptografado = '';

        return view('/welcome', compact('textoCriptografado', 'textoDescriptografado'));
    }

    public function criptografar(Request $request){


        $texto = $request['texto_original'];
        $textoCriptografado = '';
        $textoDescriptografado = $request['texto_original'];
        $textoHex = $this->asciiToHex($texto);
        $textoBin = $this->hexToBin($textoHex);
        $texto6by6 = $this->break6by6($textoBin);
        $textoDec = $this->binToDec($texto6by6);
        $textoCriptografado = $this->decToBase64Alphabet($textoDec);
dd($texto, $textoHex, $textoBin, $texto6by6, $textoDec, $textoCriptografado);
        return view('/welcome', compact('textoCriptografado', 'textoDescriptografado'));
    }

    private function asciiToHex(string $texto) {
        $arrayASCII = str_split($texto);;
        foreach ($arrayASCII as $key => $value) {
            $byte = strtoupper(dechex(ord($value)));
            $byte = str_repeat('0', 2 - strlen($byte)).$byte;
            $arrayDeHex[$key] = $byte;
        }
        return $arrayDeHex;
    }

    private function hexToBin($arrayDeHex){
        foreach($arrayDeHex as $key => $itemHex) {
            $arrayDeBin[$key] = sprintf("%08d", base_convert($itemHex, 16, 2));
        }
        return $arrayDeBin;
    }

    private function break6by6($arrayDeBin){
        $textoBin = '';
        foreach($arrayDeBin as $caractere){
            $textoBin .= $caractere;
        }

        $sequenciasDe6 = str_split($textoBin, 6);

        foreach($sequenciasDe6 as $key => $sequencia){
            $sequenciasDe6[$key] = str_pad($sequencia, 6, 0);
        }

        return $sequenciasDe6;
    }

    private function binToDec($sequenciasDe6){
        foreach ($sequenciasDe6 as $key => $sequenciaDe6){
            $arrayDeDec[$key] = base_convert($sequenciaDe6, 2, 10);
        }

        return $arrayDeDec;
    }

    private function decToBase64Alphabet($arrayDeDec){
        foreach($arrayDeDec as $key => $itemDec){
            $arrayDeBASE64[$key] = BASE64::TABLE[$itemDec];

        }
        $padding = "=";
        $text64 = "";
        foreach($arrayDeBASE64 as $caractere64){
            $text64 .= $caractere64;
        }

        switch(strlen($text64) % 4){
            case 1:
                $text64 .= $padding . $padding . $padding;
                break;
            case 2:
                $text64 .= $padding . $padding;
                break;
            case 3:
                $text64 .= $padding;
                break;
        }
        return $text64;
    }

}