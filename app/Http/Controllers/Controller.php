<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    //We are sure that we have a user because either 'auth' or 'jwt.auth' middlewares passed
    protected function getUser($request){
        if($request->is('api/*')){
            return JWTAuth::parseToken()->authenticate();
        }
        return Auth::user();
    }

    protected function isApi($request){
        if($request->is('api/*'))
            return true;
        return false;
    }

    protected function returnToApi($data, $code = null){
        if($code)
            return response()->json($data,$code) ;
        return response()->json($data);
    }


}
