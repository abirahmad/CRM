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
use App\Models\Site;
use App\Notifications\VerifyEmailUser;
use Exception;
use Illuminate\Support\Str;

class SiteController extends Controller
{

    function __construct()
    {
        CorsHelper::addCors();
    }

    public function store(Request $request)
    {

        CorsHelper::addCors();
        date_default_timezone_set('Asia/Dhaka');
        
        if (empty($request->name)) {
            return json_encode(['status' => false, 'message' => 'Site Name is required', 'user' => null]);
        }

        if (empty($request->owner_name)) {
            return json_encode(['status' => false, 'message' => ' Owner Name is required', 'user' => null]);
        }

        if (empty($request->owner_phone_no)) {
            return json_encode(['status' => false, 'message' => 'Owner Phone no is required', 'user' => null]);
        }

        if (empty($request->address)) {
            return json_encode(['status' => false, 'message' => 'Owner address is required', 'user' => null]);
        }

        if (empty($request->structure_type_id)) {
            return json_encode(['status' => false, 'message' => 'Structure type is required', 'user' => null]);
        }

        if (empty($request->product_usage_qty)) {
            return json_encode(['status' => false, 'message' => 'Product Usage Quantity is required', 'user' => null]);
        }

        if (empty($request->size)) {
            return json_encode(['status' => false, 'message' => 'Site Size is required', 'user' => null]);
        }

        // if (empty($request->comment)) {
        //     return json_encode(['status' => false, 'message' => 'Site Comment is required', 'user' => null]);
        // }
        
        // First Search if any entry is already in the database for this owner_phone_no
        if(!is_null(Site::where('owner_phone_no', $request->owner_phone_no)->where('name', $request->name)->first())){
            return json_encode(['status' => false, 'message' => 'Already a same site has been created for this owner ! Please check your existing sites !']);
        }

        $contact = Contact::where('api_token', $request->api_token)->first();
        // dd($contact);
        try {

            if (!is_null($contact)) {
                
                // Create a site in sites table, unit will be got from contact
                $site = new Site();
                $site->name = trim($request->name);
                $site->created_by = $contact->id;
                $site->unit_id = $contact->unit_id;
                $site->owner_name = trim($request->owner_name);
                $site->owner_phone_no = $request->owner_phone_no;
                $site->address = trim($request->address);
                $site->structure_type_id = $request->structure_type_id;
                $site->save();


                // Create an entry in Project table also
                $project = new Project();
                $project->site_id = $site->id;
                $project->created_by = $contact->id;
                $project->unit_id = $contact->unit_id;
                $project->product_usage_qty = $request->product_usage_qty;
                $project->responsible_name =  $site->owner_name;
                $project->responsible_phone_no = $site->owner_phone_no;
                $project->comment = trim($request->comment);
                $project->size = trim($request->size);
                $project->type = 'new';
                $project->save();

                return json_encode(['status' => true, 'message' => 'Site has been Created successfully !!']);
            }
        } catch (\Exception $e) {
            return json_encode(['status' => false, 'message' => 'Error : !!' . $e->getMessage(), 'site' => null]);
        }
        return json_encode(['status' => false, 'message' => 'Sorry !! Invalid User !!', 'sites' => null]);
    }


    public function index(Request $request)
    {

        CorsHelper::addCors();
        $contact = Contact::where('api_token', $request->api_token)->first();
        if (!is_null($contact)) {
            $sites = Site::where('created_by', $contact->id)
                ->with('projects')
                ->with('project')
                // ->with('total_product_usage')
                ->orderBy('id', 'desc')
                ->get();
            return json_encode(['status' => true, 'message' => 'Success !! Site Lists',  'sites' => $sites]);
        }
        return json_encode(['status' => false, 'message' => 'Sorry !! Invalid User !!', 'sites' => null]);
    }


    public function search(Request $request, $keyword)
    {

        CorsHelper::addCors();
        $contact = Contact::where('api_token', $request->api_token)->first();
        $keyword = trim($keyword);
        
        if (!is_null($contact)) {

            $sites = Site::where('created_by', $contact->id)
                    ->where(function($query) use ($keyword){
                        $query->where('name', 'like', '%'.$keyword.'%');
                        $query->orWhere('owner_name', 'like', '%'.$keyword.'%');
                        $query->orWhere('owner_phone_no', 'like', '%'.$keyword.'%');
                    })
                ->with('projects')
                ->with('project')
                ->orderBy('id', 'desc')
                ->get();
            return json_encode(['status' => true, 'message' => 'Success !! Site Lists',  'sites' => $sites]);
        }
        return json_encode(['status' => false, 'message' => 'Sorry !! Invalid User !!', 'sites' => null]);
    }


    public function show(Request $request, $id)
    {

        CorsHelper::addCors();
        $contact = Contact::where('api_token', $request->api_token)->first();
        if (!is_null($contact)) {
            $site = Site::where('created_by', $contact->id)
                ->where('id', $id)
                ->with('projects')
                ->first();
            return json_encode(['status' => true, 'message' => 'Success !! Site Detail',  'site' => $site]);
        }
        return json_encode(['status' => false, 'message' => 'Sorry !! Invalid User !!', 'sites' => null]);
    }
    
    public function update(Request $request, $id)
    {

        CorsHelper::addCors();
        date_default_timezone_set('Asia/Dhaka');

        if (empty($request->id)) {
            return json_encode(['status' => false, 'message' => ' Please choose a site', 'user' => null]);
        }

        if (empty($request->name)) {
            return json_encode(['status' => false, 'message' => 'Site Name is required', 'user' => null]);
        }

        if (empty($request->owner_name)) {
            return json_encode(['status' => false, 'message' => ' Owner Name is required', 'user' => null]);
        }

        if (empty($request->owner_phone_no)) {
            return json_encode(['status' => false, 'message' => 'Owner Phone no is required', 'user' => null]);
        }

        if (empty($request->address)) {
            return json_encode(['status' => false, 'message' => 'Owner address is required', 'user' => null]);
        }

        if (empty($request->product_usage_qty)) {
            return json_encode(['status' => false, 'message' => 'Akij Cement Usage Quantity is required', 'user' => null]);
        }

        if (empty($request->size)) {
            return json_encode(['status' => false, 'message' => 'Site Size is required', 'user' => null]);
        }

        // if (empty($request->comment)) {
        //     return json_encode(['status' => false, 'message' => 'Site Comment is required', 'user' => null]);
        // }


        $contact = Contact::where('api_token', $request->api_token)->first();
        try {
            if (!is_null($contact)) {
                $id = $request->id;
                $site = Site::find($id);
                if (!is_null($site)) {

                    $site->name = $request->name;
                    $site->unit_id = $contact->unit_id;
                    $site->owner_name = $request->owner_name;
                    $site->owner_phone_no = $request->owner_phone_no;
                    $site->save();

                    // Create an entry in Project table also
                    $project = new Project();
                    $project->site_id = $site->id;
                    $project->created_by = $contact->id;
                    $project->unit_id = $contact->unit_id;
                    $project->product_usage_qty = $request->product_usage_qty;
                    $project->responsible_name =  $site->owner_name;
                    $project->responsible_phone_no = $site->owner_phone_no;
                    $project->comment = $request->comment;
                    $project->size = $request->size;
                    $project->type = 'old';
                    $project->save();

                    return json_encode(['status' => true, 'message' => 'Success !! Site Updated', 'site' => $site]);
                }
                return json_encode(['status' => false, 'message' => 'Sorry !! Site not found !!', 'site' => null]);
            }
        } catch (\Exception $e) {
            return json_encode(['status' => false, 'message' => 'Error : !!' . $e->getMessage(), 'site' => null]);
        }
        return json_encode(['status' => false, 'message' => 'Sorry !! Invalid User !!', 'site' => null]);
    }
}
