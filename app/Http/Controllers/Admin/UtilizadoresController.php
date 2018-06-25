<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Interfaces\IUtilizadorRepository;

class UtilizadoresController extends Controller
{
    public $utilizadorRepo;

    public function __construct(IUtilizadorRepository $utilizador) 
    {
        $this->utilizadorRepo = $utilizador;
    }


    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json(['erro' => 'Por favor, preencha ambos os campos.'], 401);
        }
        
        $credenciais = [
            'email' => $request['email'], 
            'password' => $request['password']
        ];
        
        try {
            // verify the credentials and create a token for the user; if everything works out, the user is logged in and the token is created
            if (! $token = JWTAuth::attempt($credenciais)) {
                return response()->json(['erro' => 'invalido'], 401);
            }
        } 
        catch (JWTException $e) {
            // something went wrong
            return response()->json(['erro' => 'token'], 500);
        }

        // if no errors are encountered we can return a JWT
        return response()->json([
            'token' => $token,
            'utilizador' => Auth::user()
        ], 200);
    }


    public function logout(Request $request) {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json([], 200);
    }



    public function check(Request $request)
    {
        $autenticado = Auth::check();
        return $autenticado ? ['estado' => true] : ['estado' => false];
    }

    public function getUtilizadorAutenticado(Request $request)
    { 
        $utilizadorAutenticado = $this->utilizadorRepo->get(Auth::user()->id, ['cargo']);
        return response()->json(['utilizador' => $utilizadorAutenticado]);
    }


    public function utilizadores(Request $request)
    {
        return ['utilizadores' => $this->utilizadorRepo->getAll()];
    }

    public function ver(Request $request)
    {
        $utilizador = $this->utilizadorRepo->get($request['id'], ['cargo']);

        return ['utilizador' => $utilizador];
    }

    public function criar(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6',
            'role_id' => 'required'
        ]);

        if($validator->fails() ) 
        {
            return ['erro' => $validator->errors()];
        }

        $dados = [
            'nome' => $request['nome'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'role_id' => $request['role_id']
        ];

        $this->utilizadorRepo->criar($dados);

        return ['mensagem' => 'Utilizador criado com sucesso!'];
    }


    public function editar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
            'email' => 'required|email',
            'cargo' => 'required',
            'password' => 'required',
            'nova_password' => 'confirmed|nullable',
            'nova_password_confirmation' => 'nullable'
        ]);

        if($validator->fails() ) 
        {
            return ['erro' => $validator->errors()];
        }

        $utilizador = $this->utilizadorRepo->get($request['id']);

        $dados = $request->except('_token','password', 'nova_password', 'nova_password_confirmation', 'cargo');
        $dados['role_id'] = $request['cargo']['id'];
        if(!is_null($request['nova_password']))
            $dados['password'] = Hash::make($request['nova_password']);

            $this->utilizadorRepo->editar($utilizador->id, $dados);

        return ['mensagem' => 'Utilizador editado com sucesso!'];
    }


    public function apagar(Request $request)
    {
        if(is_null($request['id'])) 
        {
            return ['erro' => 'redirecionar'];
        }

        $utilizador = $this->utilizadorRepo->get($request['id']);

        if(is_null($utilizador)) 
        {
            return ['erro' => 'redirecionar'];
        }

        $this->utilizadorRepo->apagar($utilizador->id);

        return ['mensagem' => 'Utilizador removido com sucesso!'];
    }
}
