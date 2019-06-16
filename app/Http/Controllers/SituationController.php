<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Situation;
use App\Comments;

class SituationController extends Controller
{

    private $situation;

    public function __construct(Situation $situation)
    {
        $this->situation = $situation;
    }


    public function index()
    {
        $situations = $this->situation->paginate(5);

        $response = [
            'message' => 'Lista de Situações',
            'data' => $situations
        ];

        return response()->json($response, 200);
    }


    public function show($id)
    {
        $situation = $this->situation->with('comments.user')->findOrFail($id);

        $response = [
            'message' => 'Situação encotrada com sucesso',
            'data' => $situation
        ];

        return response()->json($response, 200);
    }

}
