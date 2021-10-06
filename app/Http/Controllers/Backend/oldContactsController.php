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
use App\Models\District;
use App\Models\Upazilla;
use App\Models\Category;
use App\Models\Type;
use Illuminate\Support\Facades\Hash;
use App\Models\Contact;
use App\Models\ContactType;
use App\Helpers\UploadHelper;
use App\Helpers\ImageUploadHelper;
use App\Models\ContactReference;
use Yajra\DataTables\Facades\DataTables;

use Image;

class ContactsController extends Controller
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
       if (!Auth::guard('admin')->user()->can('contacts.view')) {
            abort(403, 'Unauthorized action.');
        }


        $unit_id = Auth::guard('admin')->user()->unit_id;

         if (request()->ajax()) {

            if (Auth::guard('admin')->user()->is_central_admin = 1) {
                $contacts = Contact::orderBy('id', 'desc')
                            ->select(
                                'contacts.id as id',
                                'name',
                                'designation',
                                'email',
                                'phone_no',
                                'status'

                            )
                            ->get();
            } else {
                $contacts = Contact::where('unit_id', $unit_id)
                           ->orderBy('id', 'desc')
                           ->select(
                                'contacts.id as id',
                                'name',
                                'designation',
                                'email',
                                'phone_no',
                                'status'
                            )
                           ->get();
            }



            $datatable = Datatables::of($contacts)
                ->addColumn(
                    'action', function($row){
                        $csrf = "".csrf_field()."";
                        $html = '<div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    
                                    <a class="dropdown-item" href="' . action('Backend\ContactsController@show', [$row->id]) . '">
                                        <i class="fa fa-eye"></i> View
                                    </a>

                                    <a class="dropdown-item" href="#deleteModal'.$row->id .'"
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
                                    <form action="'.action("Backend\ContactsController@destroy",$row->id).'" method="post">'.$csrf.'
                                        <button type="submit" class="btn btn-outline-success"><i
                                                class="fa fa-check"></i> Confirm Delete</button>
                                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i
                                                class="fa fa-times"></i> Close</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> 
                            ';
                        return $html;
                    })

                ->editColumn('name', function ($row){
                    return ''.$row->name.'<br>
                    <a href="tel:{{ $phone_no }}" class="btn btn-info btn-icon"> <i class="fa fa-phone"></i> </a> 
                        <a href="mailto:{{ $email }}" class="btn btn-danger btn-icon">
                          <i class="fa fa-envelope"></i>
                            </a>
                    ';
                })

                ->editColumn('designation', function ($row){
                    return '<strong>Designation:</strong>'.$row->designation.' 
                            <br>
                            <strong>Email:</strong> '.$row->email.'
                            <br>
                            <strong>Phone:</strong> '.$row->phone_no.'';
                })

                ->editColumn('email', function ($row){
                    return '<strong>Email:</strong> '.$row->email.'';
                })

                

                ->editColumn('status',function($row){
                    $title = "Activate";
                    $class = "btn btn-success";
                    $csrf = "".csrf_field()."";

                    if($row->status){
                        $title = "De-Activate";
                        $class = "btn btn-danger";
                    }

                    return '<form action="'.action("Backend\ContactsController@activate",$row->id).'" onsubmit="return confirm(Do you want to change the contacts status ?)" method="post">'.$csrf.'
                                    
                                        <button type="submit" class="'.$class.'">'.$title.'</button>
                             </form>';
                 });
                

                $rawColumns = ['name', 'action', 'designation', 'email', 'phone_no','status'];
                
                return $datatable->rawColumns($rawColumns)
                      ->make(true);
        }
    

     

        return view('backend.pages.contacts.index');
    }

    /**
     * activate()
     * 
     * Activate or inactivate contacts account
     *
     * @param int $id
     * @return void
     */
    public function activate($id)
    {
        if (!Auth::guard('admin')->user()->can('contacts.activate')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

         // dd($request->status);
        $contact = Contact::find($id);
        $message = "Contact Not found !!";
        $messageType = "error";
        if (!is_null($contact)) {
            if (($contact->unit_id != Auth::guard('admin')->user()->unit_id) && (Auth::guard('admin')->user()->is_central_admin != 1)) {
                abort(403, 'Unauthorized action. You can not edit other unit contacts');
            }

            if ($contact->status == 0) {
                $contact->status =  1;
                $message = "Contact account has been activated !!";
            } else {
                $contact->status =  0;
                $messageType = "error";
                $message = "Contact account has been deactivated !!";
            }
            $contact->save();
        }
        session()->flash($messageType, $message);
        return back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        // if($request->ajaxt()){
        $request->validate([
            'name'  => 'required|max:100',
            'name_bn'  => 'required|max:100',
            'contact_email'  => 'required|email|max:100|unique:contacts,email',
            'country_id'  => 'required',
            'district_id'  => 'required',
            'upazilla_id'  => 'required',
            'category_id'  => 'required',
            'address'  => 'required|max:190',
            'address_bn'  => 'nullable|max:190',
            'business_description'  => 'nullable|max:190',
            'business_trade_licence'  => 'nullable|max:190',
            'business_rl_no'  => 'nullable|max:50',
            'website'  => 'nullable|url|max:50',
            'logo'  => 'nullable|image|max:100',
            'password'  => 'required|confirmed|min:6|max:20',
        ]);

        try {
            DB::beginTransaction();
            $contact = new Contact();
            $contact->name = $request->name;
            $contact->name_bn = $request->name_bn;
            $contact->country_id = $request->country_id;
            $contact->district_id = $request->district_id;
            $contact->division_id = District::find($request->district_id)->division_id;
            $contact->upazilla_id = $request->upazilla_id;
            $contact->category_id = $request->category_id;
            $contact->address = $request->address;
            $contact->address_bn = $request->address_bn;
            $contact->business_description = $request->business_description;
            $contact->business_trade_licence = $request->business_trade_licence;
            $contact->business_rl_no = $request->business_rl_no;
            $contact->website = $request->website;
            $contact->email = 'test@gmail.com';
            $contact->password = Hash::make($request->password);
            $contact->api_token = bin2hex(openssl_random_pseudo_bytes(40));
            $contact->save();

            // New Contact Information for this contact
            $contact = new Contact();
            $contact->name = $request->contact_name;
            $contact->email = $request->contact_email;
            $contact->phone = $request->contact_phone;
            $contact->designation = $request->contact_designation;
            $contact->contact_id = $contact->id;
            $contact->is_primary_contact  = 1;
            $contact->save();

            // If there is any logo then save it
            $contact->logo = ImageUploadHelper::upload('logo', $request->file('logo'), time(), 'public/img/companies');

            $contact->email =  $request->contact_email;
            $contact->save();

            // Save contacts types
            if (count($request->types) <= 20) {
                foreach ($request->types as $type) {
                    $contact_type = new ContactType();
                    $contact_type->contact_id = $contact->id;
                    $contact_type->type_id = $type;
                    $contact_type->save();
                }
            } else {
                throw new Exception('Please give types less than or equal twenty types. ');
            }

            DB::commit();
            session()->flash('success', 'New Contact Information has been saved successfully !!');
            return redirect()->route('admin.contacts.index');
        } catch (\Exception $e) {
            // session()->flash('db_error', 'Error On: '."File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            session()->flash('db_error', $e->getMessage());
            DB::rollBack();
            return back();
        }

    // }
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Auth::guard('admin')->user()->can('contacts.view')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }



        $contact = Contact::find($id);
        $message = "Contact Not found !!";
        $messageType = "error";
        if (!is_null($contact)) {
            if (($contact->unit_id != Auth::guard('admin')->user()->unit_id) && (Auth::guard('admin')->user()->is_central_admin != 1)) {
                abort(403, 'Unauthorized action. You can not show other unit contact details');
            }
            return view('backend.pages.contacts.show', compact('contact'));
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
        if (!Auth::guard('admin')->user()->can('contacts.delete') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        $contact = Contact::find($id);
        $message = "Contact Not found !!";
        $messageType = "error";
        if (!is_null($contact)) {
            if (($contact->unit_id != Auth::guard('admin')->user()->unit_id) && (Auth::guard('admin')->user()->is_central_admin != 1)) {
                abort(403, 'Unauthorized action. You can not delete other unit contacts');
            }

            // Delete contact references
            DB::table('contact_reference')->where('contact_id', $id)->delete();

            $contact->delete();
            $message = 'Contact Information has been deleted successfully !';
            $messageType = "success";
            session()->flash($messageType, $messageType);
        } else {
            session()->flash($messageType, $message);
        }

        return back();
    }
}
