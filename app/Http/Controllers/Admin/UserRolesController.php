<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\role_master;
use Illuminate\Http\Request;
use App\Http\Requests\CreateUserRolesRequest;
use App\Http\Requests\UpdateUserRoleRequest;
use Illuminate\Support\Facades\URL;
use DataTables;
use PhpOffice\PhpSpreadsheet\Calculation\Category;


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
     * Handle routs Controller view request
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
                        $status_button = '<a href="#status-' . $list['status'] . '" class="btn btn-xs btn-success"><i class="fa fa-toggle-on" aria-hidden="true"></i> Active</a> &nbsp;';
                    else
                        $status_button = '<a href="#status-' . $list['status'] . '" class="btn btn-xs btn-warning"><i class="fa fa-toggle-off" aria-hidden="true"></i> In-Active</a>';
                    $button .= $status_button;
                    return $button;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.list_view');
    }

    /**
     * Handle routs Controller add request
     * @author Tejas
     * @param  none
     * @return role/view/add_view.blade.php
     */
    public function add_view()
    {
        $data = array(123);
        return view('admin.add_view', $data);
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
        $insert_data = array(
            'role_name' => $request->input('role_name'),
            'role_alias' => $request->input('role_alias'),
            'role_description' => $request->input('role_description'),
            'status' => $status,
        );

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
     * Handle routs Controller get edit functionality
     * @author Tejas
     * @param  Name, Alias, Description, Status
     * @return role_master id wise records into edit view
     */
    public function get_edit_records($role_id = null)
    {
        $role_obj = new role_master();
        $role_result = role_master::find($role_id);
        return view('admin.edit_view', compact(['role_result']));
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
        $update_data = array(
            'role_name' => $request->input('role_name'),
            'role_alias' => $request->input('role_alias'),
            'role_description' => $request->input('role_description'),
            'status' => $status,
        );

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
}
