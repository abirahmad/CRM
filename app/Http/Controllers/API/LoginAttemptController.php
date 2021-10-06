<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


use App\Helpers\CorsHelper;

use Carbon\Carbon;

class LoginAttemptController extends Controller
{

    function __construct()
    {
        CorsHelper::addCors();
    }

    public function store(Request $request)
    {
        
        CorsHelper::addCors();
        
        // Set timezone 
        date_default_timezone_set('Asia/Dhaka');

        $token = "hjui9023872jhds283237hjj099230ncjqmckdlorudbsgdsd17217268208049820372367682293823091208793874364231101290832";
        if($request->token != $token){
            return json_encode(['status' => false, 'message' => 'Invalid Token']);
        }
        
        $user_type = "";
        if($request->user_type){
            $user_type = $request->user_type;
        }else{
            $user_type = "ERP User";
        }
        
        $loginData = DB::table('login_attempts')->insert([
            'type' => $request->type,
            'name' => $request->name,
            'version' => $request->version,
            'user_name' => $request->user_name,
            'user_email' => $request->user_email,
            'user_phone_number' => $request->user_phone_number,
            'user_device_id' => $request->user_device_id,
            'user_type' => $user_type,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        
        return json_encode(['status' => true, 'message' => 'Success !! Login Data added']);
    }
    
    
    public function getAppData(Request $request)
    {
        CorsHelper::addCors();
        
        $token = "hjui9023872jhds283237hjj099230ncjqmckdlorudbsgdsd17217268208049820372367682293823091208793874364231101290832";
        if($request->token != $token){
            return json_encode(['status' => false, 'message' => 'Invalid Token', 'appData' => null]);
        }
        
        $appData = DB::table('applications')->where('app_short_name', $request->app_name)->first();
        return json_encode(['status' => true, 'appData' => $appData]);
    }
}
