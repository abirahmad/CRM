<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\Models\Project;
use App\Models\Site;
use App\Models\Contact;
use App\Models\StructureType;
use App\Models\RewardPoint;
use Yajra\DataTables\Facades\DataTables;
use DB;


class ProjectsController extends Controller
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
     public function index()
    {
        if (!Auth::guard('admin')->user()->can('projects.view') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

         $unit_id = Auth::guard('admin')->user()->unit_id;

       if (request()->ajax()) {

            if (Auth::guard('admin')->user()->is_central_admin = 1) {
                $projects = Project::join('sites','projects.site_id','=','sites.id')
                            // ->join('structure_types','projects.structure_type_id','=','structure_types.id')
                            ->join('contacts','projects.created_by','=','contacts.id')
                            ->orderBy('projects.id', 'desc')
                            ->select(
                                    'projects.id',
                                    'sites.name as sitename',
                                    'sites.owner_name as owner',
                                    'sites.owner_phone_no as phone',
                                    'sites.address as address',
                                    // 'structure_types.name as st_type ',
                                    'projects.size as size',
                                    'projects.product_usage_qty as usage',
                                    'projects.comment',
                                    'projects.status',
                                    'contacts.name as name',
                                    'projects.created_at as time',
                                    'projects.created_by'



                            );
                            // ->get();
                            // ->groupBy('projects.id');
                            // dd($projects);
            } else {
                $projects = Project::where('unit_id', $unit_id)
                            ->join('sites','projects.site_id','=','sites.id')
                            ->join('structure_types','projects.structure_type_id','=','structure_types.id')
                            ->join('contacts','prjects.created_by','=','contacts.id')
                            ->orderBy('projects.id', 'desc')
                           ->select(
                                    'projects.id',
                                    'sites.name as sitename',
                                    'sites.owner_name as owner',
                                    'sites.owner_phone_no as phone',
                                    'sites.address as address',
                                    // 'structure_types.name as st_type',
                                    'projects.size as size',
                                    'projects.product_usage_qty as usage',
                                    'projects.comment',
                                    'projects.status ',
                                    'contacts.name as name',
                                    'projects.created_at as time',
                                    'projects.created_by'


                            );
                           // ->groupBy('orders.id');
                           // ->get();
            
            }

          if (!empty(request()->site_id)) {
                $projects->where('projects.site_id', request()->site_id);
            }
            if (!empty(request()->created_by)) {
                $projects->where('projects.created_by', request()->created_by);
            }
            
            if (!empty(request()->status)) {
                if(request()->status == 2){
                    request()->status = 0;
                }
                $projects->where('projects.status', request()->status);
            }

             if (!empty(request()->start_date) && !empty(request()->end_date)) {
                $start = request()->start_date;
                $end =  request()->end_date;
                $projects->whereDate('projects.created_at', '>=', $start)
                            ->whereDate('projects.created_at', '<=', $end);
            }
            
            // dd($request);
            $projectDatas = $projects->get();

            return Datatables::of($projectDatas)
                 ->addColumn(
                    'action', function($row){
                        $csrf = "".csrf_field()."";
                       return  '<div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                   <a class="dropdown-item" href="' . route('admin.projects.edit',$row->id) . '">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    
                                    <a class="dropdown-item" href="' . action('Backend\ProjectsController@show',$row->id) . '">
                                        <i class="fa fa-eye"></i> View
                                    </a>

                                    <a class="dropdown-item" href="#deleteModal'.$row->id.'"
                                        data-toggle="modal"><i class="fa fa-trash"></i> Delete</a>
                                </div>
                            </div>
                            <div class="modal fade delete-modal" id=deleteModal'.$row->id.'  tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Are you sure to delete ?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <div class="modal-body">
                                    <p>
                                        contact all informations (contact profile and contacts) will be deleted. Please
                                        be sure
                                        first to delete.
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <form action="'.action("Backend\ProjectsController@destroy",$row->id).'" method="post">'.$csrf.'
                                        <button type="submit" class="btn btn-outline-success"><i
                                                class="fa fa-check"></i> Confirm Delete</button>
                                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i
                                                class="fa fa-times"></i> Close</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>  ';
                    
                    })

                ->editColumn('sitename', function ($row){
                    return '<strong class="text-primary">'.$row->sitename.'
                            </strong>';
                      
                })
                ->editColumn('name',function($row){
                    
                    return '<a href="'.action('Backend\ContactsController@show', $row->created_by).'" target="_blank">
                                 '.$row->name.'</a>';
                })

                ->editColumn('status',function($row){
                    // return $row->status;
                    $title = "Pending";
                    $class = "btn btn-danger";
                    $csrf = "".csrf_field()."";
                    $disabled="";
                   $alert="confirm('Do you want to change the contacts status ?')";
                    if($row->status){
                        $title = "Approved";
                        $class = "btn btn-success";
                        $disabled="disabled";
                    }
                    return '<form action="'.action("Backend\ProjectsController@activate",$row->id).'"  onsubmit="'.$alert.'"  method="post">'.$csrf.'
                                    
                                        <button type="submit" class="'.$class.'" value="'.$row->created_by.'" '.$disabled.'>'.$title.'</button>          
                             </form>';

                 })
                ->rawColumns(['sitename', 'name', 'status','action']) 
                      ->make(true);
            // dd($orders);
        }

        $sites=Site::where('unit_id',$unit_id)
               ->pluck('name','id');
        $contacts=Contact::where('unit_id',$unit_id)
               ->pluck('name','id');
        $status=Project::where('unit_id',$unit_id)
               ->pluck('status');
               // dd($contacts);
        return view('backend.pages.projects.index')->with(compact('sites','contacts','status'));
    }


      public function activate(Request $request, $id)
    {
        if (!Auth::guard('admin')->user()->can('orders.activate')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }
        
        $project = Project::find($id);
        $message = "Project Not found !!";
        $messageType = "error";
        if (!is_null($project)) {
            if (($project->unit_id != Auth::guard('admin')->user()->unit_id) && (Auth::guard('admin')->user()->is_central_admin != 1)) {
                abort(403, 'Unauthorized action. You can not edit other unit orders');
            }
            $project->get();

            if ($project->status == 0) {
                $project->status =  1;
                $reward = RewardPoint::where('contact_id', $project->created_by)
                ->where('project_id', $project->id)
                ->first();

                if(is_null($reward)){
                    $reward = new RewardPoint();
                }

                
                $reward->contact_id=$project->created_by;
                $reward->project_id=$project->id;
                $reward->point+=$project->product_usage_qty;
                $reward->given_by=Auth::id();
                $reward->point=$project->product_usage_qty;
                $reward->save();

                $contact=Contact::where('id',$project->created_by)->first();
                $contact->total_reward_point += $project->product_usage_qty;
                $contact->save();
                $message = "Project has been Approved !!";
            } else {
                $project->status =  0;
                $messageType = "error";
                $message = "This is an error !!";
            }
          $project->save();
         
            
        }
        session()->flash($messageType, $message);
        return back();
    }
    
    
    //Product Create Function

    public function create(){
         if (!Auth::guard('admin')->user()->can('projects.create')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }
        $unit_id = Auth::guard('admin')->user()->unit_id;

        $contacts=Contact::where('unit_id',$unit_id)->orderBy('id','desc')->get();
        $st_type=StructureType::orderBy('id','desc')->get();
        $sites=Site::where('unit_id',$unit_id)->orderBy('id','desc')->get();

        return view('backend.pages.projects.create')->with(compact('contacts','st_type','sites'));
        } 


  //Product Store Function

    public function store(Request $request){
        if (!Auth::guard('admin')->user()->can('projects.create') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }
	
	
        $site = Site::find($request->site);
        $projects= new Project();
        
        $projects->site_id=$site->id;
        $projects->unit_id=Auth::guard('admin')->user()->unit_id;
        $projects->responsible_name=$site->owner_name;
        $projects->responsible_phone_no=$site->owner_phone_no;
        // $projects->structure_type_id=$request->st_type;
        $projects->structure_type_id=$site->structure_type_id;
        // $projects->created_by=$request->created_by;
        $projects->created_by=$site->created_by;
        
        
        $projects->size=$request->size;
        $projects->type=$request->type;
        $projects->product_usage_qty=$request->product_usage_qty;
        $projects->comment=$request->comment;
        $projects->status=$request->status;
        $projects->save();
        
        
        if($projects->status == 1){
        	$reward = RewardPoint::where('contact_id', $projects->created_by)
                ->where('project_id', $projects->id)
                ->first();

                if(is_null($reward)){
                    $reward = new RewardPoint();
                }

                
                $reward->contact_id=$projects->created_by;
                $reward->project_id=$projects->id;
                $reward->point+=$projects->product_usage_qty;
                $reward->given_by=Auth::id();
                $reward->point=$projects->product_usage_qty;
                $reward->save();

                $contact=Contact::where('id',$projects->created_by)->first();
                $contact->total_reward_point += $projects->product_usage_qty;
                $contact->save();
        }
        

        session()->flash('success', 'Project has created successfully !!');
        return redirect()->route('admin.projects.index');


    }
    
    //Project Edit function

    public function edit($id){
        if (!Auth::guard('admin')->user()->can('projects.edit') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        $unit_id=Auth::guard('admin')->user()->unit_id;

        $contacts=Contact::where('unit_id',$unit_id)->orderBy('id','desc')->get();

        $st_type=StructureType::orderBy('id','desc')->get();
        $project=Project::find($id);

        $sites=Site::where('unit_id',$unit_id)->orderBy('id','desc')->get();

        return view('backend.pages.projects.edit')->with(compact('contacts','st_type','sites', 'project'));

    }
    
    /**
     *Update.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id){
         if (!Auth::guard('admin')->user()->can('projects.edit')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }



        $projects= Project::find($id);
        $projects->site_id=$request->site;
        $projects->unit_id=Auth::guard('admin')->user()->unit_id;
        $projects->responsible_name=$request->responsible_name;
        $projects->responsible_phone_no=$request->responsible_phone_no;
        $projects->type=$request->type;
        $projects->structure_type_id=$request->st_type;
        $projects->created_by=$request->created_by;
        $projects->size=$request->size;
        $projects->product_usage_qty=$request->product_usage_qty;
        $projects->comment=$request->comment;
        $projects->status=$request->status;
        $projects->save();
        

        session()->flash('success', 'Project has updated successfully !!');
        return redirect()->route('admin.projects.index');
    }
    
    
    //Project delete function

    public function destroy($id)
    {
        if (!Auth::guard('admin')->user()->can('projects.delete') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        $project = Project::find($id);
        $message = "Site Not found !!";
        $messageType = "error";
        if (!is_null($project)) {
            if (($project->unit_id != Auth::guard('admin')->user()->unit_id) && (Auth::guard('admin')->user()->is_central_admin != 1)) {
                abort(403, 'Unauthorized action. You can not delete other unit sites');
            }

            // Delete site references
            DB::table('reward_points')->where('project_id', $id)->delete();

            $project->delete();
            $message = 'Project Information has been deleted successfully !';
            $messageType = "success";
            session()->flash($messageType, $message);
        } else {
            session()->flash($messageType, $message);
        }

        return back();
    }
    
  public function resolvePoints(){
        $contacts = Contact::select('id')->get();
        foreach($contacts as $contact){

            // Get projects of this contacts
            $projects = Project::select('product_usage_qty')
                        ->where('created_by', $contact->id)
                        ->where('status', 1)
                        ->get();
                        
            $total_reward_point = 0;
            foreach($projects as $project){
                $total_reward_point += intval($project->product_usage_qty);
            }
            // $total_reward_point = $projects->sum('product_usage_qty');
            $contact->total_reward_point = $total_reward_point;
            $contact->save();
        }
    }
    
    public function bulkProjectApprove(Request $request){
        DB::table('projects')->update(['status' => 1]);
        DB::table('sites')->update(['status' =>1]);
        $this->resolvePoints();
        session()->flash('success', 'Projects has been Approved successfuly !!');
        return redirect()->route('admin.projects.index');

    }
    
}


























