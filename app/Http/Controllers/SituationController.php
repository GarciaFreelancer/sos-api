<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Situation;

class SituationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $situations = Situation::all();

        foreach ($situations as $situation)
        {
            $situation->view_situation = [
                'href' => 'api/v1/situation/' . $situation->id,
                'method' => 'GET'
            ];
        }

        $response = [
            'msg' => 'Lista de Situações',
            'data' => $situations
        ];

        return response()->json($response, 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required | max:200',
            'description' => 'required',
            'status' => 'required',
            'user_id' => 'required|exists:users,id'
        ]);

        $title = $request->input('title');
        $description = $request->input('description');
        $status = $request->input('status');
        $file = $request->input('file');
        $user_id = $request->input('user_id');

        $situation = new Situation ([
            'title' => $title,
            'description' => $description,
            'status' => $status,
            'file' => $file,
            'user_id' => $user_id
        ]);

        if ($situation->save())
        {
            $situation->view_situation = [
                'href' => 'api/v1/situation/' . $situation->id,
                'method' => 'GET'
            ];

            $message = [
                'message' => 'Situação criada com sucesso',
                'data' => $situation
            ];

            return response()->json($message, 201);
        }

        $response = [
            'message' => 'Ocorreu um erro na criação da situação'
        ];

        return response()->json($response, 404);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $situation = Situation::findOrFail($id);

        $situation->view_situation = [
            'href' => 'api/v1/situation/' . $situation->id,
            'method' => 'GET'
        ];

        $response = [
            'msg' => 'Situação encotrada com sucesso',
            'situation' => $situation
        ];

        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
                'msg' => 'Ocorreu erro durante a actualização'
            ], 404);
        }

        $situation->view_situation = [
            'href' => 'api/v1/situation/' . $situation->id,
            'method' => 'GET'
        ];

        $response = [
            'msg' => 'Actualização feita com sucesso',
            'situation' => $situation
        ];

        return response()->json($response, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $situation = Situation::findOrFail($id);
        $situation->delete();

        return response()->json([
            'msg' => 'Situação eliminada com sucesso'
        ], 200);

    }

}
