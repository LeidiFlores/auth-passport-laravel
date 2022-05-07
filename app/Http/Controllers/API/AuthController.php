<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\People;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /***
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login (Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(),
        [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $credentials = request(['email', 'password']);

            if (! Auth::attempt($credentials)) {
                return response()->json([
                    'message' => "Las credenciales no son correctas. Debe iniciar sesión para continuar."
                ], 401);
            }

            $user = User::query()->where('email', $request->email)->firstOrFail();

//            if ($user->email_verified_at === null) {
//                return response()->json('Debe verificar su correo para acceder a la aplicación', 401);
//            }

            $tokenResult = $user->createToken('token')->accessToken;

            return response()->json([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error in Login',
                'error' => $th->getMessage(),
            ], 400);
        }
    }

    /***
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sign (Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(),
        [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            $data = $request->all();
            $data['password'] = Hash::make($request->input('password'));
            $data['first_name'] = $request->name;

            $people = People::query()->create($data);
            $data['people_id'] = $people->id;
            $user = User::query()->create($data);

            $user->roles()->attach(Role::query()->where('name', 'guest')->first());

            $tokenResult = $user->createToken('token')->accessToken;

            return response()->json([
                'message' => 'Usuario registrado con éxito',
                'data' => $people,
                'token' => $tokenResult
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error in Signin',
                'error' => $th->getMessage(),
            ], 400);
        }
    }

    /***
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout (Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $request->user()->token()->revoke();

            return response()->json([
                'message' => 'Se ha cerrado la sesión',
                'data' => 'Se revoco el token'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'message' => 'Error en logout'
            ], 400);
        }
    }

    /***
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser (Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $user = $request->user();
            $people = $user->people;
            // $user_cashier = Cashier::findBillable($people->user->stripeId());

            return response()->json([
                'data' => $people,
                'message' => 'Usuario encontrado con éxito'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
                'message' => 'Error en get usuario'
            ], 400);
        }
    }
}
