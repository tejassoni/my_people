<?php

namespace App\Http\Controllers\Customer;

use Exception;
use DataTables;
use App\Models\ear_master;
use App\Models\eye_master;
use App\Models\jaw_master;
use App\Models\lip_master;
use App\Models\city_master;
use App\Models\hair_master;
use App\Models\nose_master;
use App\Models\skin_master;
use App\Models\state_master;
use Illuminate\Http\Request;
use App\Models\country_master;
use App\Models\eyebrow_master;

use App\Models\missing_person;
use App\Models\currency_master;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteBulkRequest;
use App\Http\Requests\StatusUpdateRequest;
use App\Http\Requests\CreateDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;

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
        $country_list = country_master::all();
        $hair_list = hair_master::all();
        $eye_list = eye_master::all();
        $eyebrow_list = eyebrow_master::all();
        $lip_list = lip_master::all();
        $jaw_list = jaw_master::all();
        $skin_list = skin_master::all();
        $ear_list = ear_master::all();
        $nose_list = nose_master::all();
        $currency_list = currency_master::all();
        return view('customer.missing_persons.add_view', compact('country_list', 'hair_list', 'eye_list', 'eyebrow_list', 'lip_list', 'jaw_list', 'skin_list', 'ear_list', 'nose_list', 'currency_list'));
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
     * Get State List by Country ID Data Array
     * @author Tejas
     * @param  Request Inputs, (Optional) Addtional Array Datas
     * @return Array
     */
    public function get_stateby_id($country_id = "")
    {
        $resp = config('response_format.RES_RESULT');
        try {
            if (!isset($country_id) || empty($country_id))
                throw new Exception('State Id not found..!', 1);

            $state_obj = new state_master();
            $state_result = $state_obj->get_recordby_Id($country_id);
            if (empty($state_result))
                throw new Exception('State List not found..!', 422);

            $resp['status'] = true;
            $resp['message'] = "State List get successfully..!";
            $resp['data'] = $state_result;
            return response()->json($resp, 200);
        } catch (Exception $ex) {
            $resp['message'] = $ex->getMessage();
            return response()->json($resp, 422);
        }
    }

    /**
     * Get City List by State ID Data Array
     * @author Tejas
     * @param  Request Inputs, (Optional) Addtional Array Datas
     * @return Array
     */
    public function get_cityby_id($city_id = "")
    {
        $resp = config('response_format.RES_RESULT');
        try {
            if (!isset($city_id) || empty($city_id))
                throw new Exception('City Id not found..!', 1);

            $city_obj = new city_master();
            $city_result = $city_obj->get_recordby_Id($city_id);
            if (empty($city_result))
                throw new Exception('City List not found..!', 422);

            $resp['status'] = true;
            $resp['message'] = "City List get successfully..!";
            $resp['data'] = $city_result;
            return response()->json($resp, 200);
        } catch (Exception $ex) {
            $resp['message'] = $ex->getMessage();
            return response()->json($resp, 422);
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
