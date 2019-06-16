<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Situation;
use App\User;
use Validator;
use Auth;

class UserSituationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $user_situation = $user->situations()->paginate(5);

        $response = [
            'message' => 'Sua lista de situações',
            'data' => $user_situation
        ];

        return response()->json($response, 200);
    }


    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required | max:200',
            'description' => 'required',
            'status' => 'required'
            //'user_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()){
            return response()->json([
                'sucess' => false,
                'error' => $validator->messages()
            ]);
        }

        $title = $request->input('title');
        $description = $request->input('description');
        $status = $request->input('status');
        $file = $request->input('file');
        $user_id = auth()->user()->id;

        $situation = new Situation ([
            'title' => $title,
            'description' => $description,
            'status' => $status,
            'file' => $file,
            'user_id' => $user_id
        ]);

        if ($situation->save())
        {
            $response = [
                'message' => 'Situação criada com sucesso',
                'data' => $situation
            ];

            return response()->json($response, 201);
        }

        $response = [
            'message' => 'Ocorreu um erro na criação da situação'
        ];

        return response()->json($response, 404);

    }


    public function show($id)
    {
        $situation = Situation::with('comments.user')->findOrFail($id);
        $useu_authenticate = auth()->user()->id;

        if ($situation->user_id == $useu_authenticate)
        {
            $response = [
                'message' => 'Situação encotrada com sucesso',
                'data' => $situation
            ];

            return response()->json($response, 200);
        }

        return response()->json([
            'message' => 'Situação que pretende abrir pertence uma outra pessoa'
        ], 404);
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required | max:200',
            'description' => 'required',
            'status' => 'required'
        ]);

        $title = $request->input('title');
        $description = $request->input('description');
        $status = $request->input('status');
        $file = $request->input('file');

        $situation = Situation::findOrFail($id);

        $situation->title = $title;
        $situation->description = $description;
        $situation->status = $status;
        $situation->file = $file;

        if (!$situation->update())
        {
            return response()->json([
                'message' => 'Ocorreu erro durante a actualização'
            ], 404);
        }

        $response = [
            'message' => 'Actualização feita com sucesso',
            'data' => $situation
        ];

        return response()->json($response, 200);

    }


    public function destroy($id)
    {
        $situation = Situation::findOrFail($id);
        $user_authenticate = auth()->user()->id;

        if ($situation->user_id == $user_authenticate)
        {
            $situation->delete();

            return response()->json([
                'message' => 'Situação eliminada com sucesso'
            ], 200);
        }

        return response()->json([
            'message' => 'Situação que pretende eliminar pertence outra pessoa'
        ], 404);

    }

}
