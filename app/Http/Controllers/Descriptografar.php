<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Constants\BASE64;

class Descriptografar extends Controller
{
    public function descriptografar(Request $request){
        $texto = $request['texto_criptografado'];

        $textoDec = $this->base64AlphabetToDec($texto);
        $textoBin = $this->decToBin($textoDec);
        $texto6by6 = $this->break6by6($textoBin);
        $textoDec = $this->binToDec($texto6by6);
        $textoCriptografado = $this->decToBase64Alphabet($textoDec);
        dd($texto, $textoHex, $textoBin, $texto6by6, $textoDec, $textoCriptografado);
        return view('/welcome', compact('textoCriptografado'));
    }

    private function base64AlphabetToDec($textoCriptografado){
        $arrayDeBase84 = str_split($textoCriptografado);
        $tabelaBASE64 = array_flip(BASE64::TABLE);
        foreach($arrayDeBase84 as $key => $caractere64){
            if($caractere64 === "="){
                continue;
            }else{
                $arrayDeDec[$key] = $tabelaBASE64[$caractere64];
            }
        }
        return $arrayDeDec;
    }

    public function decToBin($arrayDeDec){
        foreach($arrayDeDec as $key => $itemDec){
            $arrayDeBin[$key] =  base_convert($itemDec, 10, 2);
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
            if(strlen($sequencia) < 6){
                $sequenciasDe6[$key] = null;
            }
        }

        return $sequenciasDe6;
    }

    private function break8by8($sequenciasDe6){
        $textoBin = '';
        foreach($sequenciasDe6 as $sequencia){ //TODO: QUEBRAR DE 8 EM 8
            $textoBin .= $caractere;
        }

        $sequenciasDe6 = str_split($textoBin, 6);

        foreach($sequenciasDe6 as $key => $sequencia){
            if(strlen($sequencia) < 6){
                $sequenciasDe6[$key] = null;
            }
        }

        return $sequenciasDe6;
    }

    private function binToHex($sequenciasDe6){
        foreach($sequenciasDe6 as $sequencia){
            $arrayDeDec = base_convert($itemDec, 2, 10);
        }
    }
}
