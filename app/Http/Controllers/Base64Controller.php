<?php
/**
 * Created by PhpStorm.
 * User: Arthur
 * Date: 15/10/2018
 * Time: 21:18
 */

namespace App\Http\Controllers;


class Base64Controller extends Controller
{
    public function index(){
        $textoCriptografado = '';
        return view('/welcome', compact('textoCriptografado'));
    }

    public function criptografar(\Illuminate\Http\Request $request){
        $texto = $request['texto_original'];

        $textoASCII = iconv("UTF-8", "CP437", $texto);
        $textoHex = $this->asciiToHex($textoASCII);
        $textoBin = $this->hexToBin($textoHex);
        $texto6by6 = $this->break6by6($textoBin);
        $textoDec = $this->binToDec($texto6by6);
        $textoCriptografado = $this->decToASCII($textoDec, $textoBin);
dd($textoASCII, $textoHex, $textoBin, $texto6by6, $textoDec, $textoCriptografado);
        return view('/welcome', compact('textoCriptografado'));
    }

    private function asciiToHex(string $ascii) {
        $arrayASCII = str_split($ascii);;
        foreach ($arrayASCII as $key => $value) {
            $byte = strtoupper(dechex(ord($ascii{$key})));
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

        return str_split($textoBin, 6);
    }

    private function binToDec($sequenciasDe6){
        foreach ($sequenciasDe6 as $key => $sequenciaDe6){
            $arrayDeDec[$key] = base_convert($sequenciaDe6, 2, 10);
        }

        return $arrayDeDec;
    }

    private function decToASCII($arrayDeDec, $arrayDeBin){
        foreach($arrayDeDec as $key => $itemDec){
            $arrayDeASCII[$key] = chr(intval(7));
        }
        for($i = 0; $i <= 150; $i++){
            print_r(chr($i));
        }die;
        $padding = "=";
        $textBin = "";
        foreach($arrayDeBin as $bin){
            $textBin .= $bin;
        }

        switch(strlen($textBin) % 3){
            case 1:
                array_push($arrayDeASCII, $padding . $padding );
                break;
            case 2:
                array_push($arrayDeASCII, $padding);
                break;
        }
        return $arrayDeASCII;
    }

}