<?php

namespace App\Http\Controllers\Admin;

use Image;
use session;
use Exception;
use DataTables;
use App\Models\ear_master;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DeleteBulkRequest;
use App\Http\Requests\StatusUpdateRequest;
use App\Http\Requests\CreateEarMasterRequest;
use App\Http\Requests\UpdateEarMasterRequest;

class EarMasterController extends Controller
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    { // coonstructor code starts here 
    }

    /**
     * Handle routs Controller load add request
     * @author Tejas
     * @param  none
     * @return role/view/add_view.blade.php
     */
    public function add_view()
    {
        return view('admin.ears.add_view');
    }

    /**
     * Handle routs Controller add functionality
     * @author Tejas
     * @param  Name, Alias, Description, Status
     * @return success or fail flash message in view
     */
    public function insert_records(CreateEarMasterRequest $request)
    {
        // default response formate initialize
        $resp = config('response_format.RES_RESULT');
        // set ternary status as per database schema
        $status = 0;
        if ($request->has('status')) {
            $status = 1;
        }
        // Set Insert data array for pass into insert query
        $insert_data = $this->_prepareInsertData($request, [$status]);

        // File Upload Starts Folder Path : // root\public\uploads        
        if ($request->hasFile('filename')) {
            $filehandle = $this->_fileUploads($request);
            $insert_data['ear_img'] = $filehandle['data']['filename'];
        }
        // File Upload Ends

        $ear_obj = new ear_master();
        $ear_result = $ear_obj->insert_data($insert_data);

        if ($ear_result->exists) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'Ear inserted successfully...!';
            $request->session()->put('success', $resp['message']);
            return redirect()->back()->with('success', $resp['message']);
        } else {
            $resp['message'] = 'Ear not inserted, Please try again...!';
            $request->session()->put('error', $resp['message']);
            return redirect()->back()->withInput()->with('error', $resp['message']);
        }
    }

    /**
     * Prepare Insert Data Array
     * @author Tejas
     * @param  Request Inputs, (Optional) Addtional Array Datas
     * @return Array
     */
    private function _prepareInsertData($request = "", $additional = array())
    {
        $preArr['ear_name'] = $request->input('ear_name');
        $preArr['ear_color'] = $request->input('ear_color');
        $preArr['ear_description'] = $request->input('ear_description');
        $preArr['status'] = $additional[0];
        return $preArr;
    }

    /**
     * Handle routs Controller load view request
     * @author Tejas
     * @param  none
     * @return ears/view/list_view.blade.php
     */
    public function list_view(Request $request)
    {
        if ($request->ajax()) {
            $ear_obj = new ear_master;
            $list = $ear_obj->list_all();
            return DataTables::of($list)
                ->addIndexColumn()
                ->addColumn('action', function ($list) {
                    $button = '';
                    $edit_button = '<a href="' . url("/admin/ear_edit/{$list['ear_id']}") . '" class="btn btn-xs btn-warning btn_edit" title="Edit"><i class="far fa-edit"></i> Edit</a> &nbsp;';
                    $delete_button = '<a href="#delete-' . $list['ear_id'] . '" delete_id="' . $list['ear_id'] . '" class="btn btn-xs btn-danger btn_delete" title="Delete"><i class="far fa-trash-alt"></i> Delete</a>';
                    $button .= $edit_button;
                    $button .= $delete_button;
                    return $button;
                })
                ->addColumn('status', function ($list) {
                    $button = '';
                    if ($list['status'])
                        $status_button = '<a href="#status-' . $list['status'] . '" class="btn btn-xs btn-success btn_status" title="Status Change" user_id=' . $list['ear_id'] . ' status=' . $list['status'] . '><i class="fa fa-toggle-on" aria-hidden="true"></i> Active</a> &nbsp;';
                    else
                        $status_button = '<a href="#status-' . $list['status'] . '" class="btn btn-xs btn-warning btn_status" title="Status Change" user_id=' . $list['ear_id'] . ' status=' . $list['status'] . '><i class="fa fa-toggle-off" aria-hidden="true"></i> In-Active</a>';
                    $button .= $status_button;
                    return $button;
                })
                ->addColumn('ear_color', function ($list) {
                    if (!empty($list['ear_color']))
                        return '<div class="" style="background-color:' . $list['ear_color'] . '">&nbsp;</div>';
                })
                ->addColumn('ear_img', function ($list) {
                    if (!empty($list['ear_img']))
                        return '<img src="' . url('uploads/ears/thumbnail/thumb_' . $list['ear_img']) . '" title="Image" height="50" width="50"/>';
                })
                ->rawColumns(['action', 'status', 'ear_color', 'ear_img'])
                ->make(true);
        }
        return view('admin.ears.list_view');
    }

    /**
     * Handle routs Controller Load Edit functionality
     * @author Tejas
     * @param  Role ID
     * @return ear_master id wise records into edit view
     */
    public function get_edit_records($ear_id = null)
    {
        $ear_obj = new ear_master();
        $ear_result = ear_master::find($ear_id);

        if (isset($ear_result->ear_img) && !empty($ear_result->ear_img) && file_exists(\public_path('uploads/ears/thumbnail/thumb_' . $ear_result->ear_img))) {
            $mime_type = $this->_base64_mime_type($ear_result->ear_img);
            $ear_result->ear_img = $mime_type . base64_encode(file_get_contents(\public_path('uploads/ears/thumbnail/thumb_' . $ear_result->ear_img)));
        }
        return view('admin.ears.edit_view', compact(['ear_result']));
    }

    /**
     * Handle routs Controller update functionality
     * @author Tejas
     * @param  filename with extention OR ONLY file extention and secound param true
     * @return mime type
     */
    private function _base64_mime_type($filename = "", $extention_only = false)
    {
        $mime_types = config('mime_types');
        if (!$extention_only) {
            if (in_array(strtolower(strstr($filename, ".")), array_flip($mime_types['mime_types']))) {
                return "data:" . $mime_types['mime_types'][strtolower(strstr($filename, "."))] . ";base64,";
            }
        } else {
            if (in_array(strtolower($filename), array_flip($mime_types['mime_types']))) {
                return "data:" . $mime_types['mime_types'][strtolower($filename)] . ";base64,";
            }
        }
    }

    /**
     * Handle routs Controller update functionality
     * @author Tejas
     * @param  Update_id, Name, Alias, Description, Status
     * @return ear_master id update records accordingly
     */
    public function update_records(UpdateEarMasterRequest $request, $update_id = null)
    {
        // default response formate initialize
        $resp = config('response_format.RES_RESULT');
        // set ternary status as per database schema
        $status = 0;
        if ($request->has('status')) {
            $status = 1;
        }
        // Set Update data array for pass into update query
        $update_data = $this->_prepareUpdateData($request, [$status]);

        // File Upload Starts Folder Path : // root\public\uploads         
        if ($request->hasFile('filename')) {
            $filehandle = $this->_fileUploads($request);
            $update_data['ear_img'] = $filehandle['data']['filename'];
            // Remove Old Uploaded Files From Folder
            if ($filehandle['status']) {
                $ear_data = ear_master::find($update_id);
                if (isset($ear_data) && !empty($ear_data) && !empty($ear_data->ear_img) && file_exists(\public_path("uploads/ears/$ear_data->ear_img")) && file_exists(\public_path("uploads/ears/thumbnail/thumb_$ear_data->ear_img"))) {
                    unlink(\public_path("uploads/ears/$ear_data->ear_img"));
                    unlink(\public_path("uploads/ears/thumbnail/thumb_$ear_data->ear_img"));
                }
            }
        }
        // File Upload Ends

        $ear_obj = new ear_master();
        $ear_result = $ear_obj->update_records($update_data, $update_id);

        if (isset($ear_result) && $ear_result) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'Ear Updated successfully...!';
            $request->session()->put('success', $resp['message']);
            return redirect()->back()->with('success', $resp['message']);
        } else {
            $resp['message'] = 'Ear not Updated, Please try again...!';
            $request->session()->put('error', $resp['message']);
            return redirect()->back()->withInput()->with('error', $resp['message']);
        }
    }


    /**
     * _fileUploads : Complete Fileupload Handling
     * @author Tejas
     * @param  Request $request
     * @return File save
     */
    private function _fileUploads($request = "")
    {
        try {
            $fileNameOnly = preg_replace("/[^a-z0-9\_\-]/i", '', basename($request->file('filename')->getClientOriginalName(), '.' . $request->file('filename')->getClientOriginalExtension()));
            $fileFullName = $fileNameOnly . "_" . date('dmY') . "_" . time() . "." . $request->file('filename')->getClientOriginalExtension();
            $request->file('filename')->move(public_path('uploads/ears'), $fileFullName);
            // Thumbnail Image
            Image::make(public_path("uploads/ears/$fileFullName"))->resize(300, 200)->save(public_path("uploads/ears/thumbnail/thumb_$fileFullName"));
            $resp['status'] = true;
            $resp['data'] = array('filename' => $fileFullName, 'thumbnail' => "thumb_$fileFullName");
            $resp['message'] = "File uploaded successfully..!";
            return $resp;
        } catch (Exception $ex) {
            $resp['status'] = false;
            $resp['data'] = array('filename' => "", 'thumbnail' => "");
            $resp['message'] = $ex->getMessage();
            $resp['ex_message'] = $ex->getMessage();
            $resp['ex_code'] = $ex->getCode();
            $resp['ex_file'] = $ex->getFile();
            $resp['ex_line'] = $ex->getLine();
            $resp['message'] = 'Ear not inserted, Please try again...!';
            $request->session()->put('error', $resp['message']);
            return redirect()->back()->withInput()->with('error', $resp['message']);
        }
    }

    /**
     * Prepare Update Data Array
     * @author Tejas
     * @param  Request Inputs, (Optional) Addtional Array Datas
     * @return Array
     */
    private function _prepareUpdateData($request = "", $additional = array())
    {
        $preArr['ear_name'] = $request->input('ear_name');
        $preArr['ear_color'] = $request->input('ear_color');
        $preArr['ear_description'] = $request->input('ear_description');
        $preArr['status'] = $additional[0];
        return $preArr;
    }

    /**
     * Handle routs Controller delete functionality
     * @author Tejas
     * @param  ids
     * @return Boolean
     */
    public function delete_all_records(DeleteBulkRequest $request)
    {   // default response formate initialize
        $resp = config('response_format.RES_RESULT');
        $ear_obj = new ear_master();
        $ear_result = $ear_obj->delete_bulk_records($request->input('ids'));
        if (isset($ear_result) && $ear_result) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'Ears are Deleted successfully...!';
            $request->session()->put('success', $resp['message']);
        } else {
            $resp['message'] = 'Ears are not Deleted, Please try again...!';
            $request->session()->put('error', $resp['message']);
        }
        die(json_encode($resp));
    }

    /**
     * Handle routs Controller delete functionality
     * @author Tejas
     * @param  ids
     * @return Boolean
     */
    public function delete_records($delete_id)
    {   // default response formate initialize
        $resp = config('response_format.RES_RESULT');
        $ear_obj = new ear_master();
        $ear_result = $ear_obj->deleteRecords($delete_id);
        if (isset($ear_result) && $ear_result) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'Ear is Deleted successfully...!';
        } else {
            $resp['message'] = 'Ear is not Deleted, Please try again...!';
        }
        die(json_encode($resp));
    }


    /**
     * Handle routs Controller Status Update functionality
     * @author Tejas
     * @param  ids
     * @return Boolean
     */
    public function status_change(StatusUpdateRequest $request)
    {   // default response formate initialize
        $resp = config('response_format.RES_RESULT');
        $ear_obj = new ear_master();
        $ear_result = $ear_obj->update_records(['status' => ($request->input('status') == 1) ? 0 : 1], $request->input('id'));
        if (isset($ear_result) && $ear_result) {
            $resp['status'] = true;
            $resp['data'] = array();
            $dynamic_message = ($request->input('status') == 1) ? 'In-Activated' : 'Activated';
            $resp['message'] = "Ear $dynamic_message successfully...!";
        } else {
            $resp['message'] = 'Ear is not Active/In-Active, Please try again...!';
        }
        die(json_encode($resp));
    }


    /**
     * Get Ear List by Ear ID Data Array
     * @author Tejas
     * @param  Request Ear Id
     * @return Array
     */
    public function get_ear_id($ear_id = "")
    {
        $resp = config('response_format.RES_RESULT');
        try {
            if (!isset($ear_id) || empty($ear_id))
                throw new Exception('Ear Id not found..!', 1);

            $ear_obj = new ear_master();
            $ear_result = $ear_obj->get_recordby_Id($ear_id);

            if (isset($ear_result[0]['ear_img']) && !empty($ear_result[0]['ear_img']) && file_exists(\public_path('uploads/ears/thumbnail/thumb_' . $ear_result[0]['ear_img']))) {
                $mime_type = $this->_base64_mime_type($ear_result[0]['ear_img']);
                $ear_result[0]['ear_img'] = $mime_type . base64_encode(file_get_contents(\public_path('uploads/ears/thumbnail/thumb_' . $ear_result[0]['ear_img'])));
            }
            if (empty($ear_result))
                throw new Exception('Ear List not found..!', 422);

            $resp['status'] = true;
            $resp['message'] = "Ear List get successfully..!";
            $resp['data'] = $ear_result;
            return response()->json($resp, 200);
        } catch (Exception $ex) {
            $resp['message'] = $ex->getMessage();
            return response()->json($resp, 422);
        }
    }
}
