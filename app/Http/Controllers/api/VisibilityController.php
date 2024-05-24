<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Visibility;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VisibilityController extends Controller
{
    // Controllador Index de Visibilities -------------------------------------------------------------------------------------
    public function index()
    {
        $visibilities = Visibility::all();
        return response()->json($visibilities);
    }

    // Controllador Create de Visibilities (ruta para crear nuevas visibilidades) ----------------------------------------------------
    public function create()
    {
        return view('crearVisibility');
    }

    // Controllador Store de Visibilities (Crea visibilidad) ------------------------------------------------------------------------
    public function store(Request $request)
    {
        try {
            // Validaciones de la información recibida por Json
            $validateVisibility = $request->validate([
                'visibility_name' => 'required|string|max:45|unique:visibilities,visibility_name',
            ]);

            $visibility = Visibility::create($validateVisibility);

            return response()->json(
                [
                    'message' => 'Visibilidad creada exitosamente',
                    'visibility' => $visibility
                ],
                200
            );
        } catch (Exception $error) {
            // Registra error
            Log::error('Error al crear la visibilidad: ' . $error->getMessage());

            // Respuesta error
            return response()->json(
                [
                    'mensaje' => 'Error al crear la visibilidad',
                    'error' => $error->getMessage()
                ],
                500
            );
        }
    }

    // Controllador Show de Visibilities (busca)-------------------------------------------------------------------------------
    public function show($id)
    {
        $visibility = Visibility::find($id);
        if ($visibility) {
            return response()->json($visibility);
        } else {
            return response()->json(
                [
                    'message' => 'Visibilidad no encontrada'
                ],
                404
            );
        }
    }



    // Controllador edit de Visibilities (ruta para editar visisbility) -----------------------------------------------------------
    public function edit()
    {
        return view('editarVisibility');
    }



    // Controllador update de Visibilities (Actualiza visibilidades) -------------------------------------------------------------------
    public function update(Request $request, $id)
    {
        try {
            $visibility = Visibility::findOrFail($id);
            // Validaciones de la información recibida por Json
            $validateVisibility = $request->validate([
                'visibility_name' => 'required|string|max:45|unique:visibilities,visibility_name,' . $id . ',id'
            ]);

            $visibility->update($validateVisibility);

            return response()->json(
                [
                    'message' => 'Visibilidad Actualizada exitosamente',
                    'visibility' => $visibility
                ],
                200
            );
        } catch (Exception $error) {
            // Registra error
            Log::error('Error al Actualizar la visibilidad: ' . $error->getMessage());

            // Respuesta error
            return response()->json(
                [
                    'mensaje' => 'Error al Actualizar la visibilidad',
                    'error' => $error->getMessage()
                ],
                500
            );
        }
    }

    // Controllador Destroy de Visibilities (Elimina visibilidad) ------------------------------------------------------------------
    public function destroy($id)
    {
        try {
            $visibility = Visibility::find($id);

            if ($visibility) {
                $visibility->delete();
                return response()->json(
                    [
                        'message' => 'Visibilidad eliminada exitosamente'
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'message' => 'Visibilidad no encontrada'
                    ],
                    404
                );
            }
        } catch (\Exception $error) {
            // Catch errores
            Log::error('Error al eliminar la visibilidad: ' . $error->getMessage());

            return response()->json(
                [
                    'mensaje' => 'Error al eliminar la visibilidad',
                    'error' => $error->getMessage()
                ],
                500
            );
        }
    }
}
