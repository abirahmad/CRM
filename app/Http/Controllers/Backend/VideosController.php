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
use App\Models\Video;
use Yajra\DataTables\Facades\DataTables;

class VideosController extends Controller
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
        if (!Auth::guard('admin')->user()->can('videos.view') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        $unit_id = Auth::guard('admin')->user()->unit_id;

        if (Auth::guard('admin')->user()->is_central_admin = 1) {
            $videos = Video::orderBy('id', 'desc')->get();
        } else {
            $videos = Video::where('unit_id', $unit_id)->orderBy('id', 'desc')->get();
        }

        return view('backend.pages.videos.index', compact('videos'));
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

        return view('backend.pages.videos.create')->with(compact('contacts'));
    }

    /**
     * Store.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        if (!Auth::guard('admin')->user()->can('videos.create')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }
    
        try {

            $videos=new Video();
            $videos->title=$request->title;
            $videos->link=$request->link;
            $videos->duration=$request->duration;
            $videos->image=$request->image;
            $videos->unit_id=Auth::guard('admin')->user()->unit_id;
            $videos->created_by=$request->created_by;
            $videos->save();
            session()->flash('success', 'Video has created successfully !!');
            return redirect()->route('admin.videos.index');
            
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
        if (!Auth::guard('admin')->user()->can('videos.edit')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }
        $unit_id = Auth::guard('admin')->user()->unit_id;
        
        $videos=Video::find($id);
        $contacts=Contact::where('unit_id',$unit_id)->orderBy('id','desc')->get();
        
        if(!is_null($videos)){
            return view('backend.pages.videos.edit')->with(compact('videos','contacts'));
        }else{
            session()->flash('error', 'Something is wrong!!');
        }

        return view('backend.pages.videos.edit');
    }

    /**
    *Update.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        if (!Auth::guard('admin')->user()->can('videos.edit')  && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
        'title'  => 'required',
        'link'   => 'required',
        'duration'   => 'required',
        'image'   => 'required',
        'created_by'   => 'required',
        ]);

        $video=Video::find($id);
        $video->title=$request->title;
        $video->link=$request->link;
        $video->duration=$request->duration;
        $video->image=$request->image;
        $video->unit_id=Auth::guard('admin')->user()->unit_id;
        $video->created_by=$request->created_by;
        $video->save();

        session()->flash('success', 'Video has updated successfully !!');
        return redirect()->route('admin.videos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Auth::guard('admin')->user()->can('videos.delete') && (Auth::guard('admin')->user()->is_central_admin != 1)) {
            abort(403, 'Unauthorized action.');
        }

        $video = Video::find($id);
        $message = "video Not found !!";
        $messageType = "error";
        if (!is_null($video)) {
            if (($video->unit_id != Auth::guard('admin')->user()->unit_id) && (Auth::guard('admin')->user()->is_central_admin != 1)) {
                abort(403, 'Unauthorized action. You can not delete other unit videos');
            }

            $video->delete();
            $message = 'Video Information has been deleted successfully !';
            $messageType = "success";
            session()->flash($messageType, $message);
        } else {
            session()->flash($messageType, $message);
        }

        return back();
    }
}
