<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;


use App\User;
use App\Models\Order;
use App\Helpers\StringHelper;
use App\Helpers\CorsHelper;
use App\Models\Contact;
use App\Notifications\VerifyEmailUser;
use Illuminate\Support\Str;
use Carbon\Carbon;

class OrderController extends Controller
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
            $orders = Order::where('created_by', $contact->id)->orderBy('id', 'desc')->with('product', 'site')->get();
            return json_encode(['status' => true, 'message' => 'Success !! Order Lists',  'order' => $orders]);
        }
        return json_encode(['status' => false, 'message' => 'Sorry !! Invalid User !!', 'order' => null]);
    }
    
    public function search(Request $request, $keyword)
    {

        CorsHelper::addCors();
        $contact = Contact::where('api_token', $request->api_token)->first();
        $keyword = trim($keyword);
        
        if (!is_null($contact)) {

            $orders = Order::where('created_by', $contact->id)
                    ->where(function($query) use ($keyword){
                        $query->where('id', 'like', '%'.$keyword.'%');
                        $query->orWhere('date', 'like', '%'.$keyword.'%');
                        $query->orWhere('location', 'like', '%'.$keyword.'%');
                    })
                ->with('product')
                ->with('site')
                ->get();
            return json_encode(['status' => true, 'message' => 'Success !! Order Lists',  'orders' => $orders]);
        }
        return json_encode(['status' => false, 'message' => 'Sorry !! Invalid User !!', 'orders' => null]);
    }



    public function store(Request $request)
    {
        CorsHelper::addCors();

        try {
            if (empty($request->quantity)) {
                return json_encode(['status' => false, 'message' => ' Quantity is required !', 'user' => null]);
            }
            if (empty($request->date)) {
                return json_encode(['status' => false, 'message' => 'Date is required !', 'user' => null]);
            }
            if (empty($request->site_id)) {
                return json_encode(['status' => false, 'message' => 'Please select site !', 'user' => null]);
            }
            if (empty($request->product_id)) {
                return json_encode(['status' => false, 'message' => 'Please select a product !', 'user' => null]);
            }
            if (empty($request->location)) {
                return json_encode(['status' => false, 'message' => 'Please give delivery location !', 'user' => null]);
            }
            if (empty($request->upazila_id)) {
                return json_encode(['status' => false, 'message' => 'Please select an upazila !', 'user' => null]);
            }
            if (empty($request->district_id)) {
                return json_encode(['status' => false, 'message' => 'Please select a district !', 'user' => null]);
            }

            $contact = Contact::where('api_token', $request->api_token)->first();

            if (!is_null($contact)) {
                $order = Order::create([
                    'site_id' => $request->site_id,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'date' => $request->date,
                    'location' => $request->location,
                    'unit_id' => $contact->unit_id,
                    'created_by' => $contact->id,
                    'status' => 0,
                    'district_id' => $request->district_id,
                    'upazila_id' => $request->upazila_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                return json_encode(['status' => true, 'message' => 'Order Create !! Save successfulu !!', 'order' => $order]);
            }
        } catch (\Exception $e) {
            return json_encode(['status' => false, 'message' => 'Error: ' . $e->getMessage(), 'order' => null]);
        }
        return json_encode(['status' => false, 'message' => 'Sorry !! Invalid User !!', 'order' => null]);
    }



    public function update(Request $request, $id)
    {

        CorsHelper::addCors();
        $user = Contact::where('api_token', $request->api_token)->first();
        if (!is_null($user)) {
            $order = Order::find($id);
            if (!is_null($order)) {
                $order->site_id = $request->site_id;
                $order->product_id = $request->product_id;
                $order->quantity = $request->quantity;
                $order->date = $request->date;
                $order->location = $request->location;
                $order->unit_id = $request->unit_id;
                $order->district_id = $request->district_id;
                $order->upazila_id = $request->upazila_id;
                $order->created_by = $request->created_by;
                $order->status = $request->status;
                $order->save();
                return json_encode(['status' => true, 'message' => 'Success !! Agenda Updated', 'order' => $order]);
            }
            return json_encode(['status' => false, 'message' => 'Sorry !! Order not found !!', 'order' => null]);
        }
        return json_encode(['status' => false, 'message' => 'Sorry !! Invalid User !!', 'order' => null]);
    }

    /**
     * User Part Start
     */
}
