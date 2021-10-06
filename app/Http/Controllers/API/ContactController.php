<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;


use App\User;
use App\Models\Contacts;
use App\Models\ContactReferece;
use App\Helpers\StringHelper;
use App\Helpers\CorsHelper;
use App\Notifications\VerifyEmailUser;
use Illuminate\Support\Str;

class ContactController extends Controller
{

    function __construct()
    {
        CorsHelper::addCors();
    }

    public function register(Request $request)
    {
        CorsHelper::addCors();

        if (empty($request->name)) {
            return json_encode(['status' => false, 'message' => ' Name is required', 'user' => null]);
        }
        if (empty($request->phone)) {
            return json_encode(['status' => false, 'message' => 'Phone is required', 'user' => null]);
        }
        if (empty($request->email)) {
            return json_encode(['status' => false, 'message' => 'Email is required', 'user' => null]);
        }
        if (empty($request->password)) {
            return json_encode(['status' => false, 'message' => 'Password is required', 'user' => null]);
        }
        if ($request->password != $request->confirm_password) {
            return json_encode(['status' => false, 'message' => 'Password does not match', 'user' => null]);
        }
        $user = Contacts::where('email', $request->email)->count();
        if ($user > 0) {
            return json_encode(['status' => false, 'message' => 'User already Exist', 'user' => null]);
        }

        $contacts = Contacts::create([
            'name' => $request->name,
            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'designation' => $request->designation,
            'fb_address' => $request->fb_address,
            'firm_name' => $request->firm_name,
            'district_id' => $request->district_id,
            'upazila_id' => $request->upazila_id,
            'office_address' => $request->office_address,
            'contact_type_id' => $request->contact_type_id,
            'unit_id' => $request->unit_id,
            'verify_token' => $request->verify_token,
            'remember_token' => $request->remember_token,
            'status' => $request->status,
            'language' => $request->language,
            'api_token'  => StringHelper::createSlug(Str::random(60), 'Contacts', 'api_token', ''),
        ]);
        return json_encode(['status' => true, 'message' => 'User has been registered !! Please Enter Verification Code to be verified !!', 'user' => $contacts]);
    }

    public function loginUser(Request $request)
    {
        CorsHelper::addCors();

        if (empty($request->email)) {
            return json_encode(['status' => false, 'message' => 'Username or Email is required', 'user' => null]);
        }
        if (empty($request->password)) {
            return json_encode(['status' => false, 'message' => 'Password is required', 'user' => null]);
        }

        $user = Contacts::where('email', $request->email)
            ->orWhere('email', $request->name)
            ->first();

        if (!is_null($user)) {
            $passwordOk = Hash::check($request->password, $user->password);

            if ($passwordOk) {
                // Check If his account is approve or not
                if ($user->status) {
                    return json_encode(['status' => true, 'message' => 'Logged in Successfully !!', 'user' => $user]);
                }
                return json_encode(['status' => false, 'message' => 'Your account is not approved yet !! Please Contact with administrator !!', 'user' => $user]);
            } else {
                return json_encode(['status' => false, 'message' => 'Invalid Username and password !! ', 'user' => null]);
            }
        }

        return json_encode(['status' => false, 'message' => 'Sorry !! No User account by this username or email address', 'user' => null]);
    }
    
}
