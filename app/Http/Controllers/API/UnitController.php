<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;


use App\User;
use App\Helpers\StringHelper;
use App\Helpers\CorsHelper;
use App\Models\Unit;
use App\Notifications\VerifyEmailUser;
use Exception;
use Illuminate\Support\Str;

class UnitController extends Controller
{

    function __construct()
    {
        CorsHelper::addCors();
    }

    public function getUnitData(Request $request)
    {
        CorsHelper::addCors();

        if(isset($request->id)){
            $unit = Unit::find($request->id);
        }else{
            $unit = Unit::orderBy('id', 'desc')->get();
        }

        return json_encode(['status' => true, 'message' => 'Success !! Unit',  'unit' => $unit]);
    }
}
