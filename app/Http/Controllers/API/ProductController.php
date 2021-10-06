<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// use App\User;
use App\Models\Product;
use App\Models\Contact;
use App\Helpers\CorsHelper;


class ProductController extends Controller
{
     public function index(Request $request){

      CorsHelper::addCors();
        $product = Contact::where('api_token', $request->api_token)->first();
        if (!is_null($product)) {
            $product = Product::orderBy('id','desc')->get();
            return json_encode(['status' => true, 'message' => 'Success !! Products Lists',  'product' => $product]);
        }
        return json_encode(['status' => false, 'message' => 'Sorry !! Invalid User !!', 'sites' => null]);
    }
}
