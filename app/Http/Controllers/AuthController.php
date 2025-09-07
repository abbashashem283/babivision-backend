<?php

namespace App\Http\Controllers;

use App\Rules\StrongPassword;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Magico\JwtAuth\Http\Controllers\JwtAuthController;

class AuthController extends JwtAuthController
{


    function register(Request $request)
    {
        $request->validate(
            [
                "name" => "required|min:3",
                "email" => "required|email",
                "password" => [
                    'required',
                     new StrongPassword()
                   
                ],
                "confirm_password" => "required|same:password"
            ],
            [
                "name.required" => "name field required",
                "email.required" => "email field required",
                "password.required" => "password field required",
                "confirm_password.required" => "confirm password field required",
                "confirm_password.same"=>"Confirm password & password don't match"
            ]
        );


        return parent::register($request);
    }

    function login(Request $request){
         $response = parent::login($request);
         $status = $response->status();
        if($response->status() != 200){
            if($status == 401)
                return response()->json(["message"=>"Invalid Access"], 401);
            if($status == 404)
                return response()->json(["message"=>"User not found"], 401); 
            return response()->json(["message"=>"$status repsonse"], $status);
        }
        return $response;
    }

    function test()
    {
        return response()->json(["message" => "this does not work"]);
    }

    function test2(Request $request)
    {
        $validatedData = $request->validate(
            [
                "name" => "required|min:3",
                "email" => "required|email",
                "password" => "required|min:8|max:20",
                "confirm_password" => "required|same:password"
            ],
            [
                "name.required" => "name field required",
                "name.min" => "must have 3 characters minimum",

            ]
        );


        return response()->json(["message" => "ok"]);
    }
}
