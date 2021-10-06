<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use Auth;
use Exception;
use App\Models\Employer;
use App\Models\User;
use App\Models\Country;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazilla;
use App\Models\Category;
use App\Models\Type;
use Illuminate\Support\Facades\Hash;
use App\Models\Contact;
use App\Models\EmployerType;
use App\Helpers\UploadHelper;
use App\Helpers\ImageUploadHelper;

use Image;

class EmployersController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Auth::guard('admin')->user()->givePermissionTo('employers.view');
        // Auth::guard('admin')->user()->assignRole('Super Admin');
        
        if (!Auth::guard('admin')->user()->can('employers.view')) {
            abort(403, 'Unauthorized action.');
        }
        
        $employers = Employer::select(
            'id', 'name', 'logo', 'email', 'address'
        )->get();

        return view('backend.pages.employers.index', compact('employers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::guard('admin')->user()->can('employers.create')) {
            abort(403, 'Unauthorized action.');
        }

        $countries = Country::orderBy('name', 'asc')->get();
        $districts = District::orderBy('name', 'asc')->get();
        $upazillas = Upazilla::orderBy('name', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();
        $types = Type::orderBy('name', 'asc')->get();
        
        return view('backend.pages.employers.create',compact('countries', 'districts', 'upazillas', 'categories', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|max:100',
            'name_bn'  => 'required|max:100',
            'contact_email'  => 'required|email|max:100|unique:employers,email',
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
            $employer = new Employer();
            $employer->name = $request->name;
            $employer->name_bn = $request->name_bn;
            $employer->country_id = $request->country_id;
            $employer->district_id = $request->district_id;
            $employer->division_id = District::find($request->district_id)->division_id;
            $employer->upazilla_id = $request->upazilla_id;
            $employer->category_id = $request->category_id;
            $employer->address = $request->address;
            $employer->address_bn = $request->address_bn;
            $employer->business_description = $request->business_description;
            $employer->business_trade_licence = $request->business_trade_licence;
            $employer->business_rl_no = $request->business_rl_no;
            $employer->website = $request->website;
            $employer->email = 'test@gmail.com';
            $employer->password = Hash::make($request->password);
            $employer->api_token = bin2hex(openssl_random_pseudo_bytes(40));
            $employer->save();

            // New Contact Information for this employer
            $contact = new Contact();
            $contact->name = $request->contact_name;    
            $contact->email = $request->contact_email;    
            $contact->phone = $request->contact_phone;    
            $contact->designation = $request->contact_designation;    
            $contact->employer_id = $employer->id;    
            $contact->is_primary_contact  = 1; 
            $contact->save();   

            // If there is any logo then save it
            $employer->logo = ImageUploadHelper::upload('logo', $request->file('logo'), time(), 'public/img/companies');

            $employer->email =  $request->contact_email;
            $employer->save();

            // Save employers types
            if  (count($request->types) <= 20){
                foreach ($request->types as $type) {
                    $employer_type = new EmployerType();
                    $employer_type->employer_id = $employer->id; 
                    $employer_type->type_id = $type; 
                    $employer_type->save(); 
                }
            }else{
                throw new Exception('Please give types less than or equal twenty types. ');
            }

            DB::commit();
            session()->flash('success', 'New Employer Information has been saved successfully !!');
            return redirect()->route('admin.employers.index');
        } catch (\Exception $e) {
            // session()->flash('db_error', 'Error On: '."File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            session()->flash('db_error', $e->getMessage());
            DB::rollBack();
            return back();
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::guard('admin')->user()->can('employers.edit')) {
            abort(403, 'Unauthorized action.');
        }
        $employer = Employer::find($id);

        if (!is_null($employer)){
            $countries = Country::orderBy('name', 'asc')->get();
            $districts = District::orderBy('name', 'asc')->get();
            $upazillas = Upazilla::orderBy('name', 'asc')->get();
            $categories = Category::orderBy('name', 'asc')->get();
            $types = Type::orderBy('name', 'asc')->get();

            $primary_contact = $employer->primaryContact($id);
            return view('backend.pages.employers.edit',compact('countries', 'districts', 'upazillas', 'categories', 'types', 'employer', 'primary_contact'));
        }
        session()->flash('error', 'No Employer has found by this ID');
        return $this->index();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $employer = Employer::find($id);

        $request->validate([
            'name'  => 'required|max:100',
            'name_bn'  => 'required|max:100',
            'contact_email'  => 'required|email|max:100|unique:employers,email,'.$employer->id,
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
            'password'  => 'nullable|confirmed|min:6|max:20',
        ]);

        try {
            DB::beginTransaction();
            $employer->name = $request->name;
            $employer->name_bn = $request->name_bn;
            $employer->country_id = $request->country_id;
            $employer->district_id = $request->district_id;
            $employer->division_id = District::find($request->district_id)->division_id;
            $employer->upazilla_id = $request->upazilla_id;
            $employer->category_id = $request->category_id;
            $employer->address = $request->address;
            $employer->address_bn = $request->address_bn;
            $employer->business_description = $request->business_description;
            $employer->business_trade_licence = $request->business_trade_licence;
            $employer->business_rl_no = $request->business_rl_no;
            $employer->website = $request->website;
            $employer->email = 'test@gmail.com';
            $employer->password = Hash::make($request->password);
            $employer->api_token = bin2hex(openssl_random_pseudo_bytes(40));
            $employer->save();

            // New Contact Information for this employer
            $contact = $employer->primaryContact($employer->id);
            $contact->name = $request->contact_name;
            $contact->email = $request->contact_email;
            $contact->phone = $request->contact_phone;
            $contact->designation = $request->contact_designation; 
            $contact->employer_id = $employer->id;
            $contact->is_primary_contact  = 1;
            $contact->save();   

            // If there is any logo then save it
            if (isset($request->logo)) {
                $employer->logo = ImageUploadHelper::update('logo', $request->file('logo'), time(), 'public/img/companies', 'public/img/companies/'.$employer->logo);
            }

            $employer->email =  $request->contact_email;
            $employer->save();

            // Save employers types
            if  (count($request->types) <= 20){
                // Delete old employers types
                $etypes = EmployerType::where('employer_id',  $employer->id)->get();
                foreach ($etypes as $etype) {
                    $etype->delete();
                }
                
                if(count($request->types) > 0){
                    foreach ($request->types as $type) {
                        $employer_type = new EmployerType();
                        $employer_type->employer_id = $employer->id;
                        $employer_type->type_id = $type;
                        $employer_type->save();
                    }
                }
                
            }else{
                throw new Exception('Please give types less than or equal twenty types. ');
            }

            DB::commit();
            session()->flash('success', 'Employer Information has been updated successfully !!');
            return redirect()->route('admin.employers.index');
        } catch (\Exception $e) {
            // session()->flash('db_error', 'Error On: '."File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            session()->flash('db_error', $e->getMessage());
            DB::rollBack();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employer = Employer::find($id);
        if (!is_null($employer)) {
            $employer->delete();
            session()->flash('success', 'Employer Information has been deleted successfully !!');
            return back();
        }

        session()->flash('error_msg', 'Sorry !! There is no employer has found !!');
        return back();
    }
}
