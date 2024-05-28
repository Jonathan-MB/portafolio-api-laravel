<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{

    // Tipos de usuarios
    const rolMaster = 1;
    const rolAdmin = 2;
    const rolUsuario = 3;



    // Controlador Index de User -------------------------------------------------------------------------------------
    public function index()
    {
        try {
            $currentUser = Auth::user();
            if ($currentUser->rol_id == self::rolAdmin || $currentUser->rol_id == self::rolAdmin) {
                $users = User::select('id', 'name', 'email', 'rol_id')->get();

                if ($users->isEmpty()) {
                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'No hay usuarios'
                        ]
                    );
                } else {
                    return response()->json(
                        [
                            'status' => true,
                            'users' => $users
                        ]
                    );
                }
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'No autorizado'
                    ],
                    403
                );
            }
        } catch (\Throwable $ex) {
            Log::error('Error en UserController@index: ' . $ex->getMessage());
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor'
                ],
                500
            );
        }
    }

    // Controlador Show de User (busca)-------------------------------------------------------------------------------
    public function show($id)
    {
        try {
            $currentUser = Auth::user();
            $user = User::select('id', 'name', 'email', 'rol_id')->find($id);

            if ($user) {
                if ($currentUser->rol_id == self::rolAdmin || $currentUser->rol_id == self::rolMaster) {
                    return response()->json([
                        'status' => true,
                        'user' => $user
                    ]);
                } else {
                    return response()->json(
                        [
                            'status' => false,
                            'message' => 'No autorizado'
                        ],
                        403
                    );
                }
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Usuario no encontrado'
                    ],
                    404
                );
            }
        } catch (\Throwable $ex) {
            Log::error('Error en UserController@show: ' . $ex->getMessage());
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor'
                ],
                500
            );
        }
    }

    // Controlador Update de User solo para uso propio (Actualiza usuario) -------------------------------------------------------------------
    public function update(Request $request, $id)
    {
        try {
            $currentUser = Auth::user();
            $user = User::select('id', 'name', 'email', 'update_at')->findOrFail($id);

            if ($currentUser->id == $user->id) {
                $validateUser = $request->validate([
                    'name' => 'required|string|max:45',
                    'email' => 'required|max:45|email|unique:users,email,' . $id . ',id',
                ]);

                $user->update($validateUser);

                return response()->json(
                    [
                        'status' => true,
                        'message' => 'Usuario actualizado exitosamente',
                        'user' => $user
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'No autorizado'
                    ],
                    403
                );
            }
        } catch (\Throwable $ex) {
            Log::error('Error en UserController@update: ' . $ex->getMessage());
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor',
                    'error' => $ex->getMessage()
                ],
                500
            );
        }
    }

    // Controlador UpdateAdmin de User solo para Admin (Actualiza usuario) -------------------------------------------------------------------
    public function updateAdmin(Request $request, $id)
    {
        try {
            $currentUser = Auth::user();
            $user = User::select('id', 'name', 'email', 'update_at')->findOrFail($id);

            if (($currentUser->rol_id == self::rolAdmin and $user->rol_id != self::rolAdmin and $user->rol_id != self::rolMaster) || $currentUser->rol_id == self::rolMaster) {
                $validateUser = $request->validate([
                    'name' => 'required|string|max:45',
                    'email' => 'required|max:45|email|unique:users,email,' . $id . ',id',
                ]);

                $user->update($validateUser);

                return response()->json(
                    [
                        'status' => true,
                        'message' => 'Usuario actualizado exitosamente',
                        'user' => $user
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'No autorizado'
                    ],
                    403
                );
            }
        } catch (\Throwable $ex) {
            Log::error('Error en UserController@update: ' . $ex->getMessage());
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor',
                    'error' => $ex->getMessage()
                ],
                500
            );
        }
    }


    // Controlador Destroy de User (Elimina usuario) ------------------------------------------------------------------
    public function destroy($id)
    {
        try {
            $currentUser = Auth::user();
            $user = User::find($id);

            if ($user) {
                if ($currentUser->rol_id == $user->id) {
                    $user->delete();
                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'Usuario eliminado exitosamente'
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => false,
                            'message' => 'No autorizado'
                        ],
                        403
                    );
                }
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Usuario no encontrado'
                    ],
                    404
                );
            }
        } catch (\Throwable $ex) {
            Log::error('Error en UserController@destroy: ' . $ex->getMessage());
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor',
                    'error' => $ex->getMessage()
                ],
                500
            );
        }
    }




    // Controlador Destroy de User (Elimina usuario Administrador) ------------------------------------------------------------------
    public function destroyAdmin($id)
    {
        try {
            $currentUser = Auth::user();
            $user = User::find($id);

            if ($user) {
                if (($currentUser->rol_id == self::rolAdmin and $user->rol_id != self::rolAdmin and $user->rol_id != self::rolMaster) || $currentUser->rol_id == self::rolMaster) {
                    $user->delete();
                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'Usuario eliminado exitosamente'
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => false,
                            'message' => 'No autorizado'
                        ],
                        403
                    );
                }
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Usuario no encontrado'
                    ],
                    404
                );
            }
        } catch (\Throwable $ex) {
            Log::error('Error en UserController@destroy: ' . $ex->getMessage());
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor',
                    'error' => $ex->getMessage()
                ],
                500
            );
        }
    }
}
