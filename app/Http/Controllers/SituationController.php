<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Situation;
use App\Comments;

class SituationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $situation;

    public function __construct(Situation $situation)
    {
        $this->situation = $situation;
    }

    public function index()
    {
        $situations = $this->situation->paginate(5);

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $situation = $this->situation->findOrFail($id);

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

}
