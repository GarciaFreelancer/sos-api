<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Situation;
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

            return response()->json($response, 200);

        }catch(\Exception $ex)
        {
            return response()->json([
                'sucess' => false,
                'error' => $ex->getMessage()
            ], 500);
        }

    }


    public function update()
    {

    }

    public function destroy()
    {

    }

}
