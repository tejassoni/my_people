<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use Image;
use Exception;
use App\Models\role_master;
use App\Models\user_master;
use Illuminate\Http\Request;
use App\Models\subscription_master;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\DeleteBulkRequest;
use App\Http\Requests\StatusUpdateRequest;
use App\Http\Requests\UpdateUserRequest;

class UserManagementController extends Controller
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
     * @return user/view/add_view.blade.php
     */
    public function add_view()
    {
        $role_obj = new role_master();
        $role_result = $role_obj->list_all();
        $subscription_result = (new subscription_master())->list_all();
        return view('admin.users.add_view', compact(['role_result', 'subscription_result']));
    }

    /**
     * Handle routs Controller add functionality
     * @author Tejas
     * @param  Name, Alias, Description, Status
     * @return success or fail flash message in view
     */
    public function insert_records(CreateUserRequest $request)
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
            $insert_data['user_img'] = $filehandle['data']['filename'];
        }
        // File Upload Ends

        $user_obj = new user_master();
        $user_result = $user_obj->insert_data($insert_data);

        if ($user_result->exists) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'User inserted successfully...!';
            $request->session()->put('success', $resp['message']);
            return redirect()->back()->with('success', $resp['message']);
        } else {
            $resp['message'] = 'User not inserted, Please try again...!';
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
        $preArr['f_name'] = $request->input('first_name');
        $preArr['m_name'] = $request->input('middle_name');
        $preArr['l_name'] = $request->input('last_name');
        $preArr['address'] = $request->input('user_address');
        $preArr['mobile'] = $request->input('mobile');
        $preArr['email'] = $request->input('email');
        $preArr['password'] = $request->input('password');
        $preArr['role_id'] = $request->input('role_id_select');
        $preArr['subscription_id'] = $request->input('subscription_id_select');
        $preArr['status'] = $additional[0];
        return $preArr;
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
            $request->file('filename')->move(public_path('uploads/users'), $fileFullName);
            // Thumbnail Image
            Image::make(public_path("uploads/users/$fileFullName"))->resize(300, 200)->save(public_path("uploads/users/thumbnail/thumb_$fileFullName"));
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
            $resp['message'] = 'User Image not inserted, Please try again...!';
            $request->session()->put('error', $resp['message']);
            return redirect()->back()->withInput()->with('error', $resp['message']);
        }
    }

    /**
     * Handle routs Controller load view request
     * @author Tejas
     * @param  none
     * @return user/view/list_view.blade.php
     */
    public function list_view(Request $request)
    {
        if ($request->ajax()) {
            $user_obj = new user_master;
            $list = $user_obj->list_all_join();

            return DataTables::of($list)
                ->addIndexColumn()
                ->addColumn('action', function ($list) {
                    $button = '';
                    $edit_button = '<a href="' . url("/admin/user_edit/{$list['user_id']}") . '" class="btn btn-xs btn-warning btn_edit" title="Edit"><i class="far fa-edit"></i> Edit</a> &nbsp;';
                    $delete_button = '<a href="#delete-' . $list['user_id'] . '" delete_id="' . $list['user_id'] . '" class="btn btn-xs btn-danger btn_delete" title="Delete"><i class="far fa-trash-alt"></i> Delete</a>';
                    $button .= $edit_button;
                    $button .= $delete_button;
                    return $button;
                })
                ->addColumn('user_img', function ($list) {
                    if (!empty($list['user_img']))
                        return '<img src="' . url('uploads/users/thumbnail/thumb_' . $list['user_img']) . '" title="Image" height="50" width="50"/>';
                })
                ->addColumn('status', function ($list) {
                    $button = '';
                    if ($list['status'])
                        $status_button = '<a href="#status-' . $list['status'] . '" class="btn btn-xs btn-success btn_status" title="Status Change" user_id=' . $list['user_id'] . ' status=' . $list['status'] . '><i class="fa fa-toggle-on" aria-hidden="true"></i> Active</a> &nbsp;';
                    else
                        $status_button = '<a href="#status-' . $list['status'] . '" class="btn btn-xs btn-warning btn_status" title="Status Change" user_id=' . $list['user_id'] . ' status=' . $list['status'] . '><i class="fa fa-toggle-off" aria-hidden="true"></i> In-Active</a>';
                    $button .= $status_button;
                    return $button;
                })
                ->rawColumns(['action', 'status', 'user_img'])
                ->make(true);
        }
        return view('admin.users.list_view');
    }

    /**
     * Handle routs Controller Load Edit functionality
     * @author Tejas
     * @param  User ID
     * @return user_master id wise records into edit view
     */
    public function get_edit_records($id = null)
    {
        $role_obj = new role_master();
        $role_result = $role_obj->list_all();
        $subscription_result = (new subscription_master())->list_all();
        $user_result = (new user_master())->find($id);
        if (isset($user_result->user_img) && !empty($user_result->user_img)) {
            $mime_type = $this->_base64_mime_type($user_result->user_img);
            // dd($mime_type, $user_result->user_img);
            $user_result->user_img = $mime_type . base64_encode(file_get_contents(\public_path('uploads/users/thumbnail/thumb_' . $user_result->user_img)));
        }
        return view('admin.users.edit_view', compact(['user_result', 'role_result', 'subscription_result']));
    }

    /**
     * Handle routs Controller update functionality
     * @author Tejas
     * @param  Update_id, Name, Alias, Description, Status
     * @return user_master id update records accordingly
     */
    public function update_records(UpdateUserRequest $request, $update_id = null)
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
            $update_data['user_img'] = $filehandle['data']['filename'];
            // Remove Old Uploaded Files From Folder
            if ($filehandle['status']) {
                $user_data = user_master::find($update_id);
                if (isset($user_data) && !empty($user_data) && !empty($user_data->user_img)) {
                    unlink(\public_path("uploads/users/$user_data->user_img"));
                    unlink(\public_path("uploads/users/thumbnail/thumb_$user_data->user_img"));
                }
            }
        }
        // File Upload Ends

        $user_obj = new user_master();
        $user_result = $user_obj->update_records($update_data, $update_id);

        if (isset($user_result) && $user_result) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'User Updated successfully...!';
            $request->session()->put('success', $resp['message']);
            return redirect()->back()->with('success', $resp['message']);
        } else {
            $resp['message'] = 'User not Updated, Please try again...!';
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
        $preArr['f_name'] = $request->input('first_name');
        $preArr['m_name'] = $request->input('middle_name');
        $preArr['l_name'] = $request->input('last_name');
        $preArr['address'] = $request->input('user_address');
        $preArr['mobile'] = $request->input('mobile');
        $preArr['email'] = $request->input('email');
        $preArr['role_id'] = $request->input('role_id_select');
        $preArr['subscription_id'] = $request->input('subscription_id_select');
        $preArr['status'] = $additional[0];
        return $preArr;
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
     * Handle routs Controller delete functionality
     * @author Tejas
     * @param  ids
     * @return Boolean
     */
    public function delete_all_records(DeleteBulkRequest $request)
    {   // default response formate initialize
        $resp = config('response_format.RES_RESULT');
        $user_obj = new user_master();
        $user_result = $user_obj->delete_bulk_records($request->input('ids'));
        if (isset($user_result) && $user_result) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'User Deleted successfully...!';
            $request->session()->put('success', $resp['message']);
        } else {
            $resp['message'] = 'User are not Deleted, Please try again...!';
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
        $user_obj = new user_master();
        $user_result = $user_obj->deleteRecords($delete_id);
        if (isset($user_result) && $user_result) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'User is Deleted successfully...!';
        } else {
            $resp['message'] = 'User is not Deleted, Please try again...!';
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
        $user_obj = new user_master();
        $user_result = $user_obj->update_records(['status' => ($request->input('status') == 1) ? 0 : 1], $request->input('id'));
        if (isset($user_result) && $user_result) {
            $resp['status'] = true;
            $resp['data'] = array();
            $dynamic_message = ($request->input('status') == 1) ? 'In-Activated' : 'Activated';
            $resp['message'] = "User $dynamic_message successfully...!";
        } else {
            $resp['message'] = 'User is not Active/In-Active, Please try again...!';
        }
        die(json_encode($resp));
    }
}
