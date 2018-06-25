<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Helpers\EnviarEmail;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        return view('contactos');
    }

    public function postIndex(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'string|nullable',
            'email' => 'required|email',
            'mensagem' => 'required'
        ]);

        if($validator->fails())
            return ['error' => $validator->messages()];
        

        $envio = EnviarEmail::enviar($request);

        return ['status' => $envio];


    }
}
