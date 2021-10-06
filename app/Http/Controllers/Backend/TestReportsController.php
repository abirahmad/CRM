<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

use Auth;
use DB;
use App\Models\TestReport;
use App\Helpers\UploadHelper;
use App\Models\Product;

class TestReportsController extends Controller
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
        if (!Auth::guard('admin')->user()->can('reports.view') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        $unit_id = Auth::guard('admin')->user()->unit_id;
      if(request()->ajax()){
        if (Auth::guard('admin')->user()->is_central_admin = 1) {
            $reports = TestReport::join('products','test_reports.product_id','=','products.id')
               ->orderBy('id', 'desc')
               ->select(
                    'test_reports.id as id',
                    'test_reports.title',
                    'test_reports.year',
                    'test_reports.month',
                    'test_reports.image',
                    'test_reports.company',
                    'products.name'
            );
            // ->get();
        } else {
            $reports = TestReport::where('unit_id', $unit_id)
                ->join('products','test_reports.product_id','=','products.id')
                ->orderBy('id', 'desc')
                ->select(
                    'test_reports.id as id',
                    'test_reports.title',
                    'test_reports.year',
                    'test_reports.month',
                    'test_reports.image',
                    'test_reports.company',
                    'products.name'
                );
                // ->get();
        }

           // dd(request()->year);

             if (!empty(request()->year)) {
                 
                    $reports->where('test_reports.year', request()->year);
                }
            if (!empty(request()->month)) {
                
                $reports->where('test_reports.month', request()->month);
            }
            
         $reportData = $reports->get();
        return Datatables::of($reportData)
                 ->addColumn(
                    'action', function($row){
                        $csrf = "".csrf_field()."";
                       return  '<div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                   <a class="dropdown-item" href="' . route('admin.reports.edit',$row->id) . '">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    
                                    <a class="dropdown-item" data-toggle="modal" href="#showModal'.$row->id.'">
                                        <i class="fa fa-eye"></i> View
                                    </a>
                                    <a class="dropdown-item" data-toggle="modal" href="#deleteModal'.$row->id.'">
                                        <i class="fa fa-trash"></i> Delete
                                    </a>
                                    
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
                                    <form action="'.action("Backend\TestReportsController@destroy",$row->id).'" method="post">'.$csrf.'
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

                 ->editColumn('image', function ($row) {
                    $url = url("public/img/reports/".$row->image);       
                      return '<a class="dropdown-item" href="#showModal'.$row->id.'" data-toggle="modal"><img class="report-min-img" src="'.$url.'"></a>

                      <div class="modal fade delete-modal" id="showModal'.$row->id.'" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Test Report-'.$row->month.'-'.$row->year.'</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <img class="modal-max-img" src="'.$url.'">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i
                                                class="fa fa-times"></i> Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>'; 
                })
                ->rawColumns(['image','action']) 
                      ->make(true);
            // dd($orders);

    }
        
        // Get years
        $years = [];
        for($year=date('Y'); $year >= 1900; $year--){
            array_push($years, $year);
        }


        $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        return view('backend.pages.reports.index', compact('years', 'months'));
    }


    public function create()
    {
        if (!Auth::guard('admin')->user()->can('reports.create') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }
        
        // Get years
        $years = [];
        for($year=date('Y'); $year >= 1900; $year--){
            array_push($years, $year);
        }
        $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        $products=Product::orderBy('id','desc')->get();
        return view('backend.pages.reports.create', compact('years', 'months','products'));
    }

    public function store(Request $request)
    {
        if (!Auth::guard('admin')->user()->can('reports.create') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        $unit_id = Auth::guard('admin')->user()->unit_id;

        // $this->validate($request, [
        //     'year' => 'required',
        //     'month' => 'required',
        //     'product_id' => 'required'
        // ]);

    try{

        $report = new TestReport();
        $report->unit_id = $unit_id;
        $report->product_id = $request->product_id;
        $report->year = $request->year;
        $report->month = $request->month;
        $report->priority = $request->priority;
        if (!isset($request->title)) {
            $report->title = $request->month . ' ' . $request->year;
        } else {
            $report->title = $request->title;
        }

        $report->created_by = Auth::id();
        $report->description = $request->description;
        if (!isset($request->company)) {
            $report->company = 'BUET';
        } else {
            $report->company = $request->company;
        }

           if (!is_null($request->image)) {
                    $report->image = UploadHelper::upload('image', $request->image, $request->year.'-'.$request->month.'-'.time(), 'public/img/reports');
                }

        // dd($request->image);

        $report->save();
        session()->flash('success', 'Report has been saved successfully !!');
        return redirect()->route('admin.reports.index');
        } catch (\Exception $e) {
            // session()->flash('db_error', 'Error On: '."File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            session()->flash('db_error', $e->getMessage());
            DB::rollBack();
            return back();
        }
    }

    /**
     * Edit
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id){
        if (!Auth::guard('admin')->user()->can('reports.edit')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        $unit_id=Auth::guard('admin')->user()->unit_id;

        $reports=TestReport::find($id);

         // Get years
        $years = [];
        for($year=date('Y'); $year >= 1900; $year--){
            array_push($years, $year);
        }
        //Get Months
        $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];

        //Get Products
        $products=Product::orderBy('id','desc')->get();

        return view('backend.pages.reports.edit', compact('years', 'months','products','reports'));

    }

    /**
     * Update
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request,$id){
            if (!Auth::guard('admin')->user()->can('reports.edit')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

         $unit_id = Auth::guard('admin')->user()->unit_id;

        // $this->validate($request, [
        //     'year' => 'required',
        //     'month' => 'required',
        //     'product_id' => 'required'
        // ]);

    try{

        $report =TestReport::find($id);
        $report->unit_id = $unit_id;
        $report->product_id = $request->product_id;
        $report->year = $request->year;
        $report->month = $request->month;
        $report->priority = $request->priority;
        if (!isset($request->title)) {
            $report->title = $request->month . ' ' . $request->year;
        } else {
            $report->title = $request->title;
        }

        $report->created_by = Auth::id();
        $report->description = $request->description;
        if (!isset($request->company)) {
            $report->company = 'BUET';
        } else {
            $report->company = $request->company;
        }

           if (!is_null($request->image)) {
                    $report->image = UploadHelper::upload('image', $request->image, $request->year.'-'.$request->month.'-'.time(), 'public/img/reports');
                }

        // dd($request->image);

        $report->save();
        session()->flash('success', 'Report has been updated successfully !!');
        return redirect()->route('admin.reports.index');
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
        if (!Auth::guard('admin')->user()->can('reports.view')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        $order = TestReport::find($id);
        $message = "TestReport Not found !!";
        $messageType = "error";
        if (!is_null($order)) {
            if (($order->unit_id != Auth::guard('admin')->user()->unit_id) && (Auth::guard('admin')->user()->is_central_admin != 1)) {
                abort(403, 'Unauthorized action. You can not show other unit order details');
            }
            return view('backend.pages.reports.show', compact('order'));
        }
        session()->flash($messageType, $message);
        return back();
    }

    /**
     * activate()
     * 
     * Activate or inactivate reports status
     *
     * @param int $id
     * @return void
     */
    public function activate(Request $request, $id)
    {
        if (!Auth::guard('admin')->user()->can('reports.activate')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }


        $order = TestReport::find($id);
        $message = "TestReport Not found !!";
        $messageType = "error";
        if (!is_null($order)) {
            if (($order->unit_id != Auth::guard('admin')->user()->unit_id) && (Auth::guard('admin')->user()->is_central_admin != 1)) {
                abort(403, 'Unauthorized action. You can not edit other unit reports');
            }

            $order->status =  $request->status;
            $order->details =  $request->details;
            $order->save();
            $message = "TestReport Updated !!";
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
        if (!Auth::guard('admin')->user()->can('reports.delete') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        $order = TestReport::find($id);
        $message = "TestReport Not found !!";
        $messageType = "error";
        if (!is_null($order)) {
            if (($order->unit_id != Auth::guard('admin')->user()->unit_id) && (Auth::guard('admin')->user()->is_central_admin != 1)) {
                abort(403, 'Unauthorized action. You can not delete other unit reports');
            }

            $order->delete();
            $message = 'TestReport Information has been deleted successfully !';
            $messageType = "success";
            session()->flash($messageType, $message);
        } else {
            session()->flash($messageType, $message);
        }

        return back();
    }
}
