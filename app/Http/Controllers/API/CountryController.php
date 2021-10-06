<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;


use App\User;
use App\Models\Contact;
use App\Helpers\StringHelper;
use App\Helpers\CorsHelper;
use App\Models\District;
use App\Models\Division;
use App\Models\Upazila;
use App\Notifications\VerifyEmailUser;
use Illuminate\Support\Str;

class CountryController extends Controller
{

    function __construct()
    {
        CorsHelper::addCors();
    }

    public function getAllDistricts(Request $request)
    {
        CorsHelper::addCors();
        $districts = District::select('id', 'name')->get();
        return json_encode(['status' => true, 'message' => 'District Lists ', 'districts' => $districts]);
    }


    public function getAllDivisions(Request $request)
    {
        CorsHelper::addCors();
        $divisions = Division::all();
        return json_encode(['status' => true, 'message' => 'Division Lists ', 'divisions' => $divisions]);
    }

    public function getAllUpazilas(Request $request)
    {
        CorsHelper::addCors();
        $upazilas = Upazila::where('district_id', $request->district_id)
            ->select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();
        return json_encode(['status' => true, 'message' => 'Upazila Lists ', 'upazilas' => $upazilas]);
    }


    public function getAllUnion(Request $request)
    {


        CorsHelper::addCors();

        if (!is_null($user) || !is_null($admin)) {
            $unions = Union::all();
            return json_encode(['status' => true, 'message' => 'Union Lists ', 'union' => $unions]);
        }
        return json_encode(['status' => false, 'message' => 'Invalid Access !!', 'unions' => null]);
    }

    /**
     * User Part Start
     */
}
