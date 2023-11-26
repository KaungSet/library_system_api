<?php

namespace App\Http\Controllers\API\Admin;

use App\Actions\HandlerResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    use HandlerResponse;

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

        $user = Admin::create($input);

        Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'));

        return response()->json([
            'token' => '$token',
            'user' => new AdminResource($user),
            'message' => 'Admin Login Successfully.',
            'status' => 200,
        ], 200);
    }

    public function index()
    {
        return 'index';
    }
}
