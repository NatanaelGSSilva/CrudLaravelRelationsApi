<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Note;

class NoteController extends Controller
{
    private $array = ['error'=>'', 'result'=>[]];
    public function all(){
        $notes = Note::all();

         return response()->json($notes);

    //     foreach($notes as $note){
    //         $this->array['result'][]= [
    //             'id'=> $note->id,
    //             'title'=> $note->title
    //         ];
    //     }
    //   return $this->array;

    }

    public function one($id){
        // $note = Note::find($id);
        $note = Note::where('id', $id)->first();

        if($note){
            $this->array['result'] = $note;
        }else{
            $this->array['error'] = 'ID nao encontrado';
        }

        return $this->array;

        // if(!$note) {
        //     return response()->json([
        //         'message'   => 'id nao encontrado',
        //     ], 404);
        // }

        // return response()->json($note);
    }

    public function new(Request $request){

        $note = new Note;
        $note->title = $request->title;
        $note->body = $request->body;
        $note->save();

        return response()->json([
            "message" => "Note Criada com sucesso"
        ], 201);

        // --------------------------------------------------------
        // $note = new Note();
        // $note->fill($request->all());
        // $note->save();

        // return response()->json($note, 201);
        // --------------------------------------------------------
        // $title = $request->input('title');
        // $body = $request->input('body');
        // if($title && $body){
        //     $note = new Note();
        //     $note->title = $title;
        //     $body->title = $body;
        //     $note->save();

        //     $this->array['result'] = [
        //         'id' => $note->id,
        //         'title'=>$title,
        //         'body'=>$body
        //     ];

        // }else{
        //     $this->array['error'] = 'Campos não enviados';
        // }

        // return $this->array;
    }
    public function edit(Request $request, $id){
        $note = Note::find($id);

        if ($note) {
            $note->title = $request->title;
            $note->body = $request->body;
            $note->save();

            if ($note) {
                return response()
                      ->json($note, 200);
            } else {
                return response()
                       ->json(['erro'=>'not update'], 500);
            }
        } else {
            return response()
                   ->json(['erro'=>'not found'], 404);
        }
    }

    public function destroy($id){
        $note = Note::find($id);

        if($note){
            $note->delete();
            return response()->json(['message'=>'Nota Excluida com sucesso']);
        }else{
            return response()
                   ->json(['erro'=>'not found'], 404);
        }

    }

}
