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
use App\Models\TestReport;
use App\Helpers\StringHelper;
use App\Helpers\CorsHelper;
use App\Models\Contact;
use App\Models\Site;
use App\Notifications\VerifyEmailUser;
use Exception;
use Illuminate\Support\Str;

class TestReportController extends Controller
{

    function __construct()
    {
        CorsHelper::addCors();
    }
    
public function index(Request $request)
    {

        CorsHelper::addCors();
        $contact = Contact::where('api_token', $request->api_token)->first();
        if (!is_null($contact)) {
            // guard('admin')->user()->is_central_admin= 1
            $reports = TestReport::where('unit_id',$contact->unit_id)
                ->orderBy('priority', 'asc')
                ->with('product');
                // ->get();
            if($request->year){
                $reports->where('year', $request->year);

                if($request->month){
                    $reports->where('month', $request->month);
                }
            }
            $reports = $reports->get();
            return json_encode(['status' => true, 'message' => 'Success !! Report Lists',  'reports' => $reports]);
        }
        return json_encode(['status' => false, 'message' => 'Sorry !! Invalid User !!', 'reports' => null]);
    }


}
