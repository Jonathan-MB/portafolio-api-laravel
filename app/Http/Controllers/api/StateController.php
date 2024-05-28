<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\State;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;




class StateController extends Controller
{

    // Tipos de usuario Bases 
    const rolMaster = 1;
    const rolAdmin = 2;
    const rolUsuario = 3;




    // Controlador Index de States -------------------------------------------------------------------------------------
    public function index()
    {
        try {
            $user = Auth::user();
            if ($user->rol_id == self::rolMaster || $user->rol_id == self::rolAdmin) {
                $states = State::select('id', 'state_name')->get();

                if ($states->isEmpty()) {
                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'No hay estados'
                        ]
                    );
                } else {
                    return response()->json(
                        [
                            'status' => true,
                            'states' => $states
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
            Log::error('Error en StateController@index: ' . $ex->getMessage());
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor'
                ],
                500
            );
        }
    }


    // Controlador Store de States (Crea estado) ------------------------------------------------------------------------
    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            if ($user->rol_id == self::rolMaster || $user->rol_id == self::rolAdmin) {
                // Validaciones de la información recibida por JSON
                $validateState = $request->validate([
                    'state_name' => 'required|string|max:45|unique:states,state_name',
                ]);

                $state = State::create($validateState);

                return response()->json(
                    [
                        'status' => true,
                        'message' => 'Estado creado exitosamente',
                        'state' => $state
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
            Log::error('Error en StateController@store: ' . $ex->getMessage());
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

    // Controlador Show de States (busca)-------------------------------------------------------------------------------
    public function show($id)
    {
        try {

            $state = State::select('id', 'state_name', 'updated_at')->find($id);

            if ($state) {
                return response()->json([
                    'status' => true,
                    'state' => $state
                ]);
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Estado no encontrado'
                    ],
                    404
                );
            }
        } catch (\Throwable $ex) {
            Log::error('Error en StateController@show: ' . $ex->getMessage());
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor'
                ],
                500
            );
        }
    }



    // Controlador Update de States (Actualiza estados) -------------------------------------------------------------------
    public function update(Request $request, $id)
    {
        try {
            $user = Auth::user();
            $state = State::findOrFail($id);

            if ($state) {
                if (($user->rol_id == self::rolAdmin && $state->id != 1 && $state->id != 2) || $user->rol_id == self::rolMaster) {
                    // Validaciones de la información recibida por JSON
                    $validateState = $request->validate([
                        'state_name' => 'required|string|max:45|unique:states,state_name,' . $id . ',id'
                    ]);

                    $state->update($validateState);

                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'Estado actualizado exitosamente',
                            'state' => $state
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
                        'message' => 'Estado no encontrado'
                    ],
                    404
                );
            }
        } catch (\Throwable $ex) {
            Log::error('Error en StateController@update: ' . $ex->getMessage());
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

    // Controlador Destroy de States (Elimina estado) ------------------------------------------------------------------
    public function destroy($id)
    {
        try {
            $user = Auth::user();
            $state = State::find($id);

            if ($state) {
                if (($user->rol_id == self::rolAdmin && $state->id != 1 && $state->id != 2) || $user->rol_id == self::rolMaster) {
                    $state->delete();
                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'Estado eliminado exitosamente'
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
                        'message' => 'Estado no encontrado'
                    ],
                    404
                );
            }
        } catch (\Throwable $ex) {
            Log::error('Error en StateController@destroy: ' . $ex->getMessage());
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
