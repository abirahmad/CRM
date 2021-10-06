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

class VehicleTrackingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::guard('admin')->user()->can('vehicle_tracking.view') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }
        $user = Auth::guard('admin')->user();
        return view('backend.pages.vehicle_tracking.index', compact('user'));
    }


    public function vesselTracking(Request $request)
    {
        if (!Auth::guard('admin')->user()->can('vehicle_tracking.view') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }
        $user = Auth::guard('admin')->user();
        if ((Auth::guard('admin')->user()->is_central_admin == 1) || (Auth::guard('admin')->user()->unit_id == 17)) {
            return view('backend.pages.vessel_tracking.index', compact('user'));
        }
        abort(403, 'Unauthorized action.');
    }

    public function vesselTrackingLive(Request $request)
    {
        if (!Auth::guard('admin')->user()->can('vehicle_tracking.view') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }
        $user = Auth::guard('admin')->user();
        if ((Auth::guard('admin')->user()->is_central_admin == 1) || (Auth::guard('admin')->user()->unit_id == 17)) {
            return view('backend.pages.vessel_tracking.index_live', compact('user'));
        }
        abort(403, 'Unauthorized action.');
    }
}
