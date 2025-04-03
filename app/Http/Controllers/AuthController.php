<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Unit;

class AuthController extends Controller
{
    public function unauthorized()
    {
        return response()->json([
            'error' => 'Usuário não autorizado.'
        ], 401);
    }

    public function register(Request $req)
    {
        $array = ['error' => ''];
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'cpf' => 'required|digits:11|unique:users,cpf',
            'password' => 'required',
            'password_confirm' => 'required|same:password'
        ]);

        if (!$validator->fails()) {
            $name = $req->input(('name'));
            $email = $req->input(('email'));
            $cpf = $req->input(('cpf'));
            $password = $req->input(('password'));

            $newUser = new User();
            $newUser->name = $name;
            $newUser->email = $email;
            $newUser->cpf = $cpf;
            $newUser->password = bcrypt($password);
            $newUser->save();

            $token = Auth::attempt([
                'cpf' => $cpf,
                'password' => $password
            ]);

            if (!$token) {
                $array['error'] = "Ocorreu um erro.";
                return $array;
            }

            $array['token'] = $token;

            $user = Auth::login($newUser);
            $array['user'] = $user;

            $properties = Unit::select(['id', 'name'])
                ->where('id_owner', $user['id'])
                ->get();

            $array['user']['properties'] = $properties;
        } else {
            $array['error'] = $validator->errors()->first();
            return $array;
        }

        return $array;
    }

    public function login(Request $req)
    {
        $array = ['error' => ''];
        $validator = Validator::make($req->all(), [
            'cpf' => 'required|digits:11',
            'password' => 'required'
        ]);

        if (!$validator->fails()) {
            $cpf = $req->input('cpf');
            $password = $req->input('password');

            $token = Auth::attempt([
                'cpf' => $cpf,
                'password' => $password
            ]);

            if (!$token) {
                $array['error'] = 'CPF e/ou senha inválidos.';
                return $array;
            }

            $array['token'] = $token;
            $user = Auth::user();
            $array['user'] = $user;
            $properties = Unit::select(['id', 'name'])
                ->where('id_owner', $user['id'])
                ->get();
            $array['user']['properties'] = $properties;
        } else {
            $array['error'] = $validator->error()->first();
            return $array;
        }

        return $array;
    }

    public function validateToken()
    {
        $array = ['error' => ''];

        $user = Auth::user();
        $array['user'] = $user;

        $properties = Unit::select(['id', 'name'])
            ->where('id_owner', $user['id'])
            ->get();

        $array['user']['properties'] = $properties;

        return $array;
    }

    public function logout()
    {
        $array = ['error' => ''];
        Auth::logout();
        return $array;
    }
}
