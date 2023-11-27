<?php

namespace App\Http\Controllers\API;

use App\Actions\HandlerResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserAPIController extends Controller
{
    use HandlerResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if ($user->name !== auth()->guard('api')->user()->name) {

            $validator = Validator::make($request->all(), [

                'name' => 'required',
                'email' => 'required|email',
                'confirm_password' => 'same:password',

            ]);

            if ($validator->fails()) {

                return $this->responseValidationErrors([$validator->errors()]);
            }

            if ($request['password']) {
                $request['password'] = bcrypt($request['password']);
            }

            $user->update($request->all());

            return response()->json([
                'user' => new UserResource($user),
                'message' => 'User Updated Successfully.',
                'status' => 200,
            ], 200);
        }

        return $this->responseUnprocessable(
            status_code: 422,
            message: "You are trying to edit the current authenticated user information!"
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (!($user->id == auth()->guard('api')->user()->id)) {
            $log = ActivityLog::where('createable_id', $user->id)->first();

            if ($log) {
                return $this->responseUnprocessable(
                    status_code: 422,
                    message: "Sorry, you cannot delete this record.!",
                );
            } else {
                $user->delete();
                return $this->responseSuccessMessage(message: 'User Deleted Successfully.', status_code: 201);
            }
        }
    }
}
