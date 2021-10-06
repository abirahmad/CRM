<?php

namespace App\Http\Controllers\Backend\iApp;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DevicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    
    public function getRegistrationList()
    {
        // if (!Auth::guard('admin')->user()->can('employers.view')) {
        //     abort(403, 'Unauthorized action.');
        // }

        $user = Auth::guard('admin')->user();
        $units = Unit::select('id', 'name', 'code')->get();
        
        if (!empty(request()->unit_id)) {
            $unit_id = request()->unit_id;
        } else {
            $unit_id = Auth::guard('admin')->user()->unit_id;
        }

        
        $file_url = 'http://iapps.akij.net/asll/public/api/v1/statistic/registered-device?intUnitID=' . $unit_id;


        $response = file_get_contents($file_url);
        $data = json_decode($response)->data;

        if (request()->ajax()) {
            $datatable = Datatables::of($data)
                ->addIndexColumn()
                ->addColumn(
                    'action',
                    function ($row) {
                        $csrf = "" . csrf_field() . "";
                        $html = "";
                        // $html = '<div class="dropdown">
                        //             <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        //                     data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        //                     Action
                        //             </button>
                        //             <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        //                 <a class="dropdown-item" href="' . route('admin.trips.show', $row->intID) . '">
                        //                     <i class="fa fa-eye"></i> View
                        //                 </a>
                        //             </div>
                        //         </div> 
                        //     ';
                        return $html;
                    }
                )
                ->editColumn('strDeviceToken', function ($row) {
                    $html = "<textarea style='width: 150px!important;'>";
                    $html .= $row->strDeviceToken;
                    $html .= "</textarea>";
                    return $html;
                })
                ->editColumn('app_version', function ($row) {
                    $html = "<span class='badge badge-info'>";
                    $html .= $row->app_version;
                    $html .= "</span>";
                    return $html;
                })
                // ->editColumn('dteCreatedAt', function ($row) {
                //     $html = "";
                //     $html .= $row->dteCreatedAt;
                //     $html .= "(";
                //     $html .= $row->dteCreatedAt != null ? $row->dteCreatedAt->diffForHumans() : '';
                //     $html .= ")";
                //     return $html;
                // })
                ->editColumn('strUserEmail', function ($row) {
                    $html = "";
                    if(!is_null($row->strUserEmail)){
                        $html .= $row->strUserEmail. '<br/>';
                    }
                    $html .= $row->intUserID;
                    return $html;
                });



            $rawColumns = ['strUserEmail', 'action', 'strDeviceToken', 'strUserName', 'strUserType', 'app_version', 'dteCreatedAt', 'dteUpdatedAt'];

            return $datatable->rawColumns($rawColumns)
                ->make(true);
        }

        return view('backend.pages.iapps.device-registration', compact('user', 'units', 'unit_id'));

    }
}
