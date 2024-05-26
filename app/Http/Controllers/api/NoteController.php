<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;



class NoteController extends Controller
{


    // Controllador Index de Notes -------------------------------------------------------------------------------------
    public function index()
    {

        $notes = Note::all();
        return response()->json($notes);
    }



    // Controllador Create de Notes (ruta para crear nuevas notas) ----------------------------------------------------
    public function create()
    {
        return view('crearNota');
    }



    // Controllador Store de Notes (Crea nota) ------------------------------------------------------------------------
    public function store(Request $request)
    {
        try {
            //validaciones de la informacion recibida por Json
            $validateNote = $request->validate([
                'title' => 'required|string|max:50',
                'text' => 'required|string|max:255',
                'user_id' => 'required|integer|exists:users,id',
                'state_id' => 'required|integer|exists:states,id',
                'visibility_id' => 'required|integer|exists:visibilities,id'

            ]);

            $note = Note::create($validateNote);

            return response()->json(
                [
                    'message' => 'Nota creada exitosamente',
                    'note' => $note
                ],
                200
            );

            // Catch errores
        } catch (Exception $error) {
            // Registra  error
            Log::error('Error al crear la nota: ' . $error->getMessage());

            // Respuesta error
            return response()->json(
                [
                    'mensaje' => 'Error al crear la nota',
                    'error' => $error->getMessage()
                ],
                500
            );
        }
    }



    // Controllador Show de Notes (busca)-------------------------------------------------------------------------------
    public function show($id)
    {
        
        $note = Note::find($id);
        if ($note) {
            return response()->json($note);
        } else {
            return response()->json(
                [
                    'message' => 'Nota no encontrada'
                ],
                404
            );
        }
    }



    // Controllador edit de Notes (ruta para editar notas) -----------------------------------------------------------
    public function edit()
    {
        return view('editarNota');
    }


    // Controllador update de Notes (Actualiza notas) -------------------------------------------------------------------
    public function update(Request $request, $id)
    {

        try {

            $note = Note::findOrFail($id);
            //validaciones de la informacion recibida por Json
            $validateNote = $request->validate([
                'title' => 'required|string|max:50',
                'text' => 'required|string|max:255',
                'user_id' => 'required|integer|exists:users,id',
                'state_id' => 'required|integer|exists:states,id',
                'visibility_id' => 'required|integer|exists:visibilities,id'

            ]);

            $note->update($validateNote);

            return response()->json(
                [
                    'message' => 'Nota Actualizada exitosamente',
                    'note' => $note
                ],
                200
            );

            // Catch errores
        } catch (Exception $error) {
            // Registra  error
            Log::error('Error al Actualizar la nota: ' . $error->getMessage());

            // Respuesta error
            return response()->json(
                [
                    'mensaje' => 'Error al Actualizar la nota',
                    'error' => $error->getMessage()
                ],
                500
            );
        }
    }




    // Controllador Destroy de Notes (Elimina  nota) ------------------------------------------------------------------
    public function destroy($id)
    {
        try {
            $note = Note::find($id);

            if ($note) {
                $note->delete();

                return response()->json(
                    [
                        'message' => 'Nota eliminada exitosamente'
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'message' => 'Nota no encontrada'
                    ],
                    404
                );
            }
        } catch (\Exception $error) {
            // Catch errores
            Log::error('Error al eliminar la nota: ' . $error->getMessage());

            return response()->json(
                [
                    'mensaje' => 'Error al eliminar la nota',
                    'error' => $error->getMessage()
                ],
                500
            );
        }
    }
}
