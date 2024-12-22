<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data["password"] = bcrypt($data["password"]);
        $user = User::query()->create($data);

        return $this->sendResponse([], "User registered successfully");
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        if (Auth::attempt(["email" => $data["email"], "password" => $data["password"]])) {
            $user = Auth::user();
            $response["token"] = $user->createToken('MyApp')->plainTextToken;
            $response["user"] = [
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
            ];

            return $this->sendResponse($response, "User logged in successfully");
        }

        return $this->sendError('Unauthorised', ['error'=>'Unauthorised']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAuthUser()
    {
        $user = Auth::user();
        if ($user) {
            $response["user"] = [
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
            ];

            return $this->sendResponse($response, "");
        }

        return $this->sendError('Unauthorised', ['error'=>'Unauthorised']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();

        return $this->sendResponse('', 'Logged out successfully');
    }
}
