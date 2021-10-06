<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\Models\Contact;
use App\Helpers\CorsHelper;
use App\Models\AreaManager;

class AreaManagerController extends Controller
{
    
    function __construct()
    {
        CorsHelper::addCors();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         CorsHelper::addCors();

        $contact = Contact::where('api_token', $request->api_token)->first();
        if (!is_null($contact)) {
            $areas = AreaManager::orderBy('areaManagerName', 'asc')->get();
            return $areas;
            return json_encode(['status' => true, 'message' => 'All Areas', 'areas' => $areas]);
        }
        return json_encode(['status' => false, 'message' => 'Invalid User', 'areas' => null]);
    }
    
    
    public function getAreaAPI(Request $request)
    {
         CorsHelper::addCors();

        $contact = Contact::where('api_token', $request->api_token)->first();
        if (!is_null($contact)) {
            $api_endpoint = "http://crm.akij.net/api/erp/areas";
            return json_encode(['status' => true, 'message' => 'API', 'api_endpoint' => $api_endpoint]);
        }
        return json_encode(['status' => false, 'message' => 'Invalid User', 'api_endpoint' => null]);
    }
    
    public function getData(Request $request)
    {
        CorsHelper::addCors();
        return json_encode(['status' => true, 'message' => 'Hi ! Python']);
    }
    
}

 