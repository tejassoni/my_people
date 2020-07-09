<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\subscription_master;
use App\Models\plan_master;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteBulkRequest;
use App\Http\Requests\StatusUpdateRequest;
use App\Http\Requests\UpdateSubscriptionRequest;
use App\Http\Requests\CreateSubscriptionRequest;

class SubscriptionMasterController extends Controller
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
        $plan_obj = new plan_master();
        $plan_result = $plan_obj->list_active_all();
        return view('admin.subscriptions.add_view', compact(['plan_result']));
    }

    /**
     * Handle routs Controller add functionality
     * @author Tejas
     * @param  Name, Alias, Description, Status
     * @return success or fail flash message in view
     */
    public function insert_records(CreateSubscriptionRequest $request)
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
        $sub_obj = new subscription_master();
        $subscription_result = $sub_obj->insert_data($insert_data);

        if ($subscription_result->exists) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'Subscription inserted successfully...!';
            $request->session()->put('success', $resp['message']);
            return redirect()->back()->with('success', $resp['message']);
        } else {
            $resp['message'] = 'Subscription not inserted, Please try again...!';
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
        $preArr['sub_name'] = $request->input('sub_name');
        $preArr['sub_alias'] = $request->input('sub_alias');
        $preArr['plan_id'] = $request->input('plan_id_select');
        $preArr['sub_description'] = $request->input('sub_description');
        $preArr['status'] = $additional[0];
        return $preArr;
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
            $sub_obj = new subscription_master;
            $list = $sub_obj->list_belongsTo();

            return DataTables::of($list)
                ->addIndexColumn()
                ->addColumn('action', function ($list) {
                    $button = '';
                    $edit_button = '<a href="' . url("/admin/subscription_edit/{$list['sub_id']}") . '" class="btn btn-xs btn-warning btn_edit" title="Edit"><i class="far fa-edit"></i> Edit</a> &nbsp;';
                    $delete_button = '<a href="#delete-' . $list['sub_id'] . '" delete_id="' . $list['sub_id'] . '" class="btn btn-xs btn-danger btn_delete" title="Delete"><i class="far fa-trash-alt"></i> Delete</a>';
                    $button .= $edit_button;
                    $button .= $delete_button;
                    return $button;
                })
                ->addColumn('status', function ($list) {
                    $button = '';
                    if ($list['status'])
                        $status_button = '<a href="#status-' . $list['status'] . '" class="btn btn-xs btn-success btn_status" title="Status Change" sub_id=' . $list['sub_id'] . ' status=' . $list['status'] . '><i class="fa fa-toggle-on" aria-hidden="true"></i> Active</a> &nbsp;';
                    else
                        $status_button = '<a href="#status-' . $list['status'] . '" class="btn btn-xs btn-warning btn_status" title="Status Change" sub_id=' . $list['sub_id'] . ' status=' . $list['status'] . '><i class="fa fa-toggle-off" aria-hidden="true"></i> In-Active</a>';
                    $button .= $status_button;
                    return $button;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.subscriptions.list_view');
    }

    /**
     * Handle routs Controller Load Edit functionality
     * @author Tejas
     * @param  Role ID
     * @return subscription_master id wise records into edit view
     */
    public function get_edit_records($sub_id = null)
    {
        $sub_obj = new subscription_master();
        $subscription_result = subscription_master::find($sub_id);
        $plan_obj = new plan_master();
        $plan_result = $plan_obj->list_active_all();
        return view('admin.subscriptions.edit_view', compact(['subscription_result', 'plan_result']));
    }

    /**
     * Handle routs Controller update functionality
     * @author Tejas
     * @param  Update_id, Name, Alias, Description, Status
     * @return subscription_master id update records accordingly
     */
    public function update_records(UpdateSubscriptionRequest $request, $update_id = null)
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
        $sub_obj = new subscription_master();
        $subscription_result = $sub_obj->update_records($update_data, $update_id);

        if (isset($subscription_result) && $subscription_result) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'Subscription Updated successfully...!';
            $request->session()->put('success', $resp['message']);
            return redirect()->back()->with('success', $resp['message']);
        } else {
            $resp['message'] = 'Subscription not Updated, Please try again...!';
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
        $preArr['sub_name'] = $request->input('sub_name');
        $preArr['sub_alias'] = $request->input('sub_alias');
        $preArr['plan_id'] = $request->input('plan_id_select');
        $preArr['sub_description'] = $request->input('sub_description');
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
        $sub_obj = new subscription_master();

        $subscription_result = $sub_obj->delete_bulk_records($request->input('ids'));
        if (isset($subscription_result) && $subscription_result) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'Subscriptions Deleted successfully...!';
            $request->session()->put('success', $resp['message']);
        } else {
            $resp['message'] = 'Subscriptions are not Deleted, Please try again...!';
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
        $sub_obj = new subscription_master();
        $subscription_result = $sub_obj->deleteRecords($delete_id);
        if (isset($subscription_result) && $subscription_result) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'Subscription is Deleted successfully...!';
        } else {
            $resp['message'] = 'Subscription is not Deleted, Please try again...!';
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
        $sub_obj = new subscription_master();
        $subscription_result = $sub_obj->update_records(['status' => ($request->input('status') == 1) ? 0 : 1], $request->input('id'));
        if (isset($subscription_result) && $subscription_result) {
            $resp['status'] = true;
            $resp['data'] = array();
            $dynamic_message = ($request->input('status') == 1) ? 'In-Activated' : 'Activated';
            $resp['message'] = "Subscription $dynamic_message successfully...!";
        } else {
            $resp['message'] = 'Subscription is not Active/In-Active, Please try again...!';
        }
        die(json_encode($resp));
    }
}
