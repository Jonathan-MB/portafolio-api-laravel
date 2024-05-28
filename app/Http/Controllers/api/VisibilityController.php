<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Visibility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VisibilityController extends Controller
{


    // Tipos de usuario Bases
    const rolMaster = 1;
    const rolAdmin = 2;
    const rolUsuario = 3;



    // Controlador Index de Visibilities -------------------------------------------------------------------------------------
    public function index()
    {
        try {
            $user = Auth::user();
            if ($user->rol_id == self::rolAdmin || $user->rol_id == self::rolMaster) {
                $visibilities = Visibility::select('id', 'visibility_name')->get();

                if ($visibilities->isEmpty()) {
                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'No hay visibilidades'
                        ]
                    );
                } else {
                    return response()->json(
                        [
                            'status' => true,
                            'visibilities' => $visibilities
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
            Log::error('Error en VisibilityController@index: ' . $ex->getMessage());
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor'
                ],
                500
            );
        }
    }



    // Controlador Store de Visibilities (Crea visibilidad) ------------------------------------------------------------------------
    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            if ($user->rol_id == self::rolAdmin || $user->rol_id == self::rolMaster) {
                // Validaciones de la información recibida por JSON
                $validateVisibility = $request->validate([
                    'visibility_name' => 'required|string|max:45|unique:visibilities,visibility_name',
                ]);

                $visibility = Visibility::create($validateVisibility);

                return response()->json(
                    [
                        'status' => true,
                        'message' => 'Visibilidad creada exitosamente',
                        'visibility' => $visibility
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
            Log::error('Error en VisibilityController@store: ' . $ex->getMessage());
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

    // Controlador Show de Visibilities (busca)-------------------------------------------------------------------------------
    public function show($id)
    {
        try {


            $visibility = Visibility::select('id', 'visibility_name', 'updated_at')->find($id);

            if ($visibility) {
                return response()->json([
                    'status' => true,
                    'visibility' => $visibility
                ]);
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Visibilidad no encontrada'
                    ],
                    404
                );
            }
        } catch (\Throwable $ex) {
            Log::error('Error en VisibilityController@show: ' . $ex->getMessage());
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor'
                ],
                500
            );
        }
    }




    // Controlador Update de Visibilities (Actualiza visibilidades) -------------------------------------------------------------------
    public function update(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $visibility = Visibility::findOrFail($id);

            if ($visibility) {
                if (($user->rol_id == self::rolAdmin && $visibility->id != 1 && $visibility->id != 2) || $user->rol_id == self::rolMaster) {
                    // Validaciones de la información recibida por JSON
                    $validateVisibility = $request->validate([
                        'visibility_name' => 'required|string|max:45|unique:visibilities,visibility_name,' . $id . ',id'
                    ]);

                    $visibility->update($validateVisibility);

                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'Visibilidad actualizada exitosamente',
                            'visibility' => $visibility
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
                        'message' => 'Visibilidad no encontrada'
                    ],
                    404
                );
            }
        } catch (\Throwable $ex) {
            Log::error('Error en VisibilityController@update: ' . $ex->getMessage());
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

    // Controlador Destroy de Visibilities (Elimina visibilidad) ------------------------------------------------------------------
    public function destroy($id)
    {
        try {
            $user = Auth::user();
            $visibility = Visibility::find($id);

            if ($visibility) {
                if (($user->rol_id == self::rolAdmin && $visibility->id != 1 && $visibility->id != 2) || $user->rol_id == self::rolMaster) {
                    $visibility->delete();
                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'Visibilidad eliminada exitosamente'
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
                        'message' => 'Visibilidad no encontrada'
                    ],
                    404
                );
            }
        } catch (\Throwable $ex) {
            Log::error('Error en VisibilityController@destroy: ' . $ex->getMessage());
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
