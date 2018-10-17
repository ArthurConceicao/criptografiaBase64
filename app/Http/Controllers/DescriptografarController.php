<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Constants\BASE64;

class DescriptografarController extends Controller
{
    public function descriptografar(Request $request){
        $texto = $request['texto_criptografado'];
        $textoCriptografado = $request['texto_criptografado'];
        $textoDescriptografado = '';
        $textoDec64 = $this->base64AlphabetToDec($texto);
        $textoBin = $this->decToBin($textoDec64);
        $texto6by6 = $this->break6by6($textoBin);
        $texto8by8 = $this->break8by8($texto6by6);
        $textoDec = $this->binToDec($texto8by8);
        $textoDescriptografado = $this->decToAscii($textoDec);
//        dd($texto, $textoDec64, $textoBin, $texto6by6,$texto8by8, $textoDec, $textoDescriptografado);
        return view('/welcome', compact('textoCriptografado', 'textoDescriptografado'));
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
            $arrayDeBin[$key] =  sprintf("%06d", base_convert($itemDec, 10, 2));
        }
        return $arrayDeBin;
    }

    private function break6by6($arrayDeBin){
        $textoBin = '';
        foreach($arrayDeBin as $caractere){
            $textoBin .= $caractere;
        }

        $sequenciasDe6 = str_split($textoBin, 6);

        return $sequenciasDe6;
    }

    private function break8by8($sequenciasDe6){
        $textoBin = '';
        foreach($sequenciasDe6 as $sequencia){ //TODO: QUEBRAR DE 8 EM 8
            $textoBin .= $sequencia;
        }

        $sequenciasDe8 = str_split($textoBin, 8);

        foreach($sequenciasDe8 as $key => $sequencia){
            if(strlen($sequencia) < 8){
                array_pop($sequenciasDe8);
            }
        }

        return $sequenciasDe8;
    }

    private function binToDec($sequenciasDe8){
        foreach($sequenciasDe8 as $key => $sequencia){
            $arrayDeDec[$key] = base_convert($sequencia, 2, 10);
        }
        return $arrayDeDec;
    }

    private function decToAscii($arrayDeDec){
        $textoDescriptografado = '';
        foreach($arrayDeDec as $key => $itemDec){
            $textoDescriptografado .= chr($itemDec);
        }
        return $textoDescriptografado;
    }
}
