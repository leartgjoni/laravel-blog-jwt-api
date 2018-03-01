<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;
use \App\User;
use Auth;
class AuthenticateController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // if no errors are encountered we can return a JWT
        $user = Auth::authenticate($credentials);
        return response()->json(compact('token','user'));
    }

    public function signup(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->returnToApi(["error"=>$validator->errors()->all()],400);
        }
        $data = $request->all();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
           'password' => bcrypt($data['password']),
            ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('token','user'));


    }

    //Logout from device (the token will not be valid anymore)
    public function logout(Request $request) {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => true, 'response' => "You are logged out from mobile device"]);
    }
}
