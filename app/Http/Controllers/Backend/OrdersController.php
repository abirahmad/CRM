<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Http\Controllers\Backend\ContactsController;

use Auth;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Site;
use App\Models\RewardPoint;
use Yajra\DataTables\Facades\DataTables;


class OrdersController extends Controller
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
    public function index(Request $request)
    {
        if (!Auth::guard('admin')->user()->can('orders.view') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        $unit_id = Auth::guard('admin')->user()->unit_id;

       if (request()->ajax()) {

            if (Auth::guard('admin')->user()->is_central_admin = 1) {
                $orders = Order::join('sites','orders.site_id','=','sites.id')
                            ->join('districts','orders.district_id','=','districts.id')
                            ->join('products','orders.product_id','=','products.id')
                            ->join('upazilas','orders.upazila_id','=','upazilas.id')
                            ->join('contacts','orders.created_by','=','contacts.id')
                            ->orderBy('orders.id', 'desc')
                            ->select(
                                    'orders.id',
                                    'sites.name as sitename',
                                    'products.name as product',
                                    'quantity',
                                    'date',
                                    'districts.name as district',
                                    'upazilas.name as upazila',
                                    'location',
                                    'orders.status as status',
                                    'contacts.name',
                                    'orders.created_by'


                            );
                            // ->get();
            } else {
                $orders = Order::where('unit_id', $unit_id)
                            ->join('sites','orders.site_id','=','sites.id')
                            ->join('districts','orders.district_id','=','districts.id')
                            ->join('upazila','orders.upazila_id','=','upazilas.id')
                            ->join('contacts','orders.created_by','=','contacts.id')
                           ->orderBy('id', 'desc')
                           ->select(
                                    'orders.id',
                                    'sites.name as sitename',
                                    'products.name as product',
                                    'quantity',
                                    'date',
                                    'districts.name as district',
                                    'upazilas.name as upazila',
                                    'location',
                                    'orders.status as status',
                                    'contacts.name as name',
                                    'orders.created_by'


                            );
                           // ->groupBy('orders.id');
                        //   ->get();
            }

            // dd($orders);
            if (!empty(request()->site_id)) {
                $orders->where('orders.site_id', request()->site_id);
            }
            if (!empty(request()->created_by)) {
                $orders->where('orders.created_by', request()->created_by);
            }
            
            if (!empty(request()->status)) {
                if(request()->status == 2){
                    request()->status = 0;
                }
                $orders->where('orders.status', request()->status);
            }
            
            //  if (!empty(request()->start_date) && !empty(request()->end_date)) {
            //     $start = request()->start_date;
            //     $end =  request()->end_date;
            //     $projects->whereDate('projects.created_at', '>=', $start)
            //                 ->whereDate('projects.created_at', '<=', $end);
            // }

          $orderData=$orders->get();
            return Datatables::of($orderData)
              ->addColumn(
                    'action', function($row){
                        $csrf = "".csrf_field()."";
                       return  '<div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    
                                    <a class="dropdown-item" href="' . action('Backend\OrdersController@show',$row->id) . '">
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
                                    <form action="'.action("Backend\OrdersController@destroy",$row->id).'" method="post">'.$csrf.'
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

                ->editColumn('location', function ($row){
                    return '<strong>District:</strong>'.$row->district.' 
                            <br>
                            <strong>Upazila:</strong> '.$row->upazila.'
                            <br>
                            <strong>Address:</strong> '.$row->location.'';
                })

                ->editColumn('sitename', function ($row){
                    return '<strong class="text-primary">'.$row->sitename.'
                            </strong>';
                      
                })


                ->editColumn('status',function($row){
                    return  $row->statusPrint();

                 })
                ->editColumn('name',function($row){
                    
                    return '<a href="'.action('Backend\ContactsController@show', $row->created_by).'" target="_blank">
                                 '.$row->name.' 
                            </a>';

                })

                

                

                ->rawColumns(['sitename', 'location', 'name', 'upazlia','status','action']) 
                
                // return $datatable->rawColumns($rawColumns)
                      ->make(true);
            // dd($orders);
        }
    
   $sites=Site::where('unit_id',$unit_id)
               ->pluck('name','id');
        $contacts=Contact::where('unit_id',$unit_id)
               ->pluck('name','id');
        $status=Order::where('unit_id',$unit_id)
               ->pluck('status');
             
  
        return view('backend.pages.orders.index')->with(compact('sites','contacts','status'));
    }
   


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Auth::guard('admin')->user()->can('orders.view')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        // dd($id);

        $order = Order::find($id);
        $message = "Order Not found !!";
        $messageType = "error";
        if (!is_null($order)) {
            if (($order->unit_id != Auth::guard('admin')->user()->unit_id) && (Auth::guard('admin')->user()->is_central_admin != 1)) {
                abort(403, 'Unauthorized action. You can not show other unit order details');
            }
            return view('backend.pages.orders.show', compact('order'));
        }
        session()->flash($messageType, $message);
        return back();
    }

    /**
     * activate()
     * 
     * Activate or inactivate orders status
     *
     * @param int $id
     * @return void
     */
    public function activate(Request $request, $id)
    {
        if (!Auth::guard('admin')->user()->can('orders.activate')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }
        
        // dd($id);
        $order = Order::find($id);
        $message = "Order Not found !!";
        $messageType = "error";
        if (!is_null($order)) {
            if (($order->unit_id != Auth::guard('admin')->user()->unit_id) && (Auth::guard('admin')->user()->is_central_admin != 1)) {
                abort(403, 'Unauthorized action. You can not edit other unit orders');
            }
            $order->status =  $request->status;
            $order->details =  $request->details;
            $order->save();
            $message = "Order Updated !!";
            
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
        if (!Auth::guard('admin')->user()->can('orders.delete') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        $order = Order::find($id);
        $message = "Order Not found !!";
        $messageType = "error";
        if (!is_null($order)) {
            if (($order->unit_id != Auth::guard('admin')->user()->unit_id) && (Auth::guard('admin')->user()->is_central_admin != 1)) {
                abort(403, 'Unauthorized action. You can not delete other unit orders');
            }

            $order->delete();
            $message = 'Order Information has been deleted successfully !';
            $messageType = "success";
            session()->flash($messageType, $message);
        } else {
            session()->flash($messageType, $message);
        }

        return back();
    }
}
