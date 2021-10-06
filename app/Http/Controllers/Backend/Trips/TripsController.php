<?php

namespace App\Http\Controllers\Backend\Trips;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\Models\Project;
use App\Models\Site;
use App\Models\Contact;
use App\Models\StructureType;
use App\Models\RewardPoint;
use App\Models\Unit;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use DB;


class TripsController extends Controller
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
        if (
            !Auth::guard('admin')->user()->can('trip.list')
            && (Auth::guard('admin')->user()->is_central_admin != 1)
        ) {
            abort(403, 'Unauthorized action.');
        }



        // $unit_id = Auth::guard('admin')->user()->unit_id;
        $user = Auth::guard('admin')->user();
        $units = Unit::select('id', 'name', 'code')->get();

        if (!empty(request()->unit_id)) {
            $unit_id = request()->unit_id;
        } else {
            $unit_id = 4;
        }

        if (!empty(request()->start_date)) {
            $start_date = request()->start_date;
        } else {
            $start_date = date('Y-m-d');
        }
        if (!empty(request()->end_date)) {
            $end_date = request()->end_date;
        } else {
            $end_date = date('Y-m-d');
        }

        $file_url = 'http://iapps.akij.net/api/v1/logistic/trips/getTripListByUnitId?intUnitId=' . $unit_id . '&dteStartDate=' . $start_date . '&dteEndDate=' . $end_date;


        $response = file_get_contents($file_url);
        $data = json_decode($response)->data;

        if (request()->ajax()) {

            // return  $data;

            $datatable = Datatables::of($data)
                ->addIndexColumn()
                ->addColumn(
                    'action',
                    function ($row) {
                        $csrf = "" . csrf_field() . "";
                        $html = '<div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="' . route('admin.trips.show', $row->intTripId) . '">
                                            <i class="fa fa-eye"></i> View
                                        </a>
                                    </div>
                                </div> 
                            ';
                        return $html;
                    }
                )

                ->editColumn('strDriver', function ($row) {
                    $html = "<strong>Name: </strong>" . $row->strDriver;
                    $html .= "<br /><strong>Phone: </strong>" . $row->strContact;
                    $html .= "<br /><strong>Helper: </strong>" . $row->strHelperName;
                    $html .= "<br /><strong>Call: </strong><a title='Call Driver' href='tel:" . $row->strContact . "' class='btn btn-danger btn-sm'><i class='fa fa-phone'></i></a>";
                    return $html;
                })
                ->editColumn('str3rdPartyName', function ($row) {
                    $html = "<strong>Name: </strong>" . $row->str3rdPartyName;
                    $html .= "<br /><strong>Chart Of Acc: </strong>" . $row->int3rdPartyCOAid;
                    $html .= "<br /><strong>DO: </strong>" . $row->strDoCode;
                    return $html;
                })
                ->editColumn('strTripCode', function ($row) {
                    $html = $row->strTripCode;
                    // $html .= "<br /><strong>Unit: </strong>" . $row->intUnitId;
                    return $html;
                })
                ->editColumn('dteInsertionTime', function ($row) {

                    $date = Carbon::parse($row->dteInsertionTime, 'UTC');
                    $carbonGateInTime = $date->isoFormat('MMMM Do YYYY, h:mm:ss a'); // June 15th 2018, 5:34:15 pm
                    $html = "<strong>Gate In: </strong>" . $carbonGateInTime;

                    // Trip Assign Status
                    $html .= "<br /><strong>Assign Complete: </strong>";
                    $html .= $row->ysnTripAssignCom == "1" ?  "<span class='badge badge-success'>Yes</span>" :  "<span class='badge badge-danger'>No</span>";


                    // Gate Out History

                    if (is_null($row->dteOutTime)) {
                        $html .= "<br /><strong>Gate Out: </strong>" . "<span class='badge badge-success'>Inside Factory</span>";
                    } else {
                        $date = Carbon::parse($row->dteOutTime, 'UTC');
                        $carbonGateOutTime = $date->isoFormat('MMMM Do YYYY, h:mm:ss a');
                        $html .= "<br /><strong>Gate Out: </strong>" . $carbonGateOutTime;
                    }
                    return $html;
                });



            $rawColumns = ['action', 'strShippingPointName', 'str3rdPartyName', 'strTripCode', 'strVehicleRegNo', 'strDriver', 'dteInsertionTime'];

            return $datatable->rawColumns($rawColumns)
                ->make(true);
        }

        return view('backend.pages.trips.index', compact('user', 'units', 'unit_id', 'start_date', 'end_date'));
    }



    //Trip Details
    public function show($id)
    {
        if (!Auth::guard('admin')->user()->can('trip.details') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        $unit_id = Auth::guard('admin')->user()->unit_id;
        return view('backend.pages.trips.show');
    }
}
