<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\role_master;
use Illuminate\Http\Request;
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
     * Handle routs Controller view request
     * @author Tejas
     * @param  none
     * @return role/view/list_view.blade.php
     */
    public function list_view()
    {
        $data = array(123);
        return view('admin.list_view', $data);
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

}
