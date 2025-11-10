<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function addFeedback(Request $request){
        $validatedData = $request->validate([
            "name"=>"required",
            "email"=>"required|email",
            "message"=>"required",
            "type"=>"required|string|in:feedback,bug,complaint"
        ]);
        Feedback::create($validatedData);
        return response()->json(["type"=>"success", "message"=>"Feedback Added!"]);
    }
}
