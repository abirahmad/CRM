<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\UploadHelper;

use App\Models\Contact;
use App\Helpers\CorsHelper;
use App\Models\Complain;

class ComplainController extends Controller
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
            $complains = Complain::where('created_by', $contact->id)->orderBy('id', 'desc')->with('site')->get();
            return json_encode(['status' => true, 'message' => 'All Complain Lists', 'complains' => $complains]);
        }
        return json_encode(['status' => false, 'message' => 'invalid user']);
    }

    public function store(Request $request)
    {
        CorsHelper::addCors();
        $contact = Contact::where('api_token', $request->api_token)->first();

        try {
            if (!is_null($contact)) {
                $complain = new Complain();
                $complain->site_id = $request->site_id;
                $complain->created_by = $contact->id;
                $complain->unit_id = $contact->unit_id;
                $complain->message = $request->message;
                $complain->images = $request->images;

                // if (!is_null($request->file)) {
                //     $complain->images = UploadHelper::upload('file', $request->file,  $contact->id . '-' . time(), 'public/img/complains');
                // }

                $complain->save();
                return json_encode(['status' => true, 'message' => 'Your Complain has sent', 'complain' => $complain]);
            }

            return json_encode(['status' => false, 'message' => 'Invalid User', 'complain' => null]);
        } catch (\Exception $e) {
            return json_encode(['status' => false, 'message' => 'Error: ' . $e->getMessage(), 'complain' => null]);
        }
    }

    public function storeImage(Request $request)
    {
        CorsHelper::addCors();
        $contact = Contact::where('api_token', $request->api_token)->first();

        if (!is_null($contact)) {
            $images = null;
            if (!is_null($request->file)) {
                $images = UploadHelper::upload('file', $request->file('file'),  time(), 'public/img/complains');
            }
            
            return json_encode(['status' => true, 'message' => 'Your Complain has sent', 'images' => $images]);
        }

        return json_encode(['status' => false, 'message' => 'invalid user']);
    }
    
}
