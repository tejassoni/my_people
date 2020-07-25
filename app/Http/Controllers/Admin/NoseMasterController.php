<?php

namespace App\Http\Controllers\Admin;

use Image;
use Exception;
use DataTables;
use App\Models\nose_master;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteBulkRequest;
use App\Http\Requests\StatusUpdateRequest;
use App\Http\Requests\CreateNoseMasterRequest;
use App\Http\Requests\UpdateNoseMasterRequest;

class NoseMasterController extends Controller
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
        return view('admin.noses.add_view');
    }

    /**
     * Handle routs Controller add functionality
     * @author Tejas
     * @param  Name, Alias, Description, Status
     * @return success or fail flash message in view
     */
    public function insert_records(CreateNoseMasterRequest $request)
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
            $insert_data['nose_img'] = $filehandle['data']['filename'];
        }
        // File Upload Ends
        $nose_obj = new nose_master();
        $nose_result = $nose_obj->insert_data($insert_data);

        if ($nose_result->exists) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'Nose inserted successfully...!';
            $request->session()->put('success', $resp['message']);
            return redirect()->back()->with('success', $resp['message']);
        } else {
            $resp['message'] = 'Nose not inserted, Please try again...!';
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
        $preArr['nose_name'] = $request->input('nose_name');
        $preArr['nose_color'] = $request->input('nose_color');
        $preArr['nose_description'] = $request->input('nose_description');
        $preArr['status'] = $additional[0];
        return $preArr;
    }

    /**
     * Handle routs Controller load view request
     * @author Tejas
     * @param  none
     * @return noses/view/list_view.blade.php
     */
    public function list_view(Request $request)
    {
        if ($request->ajax()) {
            $nose_obj = new nose_master;
            $list = $nose_obj->list_all();
            return DataTables::of($list)
                ->addIndexColumn()
                ->addColumn('action', function ($list) {
                    $button = '';
                    $edit_button = '<a href="' . url("/admin/nose_edit/{$list['nose_id']}") . '" class="btn btn-xs btn-warning btn_edit" title="Edit"><i class="far fa-edit"></i> Edit</a> &nbsp;';
                    $delete_button = '<a href="#delete-' . $list['nose_id'] . '" delete_id="' . $list['nose_id'] . '" class="btn btn-xs btn-danger btn_delete" title="Delete"><i class="far fa-trash-alt"></i> Delete</a>';
                    $button .= $edit_button;
                    $button .= $delete_button;
                    return $button;
                })
                ->addColumn('status', function ($list) {
                    $button = '';
                    if ($list['status'])
                        $status_button = '<a href="#status-' . $list['status'] . '" class="btn btn-xs btn-success btn_status" title="Status Change" user_id=' . $list['nose_id'] . ' status=' . $list['status'] . '><i class="fa fa-toggle-on" aria-hidden="true"></i> Active</a> &nbsp;';
                    else
                        $status_button = '<a href="#status-' . $list['status'] . '" class="btn btn-xs btn-warning btn_status" title="Status Change" user_id=' . $list['nose_id'] . ' status=' . $list['status'] . '><i class="fa fa-toggle-off" aria-hidden="true"></i> In-Active</a>';
                    $button .= $status_button;
                    return $button;
                })
                ->addColumn('nose_color', function ($list) {
                    if (!empty($list['nose_color']))
                        return '<div class="" style="background-color:' . $list['nose_color'] . '">&nbsp;</div>';
                })
                ->addColumn('nose_img', function ($list) {
                    if (!empty($list['nose_img']))
                        return '<img src="' . url('uploads/noses/thumbnail/thumb_' . $list['nose_img']) . '" title="Image" height="50" width="50"/>';
                })
                ->rawColumns(['action', 'status', 'nose_color', 'nose_img'])
                ->make(true);
        }
        return view('admin.noses.list_view');
    }

    /**
     * Handle routs Controller Load Edit functionality
     * @author Tejas
     * @param  Nose ID
     * @return nose_master id wise records into edit view
     */
    public function get_edit_records($nose_id = null)
    {
        $nose_obj = new nose_master();
        $nose_result = nose_master::find($nose_id);

        if (isset($nose_result->nose_img) && !empty($nose_result->nose_img) && file_exists(\public_path('uploads/noses/thumbnail/thumb_' . $nose_result->nose_img))) {
            $mime_type = $this->_base64_mime_type($nose_result->nose_img);
            $nose_result->nose_img = $mime_type . base64_encode(file_get_contents(\public_path('uploads/noses/thumbnail/thumb_' . $nose_result->nose_img)));
        }
        return view('admin.noses.edit_view', compact(['nose_result']));
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
     * @return nose_master id update records accordingly
     */
    public function update_records(UpdateNoseMasterRequest $request, $update_id = null)
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
            $update_data['nose_img'] = $filehandle['data']['filename'];
            // Remove Old Uploaded Files From Folder
            if ($filehandle['status']) {
                $nose_data = nose_master::find($update_id);
                if (isset($nose_data) && !empty($nose_data) && !empty($nose_data->nose_img) && file_exists(\public_path("uploads/noses/$nose_data->nose_img")) && file_exists(\public_path("uploads/noses/thumbnail/thumb_$nose_data->nose_img"))) {
                    unlink(\public_path("uploads/noses/$nose_data->nose_img"));
                    unlink(\public_path("uploads/noses/thumbnail/thumb_$nose_data->nose_img"));
                }
            }
        }
        // File Upload Ends

        $nose_obj = new nose_master();
        $nose_result = $nose_obj->update_records($update_data, $update_id);

        if (isset($nose_result) && $nose_result) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'Nose Updated successfully...!';
            $request->session()->put('success', $resp['message']);
            return redirect()->back()->with('success', $resp['message']);
        } else {
            $resp['message'] = 'Nose not Updated, Please try again...!';
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
            $request->file('filename')->move(public_path('uploads/noses'), $fileFullName);
            // Thumbnail Image
            Image::make(public_path("uploads/noses/$fileFullName"))->resize(300, 200)->save(public_path("uploads/noses/thumbnail/thumb_$fileFullName"));
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
            $resp['message'] = 'Nose not inserted, Please try again...!';
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
        $preArr['nose_name'] = $request->input('nose_name');
        $preArr['nose_color'] = $request->input('nose_color');
        $preArr['nose_description'] = $request->input('nose_description');
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
        $nose_obj = new nose_master();
        $nose_result = $nose_obj->delete_bulk_records($request->input('ids'));
        if (isset($nose_result) && $nose_result) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'Noses are Deleted successfully...!';
            $request->session()->put('success', $resp['message']);
        } else {
            $resp['message'] = 'Noses are not Deleted, Please try again...!';
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
        $nose_obj = new nose_master();
        $nose_result = $nose_obj->deleteRecords($delete_id);
        if (isset($nose_result) && $nose_result) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'Nose is Deleted successfully...!';
        } else {
            $resp['message'] = 'Nose is not Deleted, Please try again...!';
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
        $nose_obj = new nose_master();
        $nose_result = $nose_obj->update_records(['status' => ($request->input('status') == 1) ? 0 : 1], $request->input('id'));
        if (isset($nose_result) && $nose_result) {
            $resp['status'] = true;
            $resp['data'] = array();
            $dynamic_message = ($request->input('status') == 1) ? 'In-Activated' : 'Activated';
            $resp['message'] = "Nose $dynamic_message successfully...!";
        } else {
            $resp['message'] = 'Nose is not Active/In-Active, Please try again...!';
        }
        die(json_encode($resp));
    }


    /**
     * Get Nose List by Nose ID Data Array
     * @author Tejas
     * @param  Request Nose Id
     * @return Array
     */
    public function get_nose_id($nose_id = "")
    {
        $resp = config('response_format.RES_RESULT');
        try {
            if (!isset($nose_id) || empty($nose_id))
                throw new Exception('Nose Id not found..!', 1);

            $nose_obj = new nose_master();
            $nose_result = $nose_obj->get_recordby_Id($nose_id);

            if (isset($nose_result[0]['nose_img']) && !empty($nose_result[0]['nose_img']) && file_exists(\public_path('uploads/noses/thumbnail/thumb_' . $nose_result[0]['nose_img']))) {
                $mime_type = $this->_base64_mime_type($nose_result[0]['nose_img']);
                $nose_result[0]['nose_img'] = $mime_type . base64_encode(file_get_contents(\public_path('uploads/noses/thumbnail/thumb_' . $nose_result[0]['nose_img'])));
            }
            if (empty($nose_result))
                throw new Exception('Nose List not found..!', 422);

            $resp['status'] = true;
            $resp['message'] = "Nose List get successfully..!";
            $resp['data'] = $nose_result;
            return response()->json($resp, 200);
        } catch (Exception $ex) {
            $resp['message'] = $ex->getMessage();
            return response()->json($resp, 422);
        }
    }
}
