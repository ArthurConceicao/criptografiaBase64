<?php
/**
 * Created by PhpStorm.
 * User: Arthur
 * Date: 15/10/2018
 * Time: 21:18
 */

namespace App\Http\Controllers;


use http\Env\Request;

class Base64Controller extends Controller
{
    public function index(){
        $textoCriptografado = '';
        return view('/', compact('textoCriptografado'));
    }

    public function criptografar(Request $request){
        $texto = $request['texto_original'];

        $texto = asciiToHex($texto);
        $texto = hexToBin($texto);
        $texto = break6by6($texto);
        $texto = binToDec($texto);
        $textoCriptografado = decToASCII($texto);

        return view('/', compact('textoCriptografado'));
    }

    private function asciiToHex(string $texto, &$offset) {
        $arrayDeCaracteres = str_split($texto);
        foreach($arrayDeCaracteres as $chave => $caractere){
            $code = ord(substr($caractere, $offset,1));
            if ($code >= 128) {        //otherwise 0xxxxxxx
                if ($code < 224) $bytesnumber = 2;                //110xxxxx
                else if ($code < 240) $bytesnumber = 3;        //1110xxxx
                else if ($code < 248) $bytesnumber = 4;    //11110xxx
                $codetemp = $code - 192 - ($bytesnumber > 2 ? 32 : 0) - ($bytesnumber > 3 ? 16 : 0);
                for ($i = 2; $i <= $bytesnumber; $i++) {
                    $offset ++;
                    $code2 = ord(substr($caractere, $offset, 1)) - 128;        //10xxxxxx
                    $codetemp = $codetemp*64 + $code2;
                }
                $code = $codetemp;
            }
            $offset += 1;
            if ($offset >= strlen($caractere)) $offset = -1;
            $arrayDeHex[key] = $caractere;
        }

        return $arrayDeHex;
    }

    private function hexToBin($arrayDeHex){
        foreach($arrayDeHex as $key => $itemHex){
            $arrayDeBin[$key] = base_convert($itemHex, 16, 2);
        }
        return $arrayDeHex;
    }

    private function break6by6($array){
        $textoBin = '';
        foreach($array as $caractere){
            $textoBin .= $caractere;
        }

        return str_split($textoBin, 6);
    }

    private function binToDec($sequenciasDe6){
        foreach ($sequenciasDe6 as $sequenciaDe6){
            $arrayDeDec = base_convert($sequenciaDe6, 16, 2);
        }

        return $arrayDeDec;
    }

    private function decToASCII($arrayDeDec){
        foreach($arrayDeDec as $key => $itemDec){
            $arrayDeASCII[$key] = chr($itemDec);
        }
        while(count($arrayDeDec) % 3 != 0){
            array_push($arrayDeASCII[count($arrayDeASCII)], '=');
        }
        return $arrayDeASCII;
    }

}