<?php

namespace App\Http\Controllers\Admin;

use Image;
use Exception;
use DataTables;
use App\Models\eyebrow_master;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteBulkRequest;
use App\Http\Requests\StatusUpdateRequest;
use App\Http\Requests\CreateEyebrowMasterRequest;
use App\Http\Requests\UpdateEyebrowMasterRequest;

class EyeBrowMasterController extends Controller
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
        return view('admin.eyebrows.add_view');
    }

    /**
     * Handle routs Controller add functionality
     * @author Tejas
     * @param  Name, Alias, Description, Status
     * @return success or fail flash message in view
     */
    public function insert_records(CreateEyebrowMasterRequest $request)
    {
        // default response formate initialize
        $resp = config('response_format.RES_RESULT');
        // set ternary status as per database schema
        $status = 0;
        if ($request->has('status')) {
            $status = 1;
        }
        // File Upload Starts Folder Path : // root\public\uploads        
        if ($request->hasFile('filename')) {
            $filehandle = $this->_fileUploads($request);
        }
        // File Upload Ends

        // Set Insert data array for pass into insert query
        $insert_data = $this->_prepareInsertData($request, [$status]);
        $insert_data['eye_brow_img'] = $filehandle['data']['filename'];
        $eyebrow_obj = new eyebrow_master();
        $eyebrow_result = $eyebrow_obj->insert_data($insert_data);

        if ($eyebrow_result->exists) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'Eyebrow inserted successfully...!';
            $request->session()->put('success', $resp['message']);
            return redirect()->back()->with('success', $resp['message']);
        } else {
            $resp['message'] = 'Eyebrow not inserted, Please try again...!';
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
        $preArr['eye_brow_name'] = $request->input('eye_brow_name');
        $preArr['eye_brow_color'] = $request->input('eye_brow_color');
        $preArr['eye_brow_description'] = $request->input('eye_brow_description');
        $preArr['status'] = $additional[0];
        return $preArr;
    }

    /**
     * Handle routs Controller load view request
     * @author Tejas
     * @param  none
     * @return eyebrows/view/list_view.blade.php
     */
    public function list_view(Request $request)
    {
        if ($request->ajax()) {
            $eyebrow_obj = new eyebrow_master;
            $list = $eyebrow_obj->list_all();
            return DataTables::of($list)
                ->addIndexColumn()
                ->addColumn('action', function ($list) {
                    $button = '';
                    $edit_button = '<a href="' . url("/admin/eyebrow_edit/{$list['eye_brow_id']}") . '" class="btn btn-xs btn-warning btn_edit" title="Edit"><i class="far fa-edit"></i> Edit</a> &nbsp;';
                    $delete_button = '<a href="#delete-' . $list['eye_brow_id'] . '" delete_id="' . $list['eye_brow_id'] . '" class="btn btn-xs btn-danger btn_delete" title="Delete"><i class="far fa-trash-alt"></i> Delete</a>';
                    $button .= $edit_button;
                    $button .= $delete_button;
                    return $button;
                })
                ->addColumn('status', function ($list) {
                    $button = '';
                    if ($list['status'])
                        $status_button = '<a href="#status-' . $list['status'] . '" class="btn btn-xs btn-success btn_status" title="Status Change" user_id=' . $list['eye_brow_id'] . ' status=' . $list['status'] . '><i class="fa fa-toggle-on" aria-hidden="true"></i> Active</a> &nbsp;';
                    else
                        $status_button = '<a href="#status-' . $list['status'] . '" class="btn btn-xs btn-warning btn_status" title="Status Change" user_id=' . $list['eye_brow_id'] . ' status=' . $list['status'] . '><i class="fa fa-toggle-off" aria-hidden="true"></i> In-Active</a>';
                    $button .= $status_button;
                    return $button;
                })
                ->addColumn('eye_brow_color', function ($list) {
                    if (!empty($list['eye_brow_color']))
                        return '<div class="" style="background-color:' . $list['eye_brow_color'] . '">&nbsp;</div>';
                })
                ->addColumn('eye_brow_img', function ($list) {
                    if (!empty($list['eye_brow_img']))
                        return '<img src="' . url('uploads/eyebrows/thumbnail/thumb_' . $list['eye_brow_img']) . '" title="Image" height="50" width="50"/>';
                })
                ->rawColumns(['action', 'status', 'eye_brow_color', 'eye_brow_img'])
                ->make(true);
        }
        return view('admin.eyebrows.list_view');
    }

    /**
     * Handle routs Controller Load Edit functionality
     * @author Tejas
     * @param  Role ID
     * @return eyebrow_master id wise records into edit view
     */
    public function get_edit_records($eye_brow_id = null)
    {
        $eyebrow_obj = new eyebrow_master();
        $eyebrow_result = eyebrow_master::find($eye_brow_id);

        if (isset($eyebrow_result->eye_brow_img) && !empty($eyebrow_result->eye_brow_img)) {
            $mime_type = $this->_base64_mime_type($eyebrow_result->eye_brow_img);
            $eyebrow_result->eye_brow_img = $mime_type . base64_encode(file_get_contents(\public_path('uploads/eyebrows/thumbnail/thumb_' . $eyebrow_result->eye_brow_img)));
        }
        return view('admin.eyebrows.edit_view', compact(['eyebrow_result']));
    }

    /**
     * Handle routs Controller update functionality
     * @author Tejas
     * @param  filename with extention OR ONLY file extention and secound param true
     * @return mime type
     */
    private function _base64_mime_type($filename = "", $extention_only = false)
    {
        if (!$extention_only) {
            $mime_types = config('mime_types');
            if (in_array(strstr($filename, "."), array_flip($mime_types['mime_types']))) {
                return "data:" . $mime_types['mime_types'][strstr($filename, ".")] . ";base64,";
            }
        } else {
            if (in_array($filename, array_flip($mime_types['mime_types']))) {
                return "data:" . $mime_types['mime_types'][$filename] . ";base64,";
            }
        }
    }

    /**
     * Handle routs Controller update functionality
     * @author Tejas
     * @param  Update_id, Name, Alias, Description, Status
     * @return eyebrow_master id update records accordingly
     */
    public function update_records(UpdateEyeBrowMasterRequest $request, $update_id = null)
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
            $update_data['eye_brow_img'] = $filehandle['data']['filename'];
            // Remove Old Uploaded Files From Folder
            if ($filehandle['status']) {
                $ear_data = eyebrow_master::find($update_id);
                if (isset($ear_data) && !empty($ear_data) && !empty($ear_data->eye_brow_img)) {
                    unlink(\public_path("uploads/eyebrows/$ear_data->eye_brow_img"));
                    unlink(\public_path("uploads/eyebrows/thumbnail/thumb_$ear_data->eye_brow_img"));
                }
            }
        }
        // File Upload Ends

        $eyebrow_obj = new eyebrow_master();
        $eyebrow_result = $eyebrow_obj->update_records($update_data, $update_id);

        if (isset($eyebrow_result) && $eyebrow_result) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'Eyebrow Updated successfully...!';
            $request->session()->put('success', $resp['message']);
            return redirect()->back()->with('success', $resp['message']);
        } else {
            $resp['message'] = 'Eyebrow not Updated, Please try again...!';
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
            $fileNameOnly = basename($request->file('filename')->getClientOriginalName(), '.' . $request->file('filename')->getClientOriginalExtension());
            $fileFullName = $fileNameOnly . "_" . date('dmY') . "_" . time() . "." . $request->file('filename')->getClientOriginalExtension();
            $request->file('filename')->move(public_path('uploads/eyebrows'), $fileFullName);
            // Thumbnail Image
            Image::make(public_path("uploads/eyebrows/$fileFullName"))->resize(300, 200)->save(public_path("uploads/eyebrows/thumbnail/thumb_$fileFullName"));
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
            $resp['message'] = 'Eyebrow not inserted, Please try again...!';
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
        $preArr['eye_brow_name'] = $request->input('eye_brow_name');
        $preArr['eye_brow_color'] = $request->input('eye_brow_color');
        $preArr['eye_brow_description'] = $request->input('eye_brow_description');
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
        $eyebrow_obj = new eyebrow_master();
        $eyebrow_result = $eyebrow_obj->delete_bulk_records($request->input('ids'));
        if (isset($eyebrow_result) && $eyebrow_result) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'Eyebrows are Deleted successfully...!';
            $request->session()->put('success', $resp['message']);
        } else {
            $resp['message'] = 'Eyebrows are not Deleted, Please try again...!';
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
        $eyebrow_obj = new eyebrow_master();
        $eyebrow_result = $eyebrow_obj->deleteRecords($delete_id);
        if (isset($eyebrow_result) && $eyebrow_result) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'Eyebrow is Deleted successfully...!';
        } else {
            $resp['message'] = 'Eyebrow is not Deleted, Please try again...!';
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
        $eyebrow_obj = new eyebrow_master();
        $eyebrow_result = $eyebrow_obj->update_records(['status' => ($request->input('status') == 1) ? 0 : 1], $request->input('id'));
        if (isset($eyebrow_result) && $eyebrow_result) {
            $resp['status'] = true;
            $resp['data'] = array();
            $dynamic_message = ($request->input('status') == 1) ? 'In-Activated' : 'Activated';
            $resp['message'] = "Eyebrow $dynamic_message successfully...!";
        } else {
            $resp['message'] = 'Eyebrow is not Active/In-Active, Please try again...!';
        }
        die(json_encode($resp));
    }
}
