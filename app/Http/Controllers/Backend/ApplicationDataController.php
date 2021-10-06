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
use Yajra\DataTables\Facades\DataTables;

class ApplicationDataController extends Controller
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
    public function loginStatistics(Request $request)
    {
        if (!Auth::guard('admin')->user()->can('login_attempts.view') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        if (Auth::guard('admin')->user()->is_central_admin = 1) {
            if(isset($request->groupBy)){
                $login_attempts = DB::table('login_attempts')
                ->groupBy('user_name')
                ->orderBy('id', 'desc')
                ->get();
            }elseif($request->not_installed){
                $employees = DB::table('erp_employees')->get();
                return view('backend.pages.statistics.not_installed', compact('$employees'));
            }
            else{
                $login_attempts = DB::table('login_attempts')->orderBy('id', 'desc')->get();
            }
        }

        return view('backend.pages.statistics.index', compact('login_attempts'));
    }
    
    public function loginNotInstalled(Request $request)
    {
        
        if (!Auth::guard('admin')->user()->can('login_attempts.view') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        if (Auth::guard('admin')->user()->is_central_admin = 1) {
            $employees = DB::table('erp_employees')->get();
            return view('backend.pages.statistics.not_installed', compact('employees'));
        }

    }

}
