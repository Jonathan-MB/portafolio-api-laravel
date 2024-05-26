<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\ElseIf_;
use Throwable;
use Carbon\Carbon;

class AuthController extends Controller
{



    // Controllador Store de User (Crea Ususario) ------------------------------------------------------------------------
    public function store(Request $request)
    {
        try {
            //validaciones de la informacion recibida por Json
            $validateUser = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|max:45',
                    'email' => 'required|email|unique:users,email|max:45',
                    'password' => 'required|string|min:5'

                ]
            );

            if ($validateUser->fails()) {
                return response()->json(
                    [
                        'status' => false,
                        'menssage' => 'Error en validación',
                        'errors' => $validateUser->errors()
                    ],
                    401
                );
            } else {

                // Crea usuario
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                
                // // Genera token autenticacion
                $token = $user->createToken('api')->plainTextToken;
                
                
                $userToken = $user->tokens()->latest()->first();
                
                // Establece fecha vencimiento token
                $userToken->expires_at = Carbon::now()->addHour();
                $userToken->save();
                


                return response()->json(
                    [
                        'status' => true,
                        'message' => 'Usuario creado exitosamente',
                        'token' => $token,
                        'typeToken'=> 'Bearer',
                        'UserInfo' => [
                            'name' => $user->name,
                            'email' => $user->email,

                        ]
                    ],
                    200
                );
            }
        } catch (\Throwable $ex) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $ex->getMessage()
                ],
                500
            );
        }
    }




    // Controllador Login de User (loguea al usuario) -------------------------------------------------------------------
    public function login(Request $request)
    {
        try {
            // Valida datos entrada
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);


            $user = User::where('email', $request->input('email'))->first();
            if (!$user) {

                return response()->json(
                    [
                        'status' => false,
                        'menssage' => 'Usuario no registrado',
                    ],
                    401
                );
            } else if (!Hash::check($request->password, $user->password)) {
                return response()->json(
                    [
                        'status' => false,
                        'menssage' => 'contraseña incorrectas',
                    ],
                    401
                );
            } else {

                // elimina tokens anteriores
                $user->tokens()->delete();

                // // Genera token autenticacion
                $token = $user->createToken('api')->plainTextToken;


                $userToken = $user->tokens()->latest()->first();

                // Establece fecha vencimiento token
                $userToken->expires_at = Carbon::now()->addHour();
                $userToken->save();

                $rolName = $user->rol->rol_name;

                return response()->json(
                    [
                        'status' => true,
                        'message' => 'Usuario creado exitosamente',
                        'token' => $token,
                        'typeToken'=> 'Bearer',
                        'UserInfo' => [
                            'name' => $user->name,
                            'email' => $user->email,
                            'rol' => $rolName
                        ]
                    ],
                    200
                );
            }
        } catch (\Throwable $ex) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $ex->getMessage()
                ],
                500
            );
        }
    }
}
