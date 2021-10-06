<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Auth;
use Exception;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Facades\Hash;
use App\Models\Video;
use Yajra\DataTables\Facades\DataTables;

class OutletTrackingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    
    
    public function outletTracking(Request $request)
    {
        if (!Auth::guard('admin')->user()->can('outlet_tracking.view') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }
        $user = Auth::guard('admin')->user();
        if((Auth::guard('admin')->user()->is_central_admin == 1) || (Auth::guard('admin')->user()->unit_id == 2)){
            return view('backend.pages.outlet_tracking.index', compact('user'));
        }
        abort(403, 'Unauthorized action.');
    }

}
