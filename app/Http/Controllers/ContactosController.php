<?php

namespace App\Http\Controllers;

use App\Helpers\EnviarEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ContactosController extends Controller
{
    public function enviarEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'nullable',
            'email' => 'required|email',
            'assunto' => 'nullable',
            'mensagem' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json(['erro' => $validator->errors()]);
        }

        $status = EnviarEmail::enviar($request);
        
        switch($status)
        {
            case true:
                return ['mensagem' => 'Email enviado!'];
                break;
            case false: 
                return ['erro' => 'Ocorreu um erro. Por favor tente novamente.'];
        }
    }
}
