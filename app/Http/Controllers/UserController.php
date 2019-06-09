<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        foreach ($users as $user)
        {
            $user->view_user = [
                'href' => 'api/v1/user/' . $user->id,
                'method' => 'GET'
            ];
        }

        $response = [
            'msg' => 'Lista de Usuarios',
            'users' => $users
        ];

        return response()->json($response, 200);
    }
}
