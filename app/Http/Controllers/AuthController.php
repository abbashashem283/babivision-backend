<?php

namespace App\Http\Controllers;

use App\Rules\StrongPassword;
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
