<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Complain;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Project;
use App\Models\TestReport;
use App\Models\BrandRequisition;
use App\Models\Site;
use Illuminate\Support\Facades\Auth;
use DB;

class PagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * index()
     * 
     * Return the SuperAdmin Dashboard Page 
     * 
     * @return view
     */
    public function index()
    {
        $unit_id = Auth::guard('admin')->user()->unit_id;
        
        if(Auth::guard('admin')->user()->username == 'testakij'){
            return redirect('https://crm.akij.net/all-users?installed=no');
        }

        if (Auth::guard('admin')->user()->is_central_admin = 1) {
            $total_contacts = count(Contact::orderBy('id', 'desc')
                ->select('id')
                ->get());

            $total_pending_contacts = count(Contact::orderBy('id', 'desc')
                ->where('status', 0)
                ->select('id')
                ->get());

            $total_sites = count(Site::orderBy('id', 'desc')
                ->select('id')
                ->get());

            $total_pending_sites = count(Site::orderBy('id', 'desc')
                ->where('status', 0)
                ->select('id')
                ->get());

            $total_projects = count(Project::orderBy('id', 'desc')
                ->select('id')
                ->get());
                
            $total_pending_projects = count(Project::orderBy('id', 'desc')
                ->where('unit_id', $unit_id)
                ->where('status', 0)
                ->select('id')
                ->get());

            $total_orders = count(Order::orderBy('id', 'desc')
                ->select('id')
                ->get());

            $total_pending_orders = count(Order::orderBy('id', 'desc')
                ->where('status', 0)
                ->select('id')
                ->get());

            $total_complains = count(Complain::orderBy('id', 'desc')
                ->select('id')
                ->get());

            $total_pending_complains = count(Complain::orderBy('id', 'desc')
                ->where('status', 0)
                ->select('id')
                ->get());

            $total_test_report = count(TestReport::orderBy('id', 'desc')
                ->select('id')
                ->get());

            $brand_requisition = count(BrandRequisition::orderBy('id', 'desc')
                ->select('id',
                        'item_requisition_id')
                ->get());
        } else {
            $total_contacts = count(Contact::orderBy('id', 'desc')
                ->where('unit_id', $unit_id)
                ->select('id')
                ->get());

            $total_pending_contacts = count(Contact::orderBy('id', 'desc')
                ->where('unit_id', $unit_id)
                ->where('status', 0)
                ->select('id')
                ->get());

            $total_sites = count(Site::orderBy('id', 'desc')
                ->where('unit_id', $unit_id)
                ->select('id')
                ->get());

            $total_pending_sites = count(Site::orderBy('id', 'desc')
                ->where('unit_id', $unit_id)
                ->where('status', 0)
                ->select('id')
                ->get());

            $total_projects = count(Project::orderBy('id', 'desc')
                ->where('unit_id', $unit_id)
                ->select('id')
                ->get());

            $total_orders = count(Order::orderBy('id', 'desc')
                ->where('unit_id', $unit_id)
                ->select('id')
                ->get());
                
            $total_pending_projects = count(Project::orderBy('id', 'desc')
                ->where('unit_id', $unit_id)
                ->where('status', 0)
                ->select('id')
                ->get());

            $total_pending_orders = count(Order::orderBy('id', 'desc')
                ->where('unit_id', $unit_id)
                ->where('status', 0)
                ->select('id')
                ->get());

            $total_complains = count(Complain::orderBy('id', 'desc')
                ->where('unit_id', $unit_id)
                ->select('id')
                ->get());

            $total_pending_complains = count(Complain::orderBy('id', 'desc')
                ->where('unit_id', $unit_id)
                ->where('status', 0)
                ->select('id')
                ->get());

            $total_test_report = count(TestReport::orderBy('id', 'desc')
                ->where('unit_id',$unit_id)
                ->select('id')
                ->get());
            $brand_requisition = count(BrandRequisition::orderBy('id', 'desc')
                ->where('unit_id',$unit_id)
                ->select('id',
                          'item_requisition_id')
                ->get());
            $total_test_report = count(TestReport::orderBy('id', 'desc')
                ->where('unit_id',$unit_id)
                ->select('id')
                ->get());
        }

        return view('backend.pages.index', compact('total_contacts', 'total_pending_contacts', 'total_pending_projects', 'total_sites', 'total_pending_sites', 'total_projects', 'total_orders', 'total_pending_orders', 'total_complains', 'total_pending_complains','total_test_report','brand_requisition'));
    }
    
    public function testfunction(Request $request){
        
        // $site=\App\Models\Site::orderBy('id','desc')
        //      ->select('id','name','status');
        // // var_dump($site);
        // // die();
        // $allSite=$site->get();
        // dd($allSite);
        
        $site=DB::table('sites')
            ->select('sites.id','sites.name','sites.status')
            ->get();
        // dd($site);
        
        foreach($site as $s){
            $status=$s->status;
            if($status == 0 && !is_null($status)){
            $status=1;
            
            DB::table('sites')
               ->update(['status' =>$status]);
            
        }
            
        }
        echo 'all done';
        
    }
}
