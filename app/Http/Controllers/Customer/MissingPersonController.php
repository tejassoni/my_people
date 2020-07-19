<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\missing_person;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteBulkRequest;
use App\Http\Requests\StatusUpdateRequest;
use App\Http\Requests\UpdateDiscountRequest;
use App\Http\Requests\CreateDiscountRequest;

class MissingPersonController extends Controller
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
        return view('customer.missing_persons.add_view');
    }

    /**
     * Handle routs Controller add functionality
     * @author Tejas
     * @param  Name, Alias, Description, Status
     * @return success or fail flash message in view
     */
    public function insert_records(CreateDiscountRequest $request)
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

        $discount_obj = new missing_person();
        $discount_result = $discount_obj->insert_data($insert_data);

        if ($discount_result->exists) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'Discount inserted successfully...!';
            $request->session()->put('success', $resp['message']);
            return redirect()->back()->with('success', $resp['message']);
        } else {
            $resp['message'] = 'Discount not inserted, Please try again...!';
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
        $start_date = null;
        $end_date = null;
        if ($request->has('discount_validity')) {
            $explodeDates = explode(" - ", $request->input('discount_validity'));
            $start_date = date("Y-m-d", strtotime(str_replace("/", "-", $explodeDates[0])));
            $end_date = date("Y-m-d", strtotime(str_replace("/", "-", $explodeDates[1])));
        }
        $preArr['discount_name'] = $request->input('discount_name');
        $preArr['discount_description'] = $request->input('discount_description');
        $preArr['discount_type'] = $request->input('discount_type_select');
        $preArr['amount'] = ($request->has('discount_amount')) ? $request->input('discount_amount') : 0;
        $preArr['is_discount_validity'] = ($request->has('discount_validity_chkbx')) ? $request->input('discount_validity_chkbx') : 0;
        $preArr['start_date'] = $start_date;
        $preArr['end_date'] = $end_date;
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
            $discount_obj = new missing_person;
            $list = $discount_obj->list_all();
            return DataTables::of($list)
                ->addIndexColumn()
                ->addColumn('action', function ($list) {
                    $button = '';
                    $edit_button = '<a href="' . url("/admin/discount_edit/{$list['discount_id']}") . '" class="btn btn-xs btn-warning btn_edit" title="Edit"><i class="far fa-edit"></i> Edit</a> &nbsp;';
                    $delete_button = '<a href="#delete-' . $list['discount_id'] . '" delete_id="' . $list['discount_id'] . '" class="btn btn-xs btn-danger btn_delete" title="Delete"><i class="far fa-trash-alt"></i> Delete</a>';
                    $button .= $edit_button;
                    $button .= $delete_button;
                    return $button;
                })
                ->addColumn('status', function ($list) {
                    $button = '';
                    if ($list['status'])
                        $status_button = '<a href="#status-' . $list['status'] . '" class="btn btn-xs btn-success btn_status" title="Status Change" discount_id=' . $list['discount_id'] . ' status=' . $list['status'] . '><i class="fa fa-toggle-on" aria-hidden="true"></i> Active</a> &nbsp;';
                    else
                        $status_button = '<a href="#status-' . $list['status'] . '" class="btn btn-xs btn-warning btn_status" title="Status Change" discount_id=' . $list['discount_id'] . ' status=' . $list['status'] . '><i class="fa fa-toggle-off" aria-hidden="true"></i> In-Active</a>';
                    $button .= $status_button;
                    return $button;
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('customer.missing_persons.list_view');
    }

    /**
     * Handle routs Controller Load Edit functionality
     * @author Tejas
     * @param  Role ID
     * @return missing_person id wise records into edit view
     */
    public function get_edit_records($discount_id = null)
    {
        $discount_obj = new missing_person();
        $discount_result = $discount_obj->getRecordById($discount_id);
        return view('customer.missing_persons.edit_view', compact(['discount_result']));
    }

    /**
     * Handle routs Controller update functionality
     * @author Tejas
     * @param  Update_id, Name, Alias, Description, Status
     * @return missing_person id update records accordingly
     */
    public function update_records(UpdateDiscountRequest $request, $update_id = null)
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
        $discount_obj = new missing_person();
        $discount_result = $discount_obj->update_records($update_data, $update_id);

        if (isset($discount_result) && $discount_result) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'Discount Updated successfully...!';
            $request->session()->put('success', $resp['message']);
            return redirect()->back()->with('success', $resp['message']);
        } else {
            $resp['message'] = 'Discount not Updated, Please try again...!';
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
        $start_date = null;
        $end_date = null;
        if ($request->has('discount_validity')) {
            $explodeDates = explode(" - ", $request->input('discount_validity'));
            $start_date = date("Y-m-d", strtotime(str_replace("/", "-", $explodeDates[0])));
            $end_date = date("Y-m-d", strtotime(str_replace("/", "-", $explodeDates[1])));
        }
        $preArr['discount_name'] = $request->input('discount_name');
        $preArr['discount_description'] = $request->input('discount_description');
        $preArr['discount_type'] = $request->input('discount_type_select');
        $preArr['amount'] = ($request->has('discount_amount')) ? $request->input('discount_amount') : 0;
        $preArr['is_discount_validity'] = ($request->has('discount_validity_chkbx')) ? $request->input('discount_validity_chkbx') : 0;
        $preArr['start_date'] = $start_date;
        $preArr['end_date'] = $end_date;
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
        $discount_obj = new missing_person();
        $discount_result = $discount_obj->delete_bulk_records($request->input('ids'));
        if (isset($discount_result) && $discount_result) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'Discounts Deleted successfully...!';
            $request->session()->put('success', $resp['message']);
        } else {
            $resp['message'] = 'Discounts are not Deleted, Please try again...!';
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
        $discount_obj = new missing_person();
        $discount_result = $discount_obj->deleteRecords($delete_id);
        if (isset($discount_result) && $discount_result) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'Discount is Deleted successfully...!';
        } else {
            $resp['message'] = 'Discount is not Deleted, Please try again...!';
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
        $discount_obj = new missing_person();
        $discount_result = $discount_obj->update_records(['status' => ($request->input('status') == 1) ? 0 : 1], $request->input('id'));
        if (isset($discount_result) && $discount_result) {
            $resp['status'] = true;
            $resp['data'] = array();
            $dynamic_message = ($request->input('status') == 1) ? 'In-Activated' : 'Activated';
            $resp['message'] = "Discount $dynamic_message successfully...!";
        } else {
            $resp['message'] = 'Discount is not Active/In-Active, Please try again...!';
        }
        die(json_encode($resp));
    }
}
