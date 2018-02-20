<?php

namespace MarkVilludo\Permission\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Response;

class PassportController extends Controller
{
    //

 	public $successStatus = 200;

	/**
     * login api
     *
     * @return \Illuminate\Http\Response
    */

 	public function login() {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('UserManagement')->accessToken;
            return Response::json(['success' => $success], $this->successStatus);
        } else {
            return Response::json(['error'=>'Unauthorized'], 401);
        }
    }
 	/**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('UserManagement')->accessToken;
        $success['name'] =  $user->name;

        return Response::json(['success'=>$success], $this->successStatus);
    }
    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
}
