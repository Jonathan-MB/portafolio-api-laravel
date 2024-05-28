<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class NoteController extends Controller
{
    // Tipos de usuario Bases
    const rolMaster = 1;
    const rolAdmin = 2;
    const rolUsuario = 3;




    // Controllador Index de Notes (trae solo las notas del usuario)-------------------------------------------------------------------------------------
    public function index()
    {
        try {

            $user = Auth::user();
            $notes = Note::where('user_id', $user->id)
                ->join('states', 'notes.state_id', '=', 'states.id')
                ->join('visibilities', 'notes.visibility_id', '=', 'visibilities.id')
                ->select('notes.id', 'notes.title', 'notes.text', 'states.state_name', 'visibilities.visibility_name')
                ->get();


            // manejo de ausencia notas
            if ($notes->isEmpty()) {
                return response()->json(
                    [
                        'status' => true,
                        'message' => 'No tienes notas'
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'status' => true,
                        'notes' => $notes
                    ]
                );
            }
        } catch (\Throwable $ex) {

            //registro error Log
            Log::error('Error en NoteController@index: ' . $ex->getMessage());

            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor'
                ],
                500
            );
        }
    }




    // Controllador publicNote de Notes (trae todas las notas que sean publicas)-------------------------------------------------------------------------
    public function publicNote()
    {
        try {
            $notes = DB::table('notes')
                ->join('users', 'notes.user_id', '=', 'users.id')
                ->join('states', 'notes.state_id', '=', 'states.id')
                ->where('notes.visibility_id', 1)
                ->select('notes.title', 'notes.text', 'users.name', 'states.state_name')
                ->get();

            if ($notes->isEmpty()) {
                return response()->json(
                    [
                        'status' => true,
                        'message' => 'No hay notas'
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'status' => true,
                        'notes' => $notes
                    ]
                );
            }
        } catch (\Throwable $ex) {

            //registro error Log
            Log::error('Error en NoteController@publicNote: ' . $ex->getMessage());

            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor'

                ],
                500
            );
        }
    }


    // Controllador Store de Notes (Crea nota) ------------------------------------------------------------------------
    public function store(Request $request)
    {
        try {
            //validaciones de la informacion recibida por Json
            $validateNote = $request->validate([
                'title' => 'required|string|max:50',
                'text' => 'required|string|max:255',
                'state_id' => 'required|integer|exists:states,id',
                'visibility_id' => 'required|integer|exists:visibilities,id'
            ]);

            // Incertar Id  usuario autenticado como  User_id
            $validateNote['user_id'] = Auth::id();

            $note = Note::create($validateNote);

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Nota creada exitosamente',
                    'note' => [
                        'title' => $note['title'],
                        'text' => $note['text'],
                        'state_id' => $note['state_id'],
                        'visibility_id' => $note['visibility_id']
                    ]
                ],
                200
            );

            // Catch errores
        } catch (\Throwable $ex) {

            //registro error Log
            Log::error('Error en NoteController@store: ' . $ex->getMessage());

            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor'

                ],
                500
            );
        }
    }





    // Controllador Show de Notes (busca)-------------------------------------------------------------------------------
    public function show($id)
    {
        try {

            $note = Note::find($id);
            if ($note) {

                $user = Auth::user();
                if ($user->id == $note->user_id || $user->rol_id == self::rolAdmin || $user->rol_id == self::rolMaster) {
                    return response()->json([
                        'status' => true,
                        'note' => $note
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
                        'message' => 'Nota no encontrada'
                    ],
                    404
                );
            }

            // Catch errores
        } catch (\Throwable $ex) {

            //registro error Log
            Log::error('Error en NoteController@show: ' . $ex->getMessage());

            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor'
                ],
                500
            );
        }
    }



    // Controllador Allnote (muestra toda informacion notas a Admons) ----------------------------------------------------------------------------
    public function allNote()
    {
        try {

            $user = Auth::User();
            if ($user->rol_id == self::rolAdmin || $user->rol_id == self::rolMaster) {

                $notes = DB::table('notes')
                    ->join('users', 'notes.user_id', '=', 'users.id')
                    ->join('states', 'notes.state_id', '=', 'states.id')
                    ->select('notes.id', 'notes.user_id', 'users.name', 'states.state_name', 'notes.title', 'notes.text')
                    ->get();

                if ($notes->isEmpty()) {
                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'No hay notas'
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => true,
                            'notes' => $notes
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

            //registro error Log
            Log::error('Error en NoteController@allNote: ' . $ex->getMessage());

            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor'
                ],
                500
            );
        }
    }

    // Controllador update de Notes (Actualiza notas) -------------------------------------------------------------------
    public function update(Request $request, $id)
    {

        try {

            $user = Auth::user();
            $note = Note::findOrFail($id);

            if ($user->id == $note->user_id || $user->rol_id == self::rolAdmin || $user->rol_id == self::rolMaster) {

                //validaciones de la informacion recibida por Json
                $validateNote = $request->validate([
                    'title' => 'required|string|max:50',
                    'text' => 'required|string|max:255',
                    'state_id' => 'required|integer|exists:states,id',
                    'visibility_id' => 'required|integer|exists:visibilities,id'

                ]);

                $note->update($validateNote);

                return response()->json(
                    [
                        'status' => true,
                        'message' => 'Nota Actualizada exitosamente',
                        'note' => [
                            'title' => $validateNote['title'],
                            'text' => $validateNote['text'],
                            'state_id' => $validateNote['state_id'],
                            'visibility_id' => $validateNote['visibility_id']
                        ]
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
        } catch (\Throwable $ex) {

            //registro error Log
            Log::error('Error en NoteController@update ' . $ex->getMessage());

            return response()->json(
                [
                    'status' => false,
                    'message' => 'Se produjo un error en el servidor'

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
            $user = Auth::user();

            if ($note) {

                //Permiso para eliminar 
                if ($user->id == $note->user_id || $user->rol_id == self::rolAdmin || $user->rol_id == self::rolMaster) {

                    //Elimina nota
                    $note->delete();

                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'Nota eliminada exitosamente'
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

                //Respuesta  No existe nota
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Nota no encontrada'
                    ],
                    404
                );
            }
        } catch (\Throwable $ex) {

            //registro error Log
            Log::error('Error en NoteController@destroy ' . $ex->getMessage());

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
