<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BrandRequisition;
use App\Models\ItemRequisition;
use App\Helpers\UploadHelper;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;

class BrandRequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //      if (!Auth::guard('admin')->user()->can('brand_requisition.view')) {
    //         abort(403, 'Unauthorized action.');
    //     }


    //     $unit_id = Auth::guard('admin')->user()->unit_id;

    //      if (request()->ajax()) {

    //         if (Auth::guard('admin')->user()->is_central_admin = 1) {
    //             $brands = BrandRequisition::join('item_requisitions','brand_requisitions.item_requisition_id','=','item_requisitions.id')
    //                         ->orderBy('id', 'desc')
    //                         ->select(
    //                             'brand_requisitions.id as id',
    //                             'brand_requisitions.shop_id as shop',
    //                             'item_requisitions.name as item',
    //                             'brand_requisitions.item_type',
    //                             'brand_requisitions.quantity',
    //                             'brand_requisitions.size',
    //                             'brand_requisitions.image',
    //                             'brand_requisitions.comment'
    //                             );
    //                         // ->get();
    //         } else {
    //             $brands = BrandRequisition::where('unit_id', $unit_id)
    //                        ->join('item_requisitions','brand_requisitions.item_requisition_id','=','item_requisitions.id')
    //                         ->orderBy('id', 'desc')
    //                         ->select(
    //                             'brand_requisitions.id as id',
    //                             'brand_requisitions.shop_id as shop',
    //                             'item_requisitions.name as item',
    //                             'brand_requisitions.item_type',
    //                             'brand_requisitions.quantity',
    //                             'brand_requisitions.size',
    //                             'brand_requisitions.image',
    //                             'brand_requisitions.comment'
    //                             );
    //                        // ->get();
    //         }
            
    //         $brandData = $brands->get();
    //         $datatable = Datatables::of($brands)
    //             ->addColumn(
    //                 'action', function($row){
    //                     $csrf = "".csrf_field()."";
    //                    return  '<div class="dropdown">
    //                             <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
    //                                 data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    //                                 Action
    //                             </button>
    //                             <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

    //                                <a class="dropdown-item" href="' . route('admin.reports.edit',$row->id) . '">
    //                                     <i class="fa fa-edit"></i> Edit
    //                                 </a>
                                    
    //                                 <a class="dropdown-item" data-toggle="modal" href="#showModal'.$row->id.'">
    //                                     <i class="fa fa-eye"></i> View
    //                                 </a>
    //                                <a class="dropdown-item" data-toggle="modal" href="#deleteModal'.$row->id.'">
    //                                     <i class="fa fa-trash"></i> Delete
    //                                 </a>
                                    
    //                             </div>
    //                         </div>
    //                         <div class="modal fade delete-modal" id=deleteModal'.$row->id.'  tabindex="-1" role="dialog"
    //                         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    //                         <div class="modal-dialog modal-dialog-centered" role="document">
    //                             <div class="modal-content">
    //                                 <div class="modal-header">
    //                                     <h5 class="modal-title" id="exampleModalLongTitle">Are you sure to delete ?</h5>
    //                                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    //                                         <span aria-hidden="true">&times;</span>
    //                                     </button>
    //                                 </div>
    //                             <div class="modal-body">
    //                                 <p>
    //                                     contact all informations (contact profile and contacts) will be deleted. Please
    //                                     be sure
    //                                     first to delete.
    //                                 </p>
    //                             </div>
    //                             <div class="modal-footer">
    //                                 <form action="'.action("Backend\TestReportsController@destroy",$row->id).'" method="post">'.$csrf.'
    //                                     <button type="submit" class="btn btn-outline-success"><i
    //                                             class="fa fa-check"></i> Confirm Delete</button>
    //                                     <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i
    //                                             class="fa fa-times"></i> Close</button>
    //                                 </form>
    //                             </div>
    //                         </div>
    //                     </div>
    //                 </div>';
                    
    //                 })

    //              ->editColumn('image', function ($row) {
    //                 $url = url("public/img/brand_requisition/".$row->image);       
    //                   return '<a class="dropdown-item" href="#showModal'.$row->id.'" data-toggle="modal"><img class="report-min-img" src="'.$url.'"></a>

    //                   <div class="modal fade delete-modal" id="showModal'.$row->id.'" tabindex="-1" role="dialog"
    //                             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    //                             <div class="modal-dialog modal-dialog-centered" role="document">
    //                                 <div class="modal-content">
    //                                     <div class="modal-header">
    //                                         <h5 class="modal-title" id="exampleModalLongTitle">Test Report-'.$row->month.'-'.$row->year.'</h5>
    //                                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    //                                             <span aria-hidden="true">&times;</span>
    //                                         </button>
    //                                     </div>
    //                                     <div class="modal-body">
    //                                         <img class="modal-max-img" src="'.$url.'">
    //                                     </div>
    //                                     <div class="modal-footer">
    //                                         <button type="button" class="btn btn-outline-secondary" data-dismiss="modal"><i
    //                                             class="fa fa-times"></i> Close</button>
    //                                         </div>
    //                                     </div>
    //                                 </div>
    //                             </div>'; 
    //             })
    //             ->rawColumns(['image','action']) 
    //                   ->make(true);
    //     }
    

     

    //     return view('backend.pages.brand_requisition.index');
    // }

     public function index()
    {
        if (!Auth::guard('admin')->user()->can('brand_requisition.view') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        $unit_id = Auth::guard('admin')->user()->unit_id;
      if(request()->ajax()){
        if (Auth::guard('admin')->user()->is_central_admin = 1) {
            $brands = BrandRequisition::join('item_requisitions','brand_requisitions.item_requisition_id','=','item_requisitions.id')
               ->orderBy('id', 'desc')
               ->select(
                    'brand_requisitions.id as id',
                    'brand_requisitions.shop_id',
                    'brand_requisitions.item_type',
                    'brand_requisitions.quantity',
                    'brand_requisitions.size',
                    'brand_requisitions.image',
                    'brand_requisitions.comment',
                    'item_requisitions.name as item'
            );
            // ->get();
        } else {
            $brands = BrandRequisition::join('item_requisitions','brand_requisitions.item_requisition_id','=','item_requisitions.id')
               ->orderBy('id', 'desc')
               ->select(
                    'brand_requisitions.id as id',
                    'brand_requisitions.shop_id',
                    'brand_requisitions.item_type',
                    'brand_requisitions.quantity',
                    'brand_requisitions.size',
                    'brand_requisitions.image',
                    'brand_requisitions.comment',
                    'item_requisitions.name as item'
            );
                // ->get();
        }

           // dd(request()->year);

             if (!empty(request()->item_type)) {
                 
                    $brands->where('brand_requisitions.item_type', request()->item_type);
                }
            if (!empty(request()->item)) {
                
                $brands->where('item_requisitions.id', request()->item);
            }
            
         $brandData = $brands->get();
        return Datatables::of($brandData)
                 ->addColumn(
                    'action', function($row){
                        $csrf = "".csrf_field()."";
                       return  '<div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                   <a class="dropdown-item" href="' . route('admin.brand_requisitions.edit',$row->id) . '">
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
                                    <form action="'.action("Backend\BrandRequisitionController@destroy",$row->id).'" method="post">'.$csrf.'
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
                    $url = url("public/img/brand_requisition/".$row->image);       
                      return '<a class="dropdown-item" href="#showModal'.$row->id.'" data-toggle="modal"><img class="report-min-img" src="'.$url.'"></a>

                      <div class="modal fade delete-modal" id="showModal'.$row->id.'" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Brand Requisition Image-'.$row->item_type.'</h5>
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
        
       $item_type=BrandRequisition::where('unit_id',$unit_id)
                        ->pluck('item_type','id');
                        // dd($item_type);
        $items=ItemRequisition::orderBy('id','desc')->get();
        return view('backend.pages.brand_requisition.index')->with(compact('item_type','items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         if (!Auth::guard('admin')->user()->can('brand_requisition.create') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }
        
        $items=ItemRequisition::orderBy('id','desc')->get();
        
        return view('backend.pages.brand_requisition.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::guard('admin')->user()->can('brand_requisition.create') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        $unit_id = Auth::guard('admin')->user()->unit_id;

        // $this->validate($request, [
        //     'year' => 'required',
        //     'month' => 'required',
        //     'product_id' => 'required'
        // ]);

    try{

        $brand_requisition = new BrandRequisition();
        $brand_requisition->unit_id = $unit_id;
        if (!isset($request->shop_id)) {
            $brand_requisition->shop_id =1;
        } else {
            $brand_requisition->shop_id = $request->shop_id;
        }
        $brand_requisition->item_requisition_id = $request->item_id;
        $brand_requisition->item_type = $request->item_type;
        $brand_requisition->quantity = $request->quantity;
        $brand_requisition->size = $request->size;
        $brand_requisition->comment = $request->comment;
        if (!isset($request->employee_id)) {
            $brand_requisition->employee_id = "Abir";
        } else {
            $brand_requisition->employee_id = $request->employee_id;
        }
        // dd($request->image);

           if (!is_null($request->image)) {
                    $brand_requisition->image = UploadHelper::upload('image', $request->image, $request->item_type.'-'.time(), 'public/img/brand_requisition');
                }

        $brand_requisition->save();
        session()->flash('success', 'Brand Requisition has been saved successfully !!');
        return redirect()->route('admin.brand_requisitions.index');
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
        if (!Auth::guard('admin')->user()->can('brand_requisition.edit')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        $unit_id=Auth::guard('admin')->user()->unit_id;

        $brand_requisition=BrandRequisition::find($id);

        $items=ItemRequisition::orderBy('id','desc')->get();

        return view('backend.pages.brand_requisition.edit', compact('brand_requisition', 'items'));
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
                if (!Auth::guard('admin')->user()->can('brand_requisition.edit')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

         $unit_id = Auth::guard('admin')->user()->unit_id;

        // $this->validate($request, [
        //     'year' => 'required',
        //     'month' => 'required',
        //     'product_id' => 'required'
        // ]);

    try{

        $brand_requisition =BrandRequisition::find($id);
        $brand_requisition->unit_id = $unit_id;
        if (!isset($request->shop_id)) {
            $brand_requisition->shop_id =1;
        } else {
            $brand_requisition->shop_id = $request->shop_id;
        }
        $brand_requisition->item_requisition_id = $request->item_id;
        $brand_requisition->item_type = $request->item_type;
        $brand_requisition->quantity = $request->quantity;
        $brand_requisition->size = $request->size;
        $brand_requisition->comment = $request->comment;
        if (!isset($request->employee_id)) {
            $brand_requisition->employee_id = "Abir";
        } else {
            $brand_requisition->employee_id = $request->employee_id;
        }
        // dd($request->image);

           if (!is_null($request->image)) {
                    $brand_requisition->image = UploadHelper::upload('image', $request->image, $request->item_type.'-'.time(), 'public/img/brand_requisition');
                }

        $brand_requisition->save();
        session()->flash('success', 'Brand Requisition has been updated successfully !!');
        return redirect()->route('admin.brand_requisitions.index');
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
        if (!Auth::guard('admin')->user()->can('brand_requisition.delete') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        $brand_requisition = BrandRequisition::find($id);
        $message = "BrandRequisition Not found !!";
        $messageType = "error";
        if (!is_null($brand_requisition)) {
            if (($brand_requisition->unit_id != Auth::guard('admin')->user()->unit_id) && (Auth::guard('admin')->user()->is_central_admin != 1)) {
                abort(403, 'Unauthorized action. You can not delete other unit reports');
            }

            $brand_requisition->delete();
            $message = 'BrandRequisition Information has been deleted successfully !';
            $messageType = "success";
            session()->flash($messageType, $message);
        } else {
            session()->flash($messageType, $message);
        }

        return back();
    }
}
