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
use App\Models\Survey;
use Yajra\DataTables\Facades\DataTables;

class SurveysController extends Controller
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
        if (!Auth::guard('admin')->user()->can('surveys.view') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        $unit_id = Auth::guard('admin')->user()->unit_id;

        if (Auth::guard('admin')->user()->is_central_admin = 1) {
            $surveys = Survey::orderBy('id', 'desc')->get();
        } else {
            $surveys = Survey::where('unit_id', $unit_id)->orderBy('id', 'desc')->get();
        }

        return view('backend.pages.surveys.index', compact('surveys'));
    }

    /**
    * create()
    * 
    * Create  sites 
    *
    * @param int $id
    * @return void
    */
    public function create()
    {
        if (!Auth::guard('admin')->user()->can('sites.create')  && (Auth::guard('admin')->user()->is_central_admin != 1))
        {
            abort(403, 'Unauthorized action.');
        }

        $unit_id = Auth::guard('admin')->user()->unit_id;

        $contacts=Contact::where('unit_id',$unit_id)->orderBy('id','desc')->get();

        return view('backend.pages.surveys.create')->with(compact('contacts'));
    }

    /**
     * Store.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        if (!Auth::guard('admin')->user()->can('surveys.create')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }
    
        try {

            $surveys=new Survey();
            $surveys->title=$request->title;
            $surveys->link=$request->link;
            $surveys->unit_id=Auth::guard('admin')->user()->unit_id;
            $surveys->created_by=$request->created_by;
            $surveys->save();
            session()->flash('success', 'Survey has created successfully !!');
            return redirect()->route('admin.surveys.index');
            
        }   catch (\Exception $e) {
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
    public function edit($id)
    {
        if (!Auth::guard('admin')->user()->can('surveys.edit')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }
        $unit_id = Auth::guard('admin')->user()->unit_id;

        $surveys=Survey::find($id);
        $contacts=Contact::where('unit_id',$unit_id)->orderBy('id','desc')->get();

        if(!is_null($surveys)){
            return view('backend.pages.surveys.edit')->with(compact('surveys','contacts'));
        }else{
            session()->flash('error', 'Something is wrong!!');
        }

        return view('backend.pages.surveys.edit');
    }

    /**
    *Update.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        if (!Auth::guard('admin')->user()->can('surveys.edit')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
        'title'  => 'required',
        'link'   => 'required',
        'created_by'   => 'required',
        ]);

        $survey=Survey::find($id);
        $survey->title=$request->title;
        $survey->link=$request->link;
        $survey->unit_id=Auth::guard('admin')->user()->unit_id;
        $survey->created_by=$request->created_by;
        $survey->save();

        session()->flash('success', 'Survey has updated successfully !!');
        return redirect()->route('admin.surveys.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Auth::guard('admin')->user()->can('surveys.delete') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        $survey = Survey::find($id);
        $message = "survey Not found !!";
        $messageType = "error";
        if (!is_null($survey)) {
            if (($survey->unit_id != Auth::guard('admin')->user()->unit_id) && (Auth::guard('admin')->user()->is_central_admin != 1)) {
                abort(403, 'Unauthorized action. You can not delete other unit surveys');
            }

            $survey->delete();
            $message = 'Survey Information has been deleted successfully !';
            $messageType = "success";
            session()->flash($messageType, $message);
        } else {
            session()->flash($messageType, $message);
        }

        return back();
    }
}
