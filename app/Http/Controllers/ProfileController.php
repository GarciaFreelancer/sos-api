<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
use App\User;
use Auth;
use App\Http\Requests\ProfileFormRequest;

class ProfileController extends Controller
{

    public function store(ProfileFormRequest $request)
    {
        try
        {
            $user = auth()->user();
            $profile = $user->profile()->create($request->all());

            $response = [
                'message' => 'Seu perfil foi criado com sucesso',
                'data' => $profile
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

    public function show($id)
    {
        $profile = Profile::findOrFail($id);

        if (is_null($profile)) {
            return response()->json([
                'success' => false,
                'message' => 'Perfil não encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $profile
        ], 200);
        
    }

    public function update(ProfileFormRequest $request, $id)
    {
        $profile = Profile::findOrFail($id);

        if (is_null($profile)) {
            return response()->json([
                'success' => false,
                'message' => 'Perfil não encontrado'
            ], 404);
        }

        $updated = $profile->fill($request->all())
            ->save();

        if ($updated) {
            return response()->json([
                'success' => true,
                'data' => $profile
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Não foi possível actualizar o perfil'
            ], 500);
        }
    }

}
