<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;


use App\User;
use App\Models\Order;
use App\Models\Project;
use App\Helpers\StringHelper;
use App\Helpers\CorsHelper;
use App\Models\Contact;
use App\Models\Survey;
use App\Notifications\VerifyEmailUser;
use Exception;
use Illuminate\Support\Str;

class SurveyController extends Controller
{

    function __construct()
    {
        CorsHelper::addCors();
    }

    public function index(Request $request)
    {
        CorsHelper::addCors();
        if(isset($request->unit_id)){
            $surveys = Survey::where('unit_id', $request->unit_id)
            ->orderBy('id', 'desc')
            ->get();
        }else{
            $surveys = Survey::orderBy('id', 'desc')->get();
        }
        return json_encode(['status' => true, 'message' => 'Success !! Survey Lists',  'surveys' => $surveys]);
    }
}
