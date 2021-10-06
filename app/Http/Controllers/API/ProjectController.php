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
use App\Models\Contact;
use App\Models\Project;
use App\Models\StructureType;
use App\Notifications\VerifyEmailUser;
use Illuminate\Support\Str;

class ProjectController extends Controller
{

    function __construct()
    {
        CorsHelper::addCors();
    }

    public function Store(Request $request)
    {
        CorsHelper::addCors();
        date_default_timezone_set('Asia/Dhaka');

        if (empty($request->sites_id)) {
            return json_encode(['status' => false, 'message' => ' Site Name required', 'addProject' => null]);
        }
        $user = Contact::where('api_token', $request->api_token)->first();

        if (is_null($user)) {

            $project = Project::create([
                'site_id' => $request->site_id,
                'unit_id' => $request->unit_id,
                'responsible_name' => $request->responsible_name,
                'responsible_phone_no' => $request->responsible_phone_no,
                'type' => $request->type,
                'structure_type_id' => $request->structure_types_id,
                'size' => $request->size,
                'product_usage_qty' => $request->product_usage_qty,
            ]);

            return json_encode(['status' => true, 'message' => 'api key missing', 'project' => $project]);
        }
        return json_encode(['status' => true, 'message' => 'Project createdd successfully', 'project' => null]);
    }

    public function types(Request $request)
    {
        $user = Contact::where('api_token', $request->api_token)->first();

        if (!is_null($user)) {
             $types = StructureType::select('id', 'name')->orderBy('priority', 'asc')->get();
            return json_encode(['status' => true, 'message' => 'Type List', 'types' => $types]);
        }
         return json_encode(['status' => false, 'message' => 'Type List Failed', 'types' => null]);
    }
    
        
    public function update(Request $request, $id)
    {
        $user = Contact::where('api_token', $request->api_token)->first();
        date_default_timezone_set('Asia/Dhaka');

        if (!is_null($user)) {
             $project = Project::find($id);
             if(!is_null($project)  && $project->status == 0){
                 $project->product_usage_qty = $request->product_usage_qty;
                 $project->comment = $request->comment;
                 $project->save();
                 return json_encode(['status' => true, 'message' => 'Item Updated Successfully !', 'project' => $project]);
             }
            return json_encode(['status' => false, 'message' => 'No Project has found !', 'project' => null]);
        }
        return json_encode(['status' => false, 'message' => 'Invalid User', 'project' => null]);
    }
    
    
    public function destroy(Request $request, $id)
    {
        $user = Contact::where('api_token', $request->api_token)->first();

        if (!is_null($user)) {
             $project = Project::find($id);
             if(!is_null($project) && $project->status == 0){
                 $project->delete();
                 return json_encode(['status' => true, 'message' => 'Item Deleted Successfully !', 'project' => $project]);
             }
            return json_encode(['status' => false, 'message' => 'No Project has found !', 'project' => null]);
        }
        return json_encode(['status' => false, 'message' => 'Invalid User', 'project' => null]);
    }
}
