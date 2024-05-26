<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use PgSql\Lob;

class UserController extends Controller
{


    // Controllador Index de User -------------------------------------------------------------------------------------
    public function index()
    {

        $users = User::all();
        return response()->json($users);
    }


    // Controllador Show de User (busca)-------------------------------------------------------------------------------
    public function show($id)
    {

        $user = User::find($id);
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(
                [
                    'message' => 'Usuario no encontrada'
                ],
                404
            );
        }
    }




    // Controllador edit de Users (ruta para editar usuarios) -----------------------------------------------------------
    public function edit()
    {
        return view('editarUser');
    }



    // Controllador update de User (Actualiza usuario) -------------------------------------------------------------------
    public function update(Request $request, $id)
    {

        try {

            $user = User::findOrFail($id);
            //validaciones de la informacion recibida por Json
            $validateUser = $request->validate([
                'name' => 'required|string|max:45',
                'email' => 'required|max:45|email|unique:users,email,'.$id.',id',  // correo unico a exepcion de  este usuario
                'rol_id' => 'required|integer|exists:rols,id'

            ]);

            $user->update($validateUser);

            return response()->json(
                [
                    'message' => 'Usuario Actualizado exitosamente',
                    'userInfo' => $user
                ],
                200
            );

            // Catch errores
        } catch (Exception $error) {
            // Registra  error
            Log::error('Error al Actualizar el usuario: ' . $error->getMessage());

            // Respuesta error
            return response()->json(
                [
                    'mensaje' => 'Error al Actualizar el usuario',
                    'error' => $error->getMessage()
                ],
                500
            );
        }
    }




    // Controllador Destroy de User (Elimina  usuario) ------------------------------------------------------------------
    public function destroy($id)
    {
        try {
            $user = User::find($id);

            if ($user) {

                $user->delete();

                return response()->json(
                    [
                        'message' => 'Ususario eliminado exitosamente'
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'message' => 'Usuario no encontrado'
                    ],
                    404
                );
            }
        } catch (\Exception $error) {
            // Catch errores
            Log::error('Error al eliminar el usuario: ' . $error->getMessage());

            return response()->json(
                [
                    'mensaje' => 'Error al eliminar el usuario',
                    'error' => $error->getMessage()
                ],
                500
            );
        }
    }
}
