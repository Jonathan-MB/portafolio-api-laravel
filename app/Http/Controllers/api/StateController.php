<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\State;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StateController extends Controller

{
    // Controllador Index de States -------------------------------------------------------------------------------------
    public function index()
    {
        $states = State::all();
        return response()->json($states);
    }

    // Controllador Create de States (ruta para crear nuevos estados) ----------------------------------------------------
    public function create()
    {
        return view('crearState');
    }

    // Controllador Store de States (Crea estado) ------------------------------------------------------------------------
    public function store(Request $request)
    {
        try {
            // Validaciones de la información recibida por Json
            $validateState = $request->validate([
                'state_name' => 'required|string|max:45|unique:states,state_name',
            ]);

            $state = State::create($validateState);

            return response()->json(
                [
                    'message' => 'Estado creado exitosamente',
                    'state' => $state
                ],
                200
            );
        } catch (Exception $error) {
            // Registra error
            Log::error('Error al crear el estado: ' . $error->getMessage());

            // Respuesta error
            return response()->json(
                [
                    'mensaje' => 'Error al crear el estado',
                    'error' => $error->getMessage()
                ],
                500
            );
        }
    }

    // Controllador Show de States (busca)-------------------------------------------------------------------------------
    public function show($id)
    {
        $state = State::find($id);
        if ($state) {
            return response()->json($state);
        } else {
            return response()->json(
                [
                    'message' => 'Estado no encontrado'
                ],
                404
            );
        }
    }




    // Controllador edit de States (ruta para editar estados) -----------------------------------------------------------
    public function edit()
    {
        return view('editarState');
    }



    // Controllador update de States (Actualiza estados) -------------------------------------------------------------------
    public function update(Request $request, $id)
    {
        try {
            $state = State::findOrFail($id);
            // Validaciones de la información recibida por Json
            $validateState = $request->validate([
                'state_name' => 'required|string|max:45|unique:states,state_name,' . $id . ',id'
            ]);

            $state->update($validateState);

            return response()->json(
                [
                    'message' => 'Estado Actualizado exitosamente',
                    'state' => $state
                ],
                200
            );
        } catch (Exception $error) {
            // Registra error
            Log::error('Error al Actualizar el estado: ' . $error->getMessage());

            // Respuesta error
            return response()->json(
                [
                    'mensaje' => 'Error al Actualizar el estado',
                    'error' => $error->getMessage()
                ],
                500
            );
        }
    }

    // Controllador Destroy de States (Elimina estado) ------------------------------------------------------------------
    public function destroy($id)
    {
        try {
            $state = State::find($id);

            if ($state) {
                $state->delete();
                return response()->json(
                    [
                        'message' => 'Estado eliminado exitosamente'
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'message' => 'Estado no encontrado'
                    ],
                    404
                );
            }
        } catch (\Exception $error) {
            // Catch errores
            Log::error('Error al eliminar el estado: ' . $error->getMessage());
            return response()->json(
                [
                    'mensaje' => 'Error al eliminar el estado',
                    'error' => $error->getMessage()
                ],
                500
            );
        }
    }
}
