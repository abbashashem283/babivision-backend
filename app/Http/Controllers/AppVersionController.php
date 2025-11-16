<?php

namespace App\Http\Controllers;

use App\Models\AppVersion;
use Illuminate\Http\Request;

class AppVersionController extends Controller
{
    public function versions(Request $request){
        $latest = $request->query("latest");
        if($latest && $latest=="true"){
            $version = AppVersion::latest()->value('version');
            return response()->json(["version"=>$version]);
        }
            
        $versions = AppVersion::all();
        return compact('versions');
    }
}
