<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\Models\Complain;

class ComplainsController extends Controller
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
        if (!Auth::guard('admin')->user()->can('complains.view') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        $unit_id = Auth::guard('admin')->user()->unit_id;

        if (Auth::guard('admin')->user()->is_central_admin = 1) {
            $complains = Complain::orderBy('id', 'desc')->get();
        } else {
            $complains = Complain::where('unit_id', $unit_id)->orderBy('id', 'desc')->get();
        }

        return view('backend.pages.complains.index', compact('complains'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Auth::guard('admin')->user()->can('complains.view')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        $complain = Complain::find($id);
        $message = "Complain Not found !!";
        $messageType = "error";
        if (!is_null($complain)) {
            if (($complain->unit_id != Auth::guard('admin')->user()->unit_id) && (Auth::guard('admin')->user()->is_central_admin != 1)) {
                abort(403, 'Unauthorized action. You can not show other unit complain details');
            }
            return view('backend.pages.complains.show', compact('complain'));
        }
        session()->flash($messageType, $message);
        return back();
    }

    /**
     * activate()
     * 
     * Activate or inactivate complains status
     *
     * @param int $id
     * @return void
     */
    public function activate(Request $request, $id)
    {
        if (!Auth::guard('admin')->user()->can('complains.activate')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }


        $complain = Complain::find($id);
        $message = "Complain Not found !!";
        $messageType = "error";
        if (!is_null($complain)) {
            if (($complain->unit_id != Auth::guard('admin')->user()->unit_id) && (Auth::guard('admin')->user()->is_central_admin != 1)) {
                abort(403, 'Unauthorized action. You can not edit other unit complains');
            }

            $complain->status =  $request->status;
            $complain->reply_message =  $request->reply_message;
            $complain->save();
            $message = "Complain Updated !!";
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
        if (!Auth::guard('admin')->user()->can('complains.delete') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        $complain = Complain::find($id);
        $message = "Complain Not found !!";
        $messageType = "error";
        if (!is_null($complain)) {
            if (($complain->unit_id != Auth::guard('admin')->user()->unit_id) && (Auth::guard('admin')->user()->is_central_admin != 1)) {
                abort(403, 'Unauthorized action. You can not delete other unit complains');
            }

            $complain->delete();
            $message = 'Complain Information has been deleted successfully !';
            $messageType = "success";
            session()->flash($messageType, $message);
        } else {
            session()->flash($messageType, $message);
        }

        return back();
    }
}
