<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use Auth;
use Exception;
use App\Models\User;
use App\Models\Country;
use App\Models\Division;
use App\Models\StructureType;
use App\Models\Contact;
use App\Models\District;
use App\Models\Upazilla;
use App\Models\Category;
use App\Models\Type;
use Illuminate\Support\Facades\Hash;
use App\Models\Site;
use App\Models\Project;
use App\Models\SiteType;
use App\Helpers\UploadHelper;
use App\Helpers\ImageUploadHelper;
use App\Models\SiteReference;
use Yajra\DataTables\Facades\DataTables;
use Image;

class SitesController extends Controller
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
    // public function index()
    // {
    //     if (!Auth::guard('admin')->user()->can('sites.view') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
    //         abort(403, 'Unauthorized action.');
    //     }

    //     $unit_id = Auth::guard('admin')->user()->unit_id;

    //     if (Auth::guard('admin')->user()->is_central_admin = 1) {
    //         $sites = Site::orderBy('id', 'desc')->get();
    //     } else {
    //         $sites = Site::where('unit_id', $unit_id)->orderBy('id', 'desc')->get();
    //     }

    //     return view('backend.pages.sites.index', compact('sites'));
    // }
    
     public function index()
    {
        if (!Auth::guard('admin')->user()->can('projects.view') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

         $unit_id = Auth::guard('admin')->user()->unit_id;

       if (request()->ajax()) {

            if (Auth::guard('admin')->user()->is_central_admin = 1) {
                $sites = Site::join('structure_types','sites.structure_type_id','=','structure_types.id')
                            ->join('contacts','sites.created_by','=','contacts.id')
                            ->orderBy('sites.id', 'desc')
                            ->select(
                                    'sites.id',
                                    'sites.name as sitename',
                                    'sites.owner_name as owner',
                                    'sites.owner_phone_no as phone',
                                    'sites.address as address',
                                    'structure_types.name as structure_type',
                                    'contacts.name as name',
                                    'sites.created_at as time',
                                    'sites.created_by'

                            );
                            // ->get();
                            // ->groupBy('projects.id');
                            // dd($projects);
            } else {
                $sites = Site::join('structure_types','sites.structure_type_id','=','structure_types.id')
                            ->join('contacts','sites.created_by','=','contacts.id')
                            ->orderBy('sites.id', 'desc')
                            ->select(
                                    'sites.id',
                                    'sites.name as sitename',
                                    'sites.owner_name as owner',
                                    'sites.owner_phone_no as phone',
                                    'sites.address as address',
                                    'structure_types.name as structure_type',
                                    'contacts.name as name',
                                    'sites.created_at as time',
                                    'sites.created_by'

                            );
                           // ->groupBy('orders.id');
                           // ->get();
            
            }

          // dd($sites->get());
            if (!empty(request()->created_by)) {
                $sites->where('sites.created_by', request()->created_by);
            }
            
             if (!empty(request()->st_type)) {
                $sites->where('structure_types.id', request()->st_type);
            }
            
            // // if (!empty(request()->status)) {
            // //     if(request()->status == 2){
            // //         request()->status = 0;
            // //     }
            // //     $projects->where('projects.status', request()->status);
            // // }

            //  if (!empty(request()->start_date) && !empty(request()->end_date)) {
            //     $start = request()->start_date;
            //     $end =  request()->end_date;
            //     $projects->whereDate('sites.created_at', '>=', $start)
            //                 ->whereDate('sites.created_at', '<=', $end);
            // }
            
            // dd($request);
            $sitesData = $sites->get();

            return Datatables::of($sitesData)
               ->addColumn(
                    'action', function($row){
                        $csrf = "".csrf_field()."";
                       return  '<div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                   <a class="dropdown-item" href="' . action('Backend\SitesController@edit',$row->id) . '">
                                        <i class="fa fa-edit"></i> Edit
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
                                    <form action="'.action("Backend\SitesController@destroy",$row->id).'" method="post">'.$csrf.'
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
                            </strong>
                            <br>
                            <span class="badge badge-primary">
                              '.$row->structure_type.'
                            </span>';
                      
                })
                ->editColumn('owner', function ($row){
                    return '<strong>Owner:</strong>'.$row->owner.' 
                            <br>
                            <strong>Phone:</strong> '.$row->phone.'
                            <br>
                            <strong>Address:</strong> '.$row->address.'';
                })
                ->editColumn('name',function($row){
                    
                    return '<a href="'.action('Backend\ContactsController@show', $row->created_by).'" target="_blank">
                                 '.$row->name.' 
                            </a>
                            <br>
                            <strong>Visit Time: </strong>
                            <br>
                            '.\Carbon\Carbon::parse($row->time)->isoFormat('LLLL').'
                            <br>';

                })

                
                ->rawColumns(['sitename', 'owner','action','name','structure_type' ]) ->make(true);
            // dd($orders);
        }

        $types=StructureType::pluck('name','id');
        $contacts=Contact::where('unit_id',$unit_id)
              ->pluck('name','id');
              
        return view('backend.pages.sites.index')->with(compact('types','contacts'));
    }

     /**
     * create()
     * 
     * Create  sites 
     *
     * @param int $id
     * @return void
     */
    public function create(){
         if (!Auth::guard('admin')->user()->can('sites.create')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }
        $unit_id = Auth::guard('admin')->user()->unit_id;

        $contacts=Contact::where('unit_id',$unit_id)->orderBy('id','desc')->get();
        $st_type=StructureType::orderBy('id','desc')->get();

        return view('backend.pages.sites.create')->with(compact('contacts','st_type'));
        }   

    /**
     * activate()
     * 
     * Activate or inactivate sites account
     *
     * @param int $id
     * @return void
     */
    public function activate($id)
    {
        if (!Auth::guard('admin')->user()->can('sites.activate')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }


        $site = Site::find($id);
        $message = "Site Not found !!";
        $messageType = "error";
        if (!is_null($site)) {
            if (($site->unit_id != Auth::guard('admin')->user()->unit_id) && (Auth::guard('admin')->user()->is_central_admin != 1)) {
                abort(403, 'Unauthorized action. You can not edit other unit sites');
            }

            if ($site->status == 0) {
                $site->status =  1;
                $message = "Site account has been activated !!";
            } else {
                $site->status =  0;
                $site->save();
                $messageType = "error";
                $message = "Site account has been deactivated !!";
            }
            $site->save();
        }
        session()->flash($messageType, $message);
        return back();
    }

    /**
     * Store.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request){
        if (!Auth::guard('admin')->user()->can('sites.create')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

    //      $request->validate([
    //   'name'         => 'required|max:150',
    //   'structure_type_id'  => 'required',
    //   'created_by'  => 'required',
      
    // ]);
    
     try {

           $sites=new Site();
           $sites->name=$request->name;
           $sites->unit_id=Auth::guard('admin')->user()->unit_id;
           $sites->structure_type_id=$request->st_type;
           $sites->created_by=$request->created_by;
           $sites->owner_name=$request->owner_name;
           $sites->owner_phone_no=$request->owner_phone_no;
           $sites->address=$request->address;
           $sites->status=$request->status;
           $sites->save();
           session()->flash('success', 'Site has created successfully !!');
           return redirect()->route('admin.sites.index');
           
     } catch (\Exception $e) {
            // session()->flash('db_error', 'Error On: '."File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            session()->flash('db_error', $e->getMessage());
            DB::rollBack();
            return back();
        }
    }

     /**
     * Edit.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

   public function edit($id){
        if (!Auth::guard('admin')->user()->can('sites.edit')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }
        $unit_id = Auth::guard('admin')->user()->unit_id;

        $sites=Site::find($id);
        $contacts=Contact::where('unit_id',$unit_id)->orderBy('id','desc')->get();
        $st_type=StructureType::orderBy('id','desc')->get();

        if(!is_null($sites)){
            return view('backend.pages.sites.edit')->with(compact('sites','st_type','contacts'));
        }else{
            session()->flash('error', 'Something is wrong!!');
        }

    return view('backend.pages.sites.edit');
   }

    /**
     *Update.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id){
         if (!Auth::guard('admin')->user()->can('sites.edit')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }


    $request->validate([
      'name'         => 'required',
      'owner_name'   => 'required',
      'owner_phone_no'   => 'required',
      'address'   => 'required',
    
    ]);

        $site=Site::find($id);
        $site->name=$request->name;
        $site->unit_id=Auth::guard('admin')->user()->unit_id;
        $site->structure_type_id=$request->st_type;
        $site->created_by=$request->created_by;
        $site->owner_name=$request->owner_name;
        $site->owner_phone_no=$request->owner_phone_no;
        $site->address=$request->address;
        $site->status=$request->status;
        $site->save();

        session()->flash('success', 'Site has updated successfully !!');
        return redirect()->route('admin.sites.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Auth::guard('admin')->user()->can('sites.view')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }
        $unit_id = Auth::guard('admin')->user()->unit_id;

        $site = Site::find($id);
        $message = "Site Not found !!";
        $messageType = "error";
        if (!is_null($site)) {
            if (($site->unit_id != Auth::guard('admin')->user()->unit_id) && (Auth::guard('admin')->user()->is_central_admin != 1)) {
                abort(403, 'Unauthorized action. You can not show other unit site details');
            }
            $contact=Contact::where('unit_id',$unit_id)->get();
            return view('backend.pages.sites.show', compact('site','contact'));
        }
        session()->flash($messageType, $message);
        return back();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Auth::guard('admin')->user()->can('sites.delete') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        $site = Site::find($id);
        $message = "Site Not found !!";
        $messageType = "error";
        if (!is_null($site)) {
            if (($site->unit_id != Auth::guard('admin')->user()->unit_id) && (Auth::guard('admin')->user()->is_central_admin != 1)) {
                abort(403, 'Unauthorized action. You can not delete other unit sites');
            }

            // Delete site references
            DB::table('projects')->where('site_id', $id)->delete();

            $site->delete();
            $message = 'Site Information has been deleted successfully !';
            $messageType = "success";
            session()->flash($messageType, $message);
        } else {
            session()->flash($messageType, $message);
        }

        return back();
    }
}
