<?php

namespace App\Http\Controllers\API\Auth;

use App\Actions\HandlerResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Requests\API\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthAPIController extends Controller
{
    use HandlerResponse;

    public function login(LoginRequest $request)
    {
        $user = User::whereName($request->name)->first();

        if (!Hash::check($request->password, $user->password)) {
            return $this->responseUnauthorized(
                message: 'Password incorrect.',
                status_code: Response::HTTP_UNAUTHORIZED
            );
        }

        // Revoke existing tokens if user is already logged in
        if ($user->tokens->count() > 0) {

            $user->tokens->each->delete();
        }

        $token = $user->createToken($user->name)->accessToken;
        return response()->json([
            'token' => $token,
            'user' => new UserResource($user),
            'message' => 'User Login Successfully.',
            'status' => 200,
        ], 200);
    }

    public function logout()
    {
        auth()->guard('api')->user()->tokens->each->delete();
        // return $user;

        return $this->responseSuccessMessage(message: 'Successfully logged out');
    }

    public function profile()
    {
        return response()->json([
            'user' => new UserResource(auth()->guard('api')->user()),
            'message' => 'Successfully',
            'status' => 200,
        ], 200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',

        ]);

        if ($validator->fails()) {

            return $this->responseValidationErrors([$validator->errors()]);
        }

        $input = $request->all();

        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $token = $user->createToken($user->name)->accessToken;

        return response()->json([
            'token' => $token,
            'user' => new UserResource($user),
            'message' => 'User Login Successfully.',
            'status' => 200,
        ], 200);
    }
}
