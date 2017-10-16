<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'message' => 'Usuário autenticado com sucesso.',
                'data' => Auth::user(),
            ]);
        } else {
            return response()->json(['error' => 'Falha na autenticação.'], 401);
        }
    }

//    public function login(Request $request)
//    {
//        $credentials = $request->only('cpf', 'password'); // Define quais campos pegará do request
//
//        $temp = [
//            "cpf" => "60457801751",
//            "password" => "bwf2LXrTOwvlGCu0MKJX971t5LjhQIM22pMJmOz4Qn4="
//        ];
//
//        try {
//            $token = JWTAuth::attempt($temp); // Método para autenticação do Eloquent
//        } catch (JWTException $ex) {
//            return response()->json(["error" => "could_not_create_token", "msg" => $ex->getMessage()], 500);
//        }
//
//        if (!$token) {
//            return response()->json(["error" => "invalid_credentials"], 401);
//        }
//
//        return response()->json(compact('token'));
//    }
}