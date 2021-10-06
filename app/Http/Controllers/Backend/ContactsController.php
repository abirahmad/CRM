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
use App\Models\Upazila;
use App\Models\Category;
use App\Models\Type;
use App\Models\Site;
use Illuminate\Support\Facades\Hash;
use App\Models\Contact;
use App\Models\ContactType;
use App\Helpers\UploadHelper;
use App\Helpers\ImageUploadHelper;
use App\Helpers\StringHelper;
use App\Models\ContactReference;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

use Image;


class ContactsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        if (!Auth::guard('admin')->user()->can('contacts.view')) {
            abort(403, 'Unauthorized action.');
        }


        $unit_id = Auth::guard('admin')->user()->unit_id;

        if (request()->ajax()) {

            if (Auth::guard('admin')->user()->is_central_admin = 1) {
                $contact = Contact::leftJoin('sites', 'sites.created_by', '=', 'contacts.id')
                    ->leftjoin('districts', 'contacts.district_id', '=', 'districts.id')
                    ->leftjoin('upazilas', 'contacts.upazilla_id', '=', 'upazilas.id')
                    ->leftjoin('contact_reference', 'contact_reference.contact_id', '=', 'contacts.id')
                    ->orderBy('contacts.id', 'asc')
                    ->select(
                        'contacts.id as id',
                        'contacts.name',
                        'designation',
                        'contacts.email as email',
                        'phone_no',
                        'contacts.birthdate as eng_birthdaate',
                        'total_reward_point as reward',
                        'contacts.status',
                        'districts.name as district',
                        'upazilas.name as upazila',
                        'contact_reference.name as wife_name',
                        'contact_reference.birthdate as birthdate',
                        'contact_reference.marriage_date as marriage_date',
                        // 'sites.status as sitestatus',
                        DB::raw("(SELECT COUNT(sites.id) FROM sites
                                        WHERE sites.created_by=contacts.id) as sites"),
                        DB::raw("(SELECT COUNT(sites.status) FROM sites
                                        WHERE sites.created_by=contacts.id AND sites.status=0) as sitestatus")
                    );
                // ->get();

                // $contacts = Contact::query()->with(['sites','contacts.id','=','sites.created_by'])->get();
            } else {
                $contact = Contact::leftjoin('sites', 'contacts.id', '=', 'sites.created_by')
                    ->leftjoin('distrcts', 'contacts.district_id', '=', 'districts.id')
                    ->leftjoin('upazilas', 'contacts.upazilla_id', '=', 'upazilas.id')
                    ->where('unit_id', $unit_id)
                    ->leftjoin('contact_reference', 'contact_reference.contact_id', '=', 'contacts.id')
                    ->orderBy('contacts.id', 'asc')
                    ->select(
                        'contacts.id as id',
                        'contacts.name',
                        'designation',
                        'contacts.email as email',
                        'phone_no',
                        'contacts.birthdate as eng_birthdaate',
                        'total_reward_point as reward',
                        'contacts.status',
                        'districts.name as district',
                        'upazilas.name as upazila',
                        'contact_reference.name as wife_name',
                        'contact_reference.birthdate',
                        'contact_reference.marriage_date',
                        // 'sites.status as sitestatus',
                        DB::raw("(SELECT COUNT(sites.id) FROM sites
                                        WHERE sites.created_by=contacts.id) as sites"),
                        DB::raw("(SELECT COUNT(sites.status) FROM sites
                                        WHERE sites.created_by=contacts.id AND sites.status=0) as sitestatus")
                    );
                // ->get();
            }

            $contacts = $contact->groupBy('contacts.id')->get();

            $datatable = Datatables::of($contacts)
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
                                    <a class="dropdown-item" href="' . action('Backend\ContactsController@edit', [$row->id]) . '">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    
                                    <a class="dropdown-item" href="' . action('Backend\ContactsController@show', [$row->id]) . '">
                                        <i class="fa fa-eye"></i> View
                                    </a>

                                    <a class="dropdown-item" href="#deleteModal' . $row->id . '"
                                        data-toggle="modal"><i class="fa fa-trash"></i> Delete</a>
                                </div>
                            </div>
                            <div class="modal fade delete-modal" id=deleteModal' . $row->id . '  tabindex="-1" role="dialog"
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
                                    <form action="' . action('Backend\ContactsController@destroy', [$row->id]) . '" method="post">' . $csrf . '
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
                    }
                )

                ->editColumn('name', function ($row) {
                    return '' . $row->name . '<br>
                    <a href="tel:{{ $phone_no }}" class="btn btn-info btn-icon"> <i class="fa fa-phone"></i> </a> 
                        <a href="mailto:{{ $email }}" class="btn btn-danger btn-icon">
                          <i class="fa fa-envelope"></i>
                            </a>
                    ';
                })

                ->editColumn('designation', function ($row) {
                    return '<strong>Designation:</strong>' . $row->designation . ' 
                            <br>
                            <strong>Email:</strong> ' . $row->email . '
                            <br>
                            <strong>Phone:</strong> ' . $row->phone_no . '';
                })


                ->editColumn('sites', function ($row) {
                    return '<strong>Total Sites:</strong>' . $row->sites . ' 
                            <br>
                            <strong>Pending:</strong> ' . $row->sitestatus . '';
                })

                // ->editColumn('sites', function ($row){

                //      // if($row->sitestatus==0){
                //      //     $pending +=$row->sitestatus;
                //      // }

                //      return '<strong>Sites: </strong>'.$row->sites.'(Pending:'.$row->sitestatus.')';
                //  })


                ->editColumn('email', function ($row) {
                    return '<strong>Email:</strong> ' . $row->email . '';
                })

                //   ->editColumn('eng_birthdaate', function ($row){
                //     return $row->eng_birthdaate;
                // })
                ->editColumn('status', function ($row) {
                    $title = "Activate";
                    $class = "btn btn-success";
                    $csrf = "" . csrf_field() . "";

                    if ($row->status) {
                        $title = "De-Activate";
                        $class = "btn btn-danger";
                    }

                    return '<form action="' . action("Backend\ContactsController@activate", [$row->id]) . '" onsubmit="return confirm(Do you want to change the contacts status ?)" method="post">' . $csrf . '
                                    
                                        <button type="submit" class="' . $class . '">' . $title . '</button>
                             </form>';
                });



            $rawColumns = ['name', 'action', 'designation', 'email', 'phone_no', 'status', 'sites'];

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
     * Create .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function create()
    {

        $district = District::orderBy('id', 'desc')->get();
        $upazilla = Upazila::orderBy('id', 'desc')->get();
        $contact_type = ContactType::orderBy('id', 'desc')->get();

        return view('backend.pages.contacts.create')->with(compact('district', 'upazilla', 'contact_type'));
    }

    /**
     * Store .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (!Auth::guard('admin')->user()->can('contacts.create') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        // if($request->ajaxt()){
        $request->validate([
            'name'  => 'required|max:100',
            'email'  => 'required|email|max:100|unique:contacts',
            'phone_no'  => 'required',
            'password'  => 'required|confirmed|min:6|max:20',
        ]);

        try {
            DB::beginTransaction();
            $contacts = new Contact();
            $contacts->name = $request->name;
            $contacts->username = StringHelper::createSlug($request->name, 'Contact', 'username', '');
            $contacts->unit_id = Auth::guard('admin')->user()->unit_id;
            $contacts->email = $request->email;
            $contacts->phone_no = $request->phone_no;
            $contacts->password = Hash::make($request->password);
            $contacts->fb_address = $request->fb_address;
            $contacts->designation = $request->designation;
            $contacts->office_name = $request->office_name;
            $contacts->office_address = $request->office_address;
            $contacts->api_token = bin2hex(openssl_random_pseudo_bytes(40));
            $contacts->language = $request->language;
            $contacts->birthdate = $request->birthdate;
            $contacts->status = 1;
            $contacts->total_reward_point = 0;
            $contacts->district_id = $request->dsitrict_id;
            $contacts->upazilla_id = $request->upazilla_id;
            $contacts->contact_type_id = $request->contact_type_id;
            $contacts->created_at = Carbon::now();
            $contacts->updated_at = Carbon::now();

            $contacts->marital_status = $request->marital_status;
            $contacts->save();

            // Store Contact Reference Number

            // Check Reference No

            if (!empty($request->child1_name)) {
                $contactReference = new ContactReference();
                $contactReference->contact_id = $contacts->id;
                $contactReference->name = $request->child1_name;
                $contactReference->relation_type_id = 5; //Child
                $contactReference->birthdate = $request->child1_birthdate;
                $contactReference->save();
            }

            if (!empty($request->child2_name)) {
                $contactReference = new ContactReference();
                $contactReference->contact_id = $contacts->id;
                $contactReference->name = $request->child2_name;
                $contactReference->relation_type_id = 5; //Child
                $contactReference->birthdate = $request->child2_birthdate;
                $contactReference->save();
            }

            if (!empty($request->child3_name)) {
                $contactReference = new ContactReference();
                $contactReference->contact_id = $contacts->id;
                $contactReference->name = $request->child3_name;
                $contactReference->relation_type_id = 5; //Child
                $contactReference->birthdate = $request->child3_birthdate;
                $contactReference->save();
            }

            if (!empty($request->wife_name)) {
                $contactReference = new ContactReference();
                $contactReference->contact_id = $contacts->id;
                $contactReference->name = $request->wife_name;
                $contactReference->relation_type_id = 11; //Wife
                $contactReference->marriage_date = $request->wife_marriage_date;
                $contactReference->save();
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
     * Edit.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        if (!Auth::guard('admin')->user()->can('contacts.edit')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        $contacts = Contact::find($id);
        $upazilla = Upazila::orderBy('id', 'desc')->get();
        $district = District::orderBy('id', 'desc')->get();
        $contact_type = ContactType::orderBy('id', 'desc')->get();

        // if(!is_null())
        $contactReferencesChild1 = ContactReference::where('contact_id', $contacts->id)
            ->where('relation_type_id', 5) // 5 = Child
            ->first();

        $contactReferencesChild2Data = ContactReference::where('contact_id', $contacts->id)
            ->where('relation_type_id', 5) // 5 = Child
            ->orderBy('id', 'asc')
            ->skip(1)
            ->limit(1)
            ->first();

        // dd($contactReferencesChild2Data);

        $contactReferenceWife = ContactReference::where('contact_id', $contacts->id)
            ->where('relation_type_id', 11) // 11 = wife
            ->orderBy('id', 'asc')
            // ->skip(2)
            // ->limit(1)
            ->first();


        // dd($contactReferencesChild2Data);         

        return view('backend.pages.contacts.edit')->with(compact('contacts', 'upazilla', 'district', 'contact_type', 'contactReferencesChild2Data', 'contactReferencesChild1', 'contactReferenceWife'));
    }

    /**
     * Update.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        if (!Auth::guard('admin')->user()->can('contacts.edit')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }
        // if($request->ajaxt()){
        $request->validate([
            'name'  => 'required|max:100',
            'username'  => 'required|max:100',
            // 'email'  => 'required|email|max:100|unique:c',
            'office_address'  => 'required|max:190',
            // 'password'  => 'required|min:6|max:20',
        ]);

        //  try {

        $contacts = Contact::find($id);
        $contacts->name = $request->name;
        $contacts->username = $request->username;
        $contacts->unit_id = Auth::guard('admin')->user()->unit_id;
        $contacts->email = $request->email;
        $contacts->phone_no = $request->phone_no;

        $contacts->fb_address = $request->fb_address;
        $contacts->designation = $request->designation;
        $contacts->office_name = $request->office_name;
        $contacts->office_address = $request->office_address;
        $contacts->api_token = bin2hex(openssl_random_pseudo_bytes(40));
        $contacts->language = $request->language;
        $contacts->birthdate = $request->birthdate;
        $contacts->total_reward_point = 0;
        $contacts->district_id = $request->district_id;
        $contacts->upazilla_id = $request->upazilla_id;
        $contacts->contact_type_id = $request->contact_type_id;
        $contacts->created_at = Carbon::now();
        $contacts->updated_at = Carbon::now();
        $contacts->marital_status = $request->marital_status;
        $contacts->save();

        if ($request->password) {
            $contacts->password = Hash::make($request->password);
            $contacts->save();
        }

        $contactReferencesChild1 = ContactReference::where('contact_id', $contacts->id)
            ->where('relation_type_id', 5) // 5 = Child
            ->first();

        $contactReferencesChild2Data = ContactReference::where('contact_id', $contacts->id)
            ->where('relation_type_id', 5) // 5 = Child
            ->orderBy('id', 'asc')
            ->skip(1)
            ->limit(1)
            ->get();


        if (!empty($request->child1_name)) {
            if (is_null($contactReferencesChild1)) {
                $contactReferencesChild1 = new ContactReference();
            }
            $contactReferencesChild1->contact_id = $contacts->id;
            $contactReferencesChild1->name = $request->child1_name;
            $contactReferencesChild1->relation_type_id = 5; //Child
            $contactReferencesChild1->birthdate = $request->child1_birthdate;
            $contactReferencesChild1->save();
        }

        if (!empty($request->child2_name)) {
            if ($contactReferencesChild2Data) {
                $contactReferencesChild2 = new ContactReference();
            } else {
                foreach ($contactReferencesChild2Data as $contactReferencesChild2) {
                }
            }

            $contactReferencesChild2->contact_id = $contacts->id;
            $contactReferencesChild2->name = $request->child2_name;
            $contactReferencesChild2->relation_type_id = 5; //Child
            $contactReferencesChild2->birthdate = $request->child2_birthdate;
            $contactReferencesChild2->save();
        }



        // if (!empty($request->child3_name)) {
        //         if(count($contactReferencesChild3Data) == 0){
        //             $contactReferencesChild3 = new ContactReference();
        //         }else{
        //             foreach($contactReferencesChild3Data as $contactReferencesChild3){}
        //         }
        //         $contactReferencesChild3->contact_id = $contact->id;
        //         $contactReferencesChild3->name = $request->child3_name;
        //         $contactReferencesChild3->relation_type_id = 5; //Child
        //         $contactReferencesChild3->birthdate = $request->child3_birthdate;
        //         $contactReferencesChild3->save();
        // }
        $contactReferenceWife = ContactReference::where('contact_id', $contacts->id)
            ->where('relation_type_id', 11) // 11 = Wife
            ->first();



        if (!empty($request->wife_name)) {
            if (is_null($contactReferenceWife)) {
                $contactReferenceWife = new ContactReference();
            }
            $contactReferenceWife->contact_id = $contacts->id;
            $contactReferenceWife->name = $request->wife_name;
            $contactReferenceWife->relation_type_id = 11; //Wife
            $contactReferenceWife->marriage_date = $request->wife_marriage_date;
            $contactReferenceWife->save();
        }

        session()->flash('success', 'New Contact Information has been saved successfully !!');

        return redirect()->route('admin.contacts.index');

        //  } catch (\Exception $e) {
        //     // session()->flash('db_error', 'Error On: '."File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
        //     session()->flash('db_error', $e->getMessage());
        //     DB::rollBack();
        //     return back();
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

            $sites = count(Site::orderBy('id', 'desc')
                ->where('created_by', $contact->id)
                ->select('id')
                ->get());
            return view('backend.pages.contacts.show', compact('contact', 'sites'));
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
