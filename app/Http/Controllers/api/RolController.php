<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RolController extends Controller
{
    // Controllador Index de Rols -------------------------------------------------------------------------------------
    public function index()
    {

        $rols = Rol::all();
        return response()->json($rols);
    }



    // Controllador Create de Rols (ruta para crear nuevos roles) ----------------------------------------------------
    public function create()
    {
        return view('crearRol');
    }



    // Controllador Store de Rols (Crea rol) ------------------------------------------------------------------------
    public function store(Request $request)
    {
        try {
            //validaciones de la informacion recibida por Json
            $validateRol = $request->validate([

                'rol_name' => 'required|string|max:45|unique:rols,rol_name',

            ]);

            $rol = Rol::create($validateRol);

            return response()->json(
                [
                    'message' => 'rol creado exitosamente',
                    'rol' => $rol
                ],
                200
            );

            // Catch errores
        } catch (Exception $error) {
            // Registra  error
            Log::error('Error al crear el rol: ' . $error->getMessage());

            // Respuesta error
            return response()->json(
                [
                    'mensaje' => 'Error al crear el rol',
                    'error' => $error->getMessage()
                ],
                500
            );
        }
    }



    // Controllador Show de Rols (busca)-------------------------------------------------------------------------------
    public function show($id)
    {

        $rol = Rol::find($id);
        if ($rol) {
            return response()->json($rol);
        } else {
            return response()->json(
                [
                    'message' => 'Rol no encontrado'
                ],
                404
            );
        }
    }



    // Controllador edit de Rols (ruta para editar roles) -----------------------------------------------------------
    public function edit()
    {
        return view('editarRol');
    }



    // Controllador update de Rols (Actualiza roles) -------------------------------------------------------------------
    public function update(Request $request, $id)
    {

        try {

            $rol = Rol::findOrFail($id);
            //validaciones de la informacion recibida por Json
            $validateRol = $request->validate([

                'rol_name' => 'required|string|max:45|unique:rols,rol_name,'.$id.',id'

            ]);

            $rol->update($validateRol);

            return response()->json(
                [
                    'message' => 'Rol Actualizado exitosamente',
                    'rol' => $rol
                ],
                200
            );

            // Catch errores
        } catch (Exception $error) {
            // Registra  error
            Log::error('Error al Actualizar el rol: ' . $error->getMessage());

            // Respuesta error
            return response()->json(
                [
                    'mensaje' => 'Error al Actualizar el rol',
                    'error' => $error->getMessage()
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

            if ($rol) {
                $rol->delete();

                return response()->json(
                    [
                        'message' => 'Rol eliminado exitosamente'
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'message' => 'rol no encontrado'
                    ],
                    404
                );
            }
        } catch (\Exception $error) {
            // Catch errores
            Log::error('Error al eliminar el rol: ' . $error->getMessage());

            return response()->json(
                [
                    'mensaje' => 'Error al eliminar el rol',
                    'error' => $error->getMessage()
                ],
                500
            );
        }
    }
}
