<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Rol;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RolController extends Controller
{
    // Tipos de usuario Bases
    const rolMaster = 1;
    const rolAdmin = 2;
    const rolUsuario = 3;



    // Controllador Index de Rols -------------------------------------------------------------------------------------
    public function index()
    {
        try {

            // Verificar Rol Admin
            $rols = Rol::select('id', 'rol_name')->get();

            // No hay roles en BD
            if ($rols->isEmpty()) {
                return response()->json(
                    [
                        'status' => true,
                        'message' => 'No hay rols'
                    ]
                );

                // Retorna roles de la Bd
            } else {
                return response()->json(
                    [
                        'status' => true,
                        'rols' => $rols
                    ]
                );
            }
        } catch (\Throwable $ex) {

            //registro error Log
            Log::error('Error en RolController@index ' . $ex->getMessage());

            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor'
                ],
                500
            );
        }
    }




    // Controllador Store de Rols (Crea rol) ------------------------------------------------------------------------
    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            if ($user->rol_id == self::rolAdmin || $user->rol_id == self::rolMaster) {

                //validaciones de la informacion recibida por Json
                $validateRol = $request->validate(
                    [
                        'rol_name' => 'required|string|max:45|unique:rols,rol_name',
                    ]
                );

                $rol = Rol::create($validateRol);

                return response()->json(
                    [
                        'status' => true,
                        'message' => 'rol creado exitosamente',
                        'rol' => $rol
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


            // Catch errores
        } catch (Exception $ex) {
            // Registra  error
            Log::error('Error en RolController@store ' . $ex->getMessage());

            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor'
                ],
                500
            );
        }
    }



    // Controllador Show de Rols (busca)-------------------------------------------------------------------------------
    public function show($id)
    {
        try {

            $rol = Rol::select('id', 'rol_name', 'updated_at')->find($id);
            if ($rol) {

                return response()->json([
                    'status' => true,
                    'rol' => $rol
                ]);
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Rol no encontrada'
                    ],
                    404
                );
            }

            // Catch errores
        } catch (\Throwable $ex) {

            //registro error Log
            Log::error('Error en RolController@show: ' . $ex->getMessage());

            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor'
                ],
                500
            );
        }
    }




    // Controllador update de Rols (Actualiza roles) -------------------------------------------------------------------
    public function update(Request $request, $id)
    {

        try {
            $user = Auth::user();
            $rol = Rol::findOrFail($id);
            if ($rol) {
                if (($user->rol_id == self::rolAdmin and $rol->id != 1 and $rol->id != 2) || $user->rol_id == self::rolMaster) { //Permite modificar solos otros que no sean los 2 iniciales
                    //validaciones de la informacion recibida por Json
                    $validateRol = $request->validate([

                        'rol_name' => 'required|string|max:45|unique:rols,rol_name,' . $id . ',id'

                    ]);

                    $rol->update($validateRol);

                    return response()->json(
                        [
                            'message' => 'Rol Actualizado exitosamente',
                            'rol' => $rol
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
                        'message' => 'Rol no encontrado'
                    ],
                    404
                );
            }

            // Catch errores
        } catch (\Throwable $ex) {

            //registro error Log
            Log::error('Error en RolController@update: ' . $ex->getMessage());

            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor'
                ],
                500
            );
        }
    }




    // Controllador Destroy de Rols (Elimina  rol) ------------------------------------------------------------------
    public function destroy($id)
    {
        try {
            $rol = Rol::find($id);
            $user = Auth::user();

            if ($rol) {

                //Permiso para eliminar 
                if (($user->rol_id == self::rolAdmin and $rol->id != 1 and $rol->id != 2) || $user->rol_id == self::rolMaster) {

                    //Elimina rol
                    $rol->delete();

                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'Rol eliminado exitosamente'
                        ],
                        200
                    );
                } else {

                    //Respuesta NO autorizado
                    return response()->json(
                        [
                            'status' => false,
                            'message' => 'No autorizado'
                        ],
                        403
                    );
                }
            } else {

                //Respuesta  No existe rol
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Rol no encontrado'
                    ],
                    404
                );
            }
        } catch (\Throwable $ex) {

            //registro error Log
            Log::error('Error en RolController@destroy ' . $ex->getMessage());

            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor'
                ],
                500
            );
        }
    }
}
