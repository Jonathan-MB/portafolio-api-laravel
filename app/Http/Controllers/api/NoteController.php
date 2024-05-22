<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;


class NoteController extends Controller
{
    public function index(){

        $notes = Note::all();
        return response()->json($notes);

    }
}
