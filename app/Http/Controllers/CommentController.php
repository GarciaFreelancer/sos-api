<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Comment;
use App\User;
use Validator;
use Auth;
use App\Notifications\SituationCommented;
use App\Http\Requests\CommentFormStoreRequest;
use App\Http\Requests\CommentFormUpdateRequest;

class CommentController extends Controller
{
    public function store(CommentFormStoreRequest $request)
    {
        try
        {
            $input = $request->all();
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


    public function update(CommentFormUpdateRequest $request, $id)
    {
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
            ], 401);

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
                'message' => 'Comentário que pretende eliminar pertence outra pessoa'
            ], 401);

        }catch(\Exception $ex){

            return response()->json([
                'sucess' => false,
                'error' => $ex->getMessage()
            ], 500);
        }
    }

}
