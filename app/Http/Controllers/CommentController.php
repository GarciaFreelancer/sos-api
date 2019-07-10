<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Comment;
use App\User;
use Validator;
use Auth;
use App\Notifications\SituationCommented;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'situation_id' => 'required|exists:situations,id',
            'description' => 'required|max:15000'
        ]);

        if ($validator->fails()){
            return response()->json([
                'sucess' => false,
                'error' => $validator->messages()
            ]);
        }

        try
        {
            $user = auth()->user();
            $comment = $user->comments()->create($input);

            //Notify user situation
            $author = $comment->situation->user;
            $author->notify(new SituationCommented($comment));

            $response = [
                'message' => 'Comentário feito com sucesso',
                'data' => $comment
            ];

            return response()->json($response, 201);

        }catch(\Exception $ex)
        {
            return response()->json([
                'sucess' => false,
                'error' => $ex->getMessage()
            ], 500);
        }

    }


    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'description' => 'required|max:15000'
        ]);

        if ($validator->fails()){
            return response()->json([
                'sucess' => false,
                'error' => $validator->messages()
            ]);
        }

        try
        {
            $comment = Comment::findOrFail($id);
            $user_authenticate = auth()->user()->id;

            if ($comment->user_id == $user_authenticate)
            {

                $description = $request->description;

                $comment->update(['description' => $description]);

                $response = [
                    'message' => 'Comentário alterado com sucesso',
                    'data' => $comment
                ];

                return response()->json($response, 200);
            }

            return response()->json([
                'message' => 'Comentário que pretende alterar pertence outra pessoa'
            ], 404);

        }catch(\Exception $ex){

            return response()->json([
                'sucess' => false,
                'error' => $ex->getMessage()
            ], 500);
        }

    }

    public function destroy($id)
    {
        try
        {
            $comment = Comment::findOrFail($id);
            $user_authenticate = auth()->user()->id;

            if ($comment->user_id == $user_authenticate)
            {
                $comment->delete();

                $response = [
                    'message' => 'Comentário eliminado com sucesso',
                    'data' => $comment
                ];

                return response()->json($response, 200);
            }

            return response()->json([
                'message' => 'Comentário que pretende eliminar não foi encontrado'
            ], 404);

        }catch(\Exception $ex){

            return response()->json([
                'sucess' => false,
                'error' => $ex->getMessage()
            ], 500);
        }
    }

}
