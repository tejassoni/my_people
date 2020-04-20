<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\role_master;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteUserRoleRequest;
use App\Http\Requests\StatusUserRoleRequest;
use App\Http\Requests\UpdateUserRoleRequest;
use App\Http\Requests\CreateUserRolesRequest;

class UserRolesController extends Controller
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
        return view('admin.roles.add_view');
    }

    /**
     * Handle routs Controller add functionality
     * @author Tejas
     * @param  Name, Alias, Description, Status
     * @return success or fail flash message in view
     */
    public function insert_records(CreateUserRolesRequest $request)
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
        $role_obj = new role_master();
        $role_result = $role_obj->insert_data($insert_data);

        if ($role_result->exists) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'User role inserted successfully...!';
            $request->session()->put('success', $resp['message']);
            return redirect()->back()->with('success', $resp['message']);
        } else {
            $resp['message'] = 'User role not inserted, Please try again...!';
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
        $insertArr['role_name'] = $request->input('role_name');
        $insertArr['role_alias'] = $request->input('role_alias');
        $insertArr['role_description'] = $request->input('role_name');
        $insertArr['status'] = $additional[0];
        return $insertArr;
    }

    /**
     * Handle routs Controller load view request
     * @author Tejas
     * @param  none
     * @return role/view/list_view.blade.php
     */
    public function list_view(Request $request)
    {
        if ($request->ajax()) {
            $role_obj = new role_master;
            $list = $role_obj->list_all();
            return DataTables::of($list)
                ->addIndexColumn()
                ->addColumn('action', function ($list) {
                    $button = '';
                    $edit_button = '<a href="' . url("/admin/role_edit/{$list['role_id']}") . '" class="btn btn-xs btn-warning btn_edit"><i class="far fa-edit"></i> Edit</a> &nbsp;';
                    $delete_button = '<a href="#delete-' . $list['role_id'] . '" delete_id="' . $list['role_id'] . '" class="btn btn-xs btn-danger btn_delete"><i class="far fa-trash-alt"></i> Delete</a>';
                    $button .= $edit_button;
                    $button .= $delete_button;
                    return $button;
                })
                ->addColumn('status', function ($list) {
                    $button = '';
                    if ($list['status'])
                        $status_button = '<a href="#status-' . $list['status'] . '" class="btn btn-xs btn-success btn_status" user_id=' . $list['role_id'] . ' status=' . $list['status'] . '><i class="fa fa-toggle-on" aria-hidden="true"></i> Active</a> &nbsp;';
                    else
                        $status_button = '<a href="#status-' . $list['status'] . '" class="btn btn-xs btn-warning btn_status" user_id=' . $list['role_id'] . ' status=' . $list['status'] . '><i class="fa fa-toggle-off" aria-hidden="true"></i> In-Active</a>';
                    $button .= $status_button;
                    return $button;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.roles.list_view');
    }

    /**
     * Handle routs Controller Load Edit functionality
     * @author Tejas
     * @param  Role ID
     * @return role_master id wise records into edit view
     */
    public function get_edit_records($role_id = null)
    {
        $role_obj = new role_master();
        $role_result = role_master::find($role_id);
        return view('admin.roles.edit_view', compact(['role_result']));
    }

    /**
     * Handle routs Controller update functionality
     * @author Tejas
     * @param  Update_id, Name, Alias, Description, Status
     * @return role_master id update records accordingly
     */
    public function update_records(UpdateUserRoleRequest $request, $update_id = null)
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
        $role_obj = new role_master();
        $role_result = $role_obj->update_records($update_data, $update_id);

        if (isset($role_result) && $role_result) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'User role Updated successfully...!';
            $request->session()->put('success', $resp['message']);
            return redirect()->back()->with('success', $resp['message']);
        } else {
            $resp['message'] = 'User role not Updated, Please try again...!';
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
        $updateArr['role_name'] = $request->input('role_name');
        $updateArr['role_alias'] = $request->input('role_alias');
        $updateArr['role_description'] = $request->input('role_name');
        $updateArr['status'] = $additional[0];
        return $updateArr;
    }

    /**
     * Handle routs Controller delete functionality
     * @author Tejas
     * @param  ids
     * @return Boolean
     */
    public function delete_all_records(DeleteUserRoleRequest $request)
    {   // default response formate initialize
        $resp = config('response_format.RES_RESULT');
        $role_obj = new role_master();
        $role_result = $role_obj->delete_bulk_records($request->input('ids'));
        if (isset($role_result) && $role_result) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'User Roles Deleted successfully...!';
            $request->session()->put('success', $resp['message']);
        } else {
            $resp['message'] = 'User Roles are not Deleted, Please try again...!';
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
        $role_obj = new role_master();
        $role_result = $role_obj->deleteRecords($delete_id);
        if (isset($role_result) && $role_result) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'User Role is Deleted successfully...!';
        } else {
            $resp['message'] = 'User Role is not Deleted, Please try again...!';
        }
        die(json_encode($resp));
    }


    /**
     * Handle routs Controller Status Update functionality
     * @author Tejas
     * @param  ids
     * @return Boolean
     */
    public function status_change(StatusUserRoleRequest $request)
    {   // default response formate initialize
        $resp = config('response_format.RES_RESULT');
        $role_obj = new role_master();
        $role_result = $role_obj->update_records(['status' => ($request->input('status') == 1) ? 0 : 1], $request->input('id'));
        if (isset($role_result) && $role_result) {
            $resp['status'] = true;
            $resp['data'] = array();
            $dynamic_message = ($request->input('status') == 1) ? 'In-Activated' : 'Activated';
            $resp['message'] = "User Role $dynamic_message successfully...!";
        } else {
            $resp['message'] = 'User Role is not Active/In-Active, Please try again...!';
        }
        die(json_encode($resp));
    }
}
