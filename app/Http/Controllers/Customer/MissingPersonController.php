<?php

namespace App\Http\Controllers\Customer;

use Image;
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
use App\Models\find_person;
use Illuminate\Http\Request;
use App\Models\country_master;
use App\Models\eyebrow_master;
use App\Models\missing_person;
use App\Models\currency_master;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DeleteBulkRequest;
use App\Http\Requests\StatusUpdateRequest;
use App\Http\Requests\UpdateDiscountRequest;
use App\Http\Requests\CreateMissingPersonRequest;

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
        $eye_list = eye_master::where('status', 1)->get();
        $eyebrow_list = eyebrow_master::where('status', 1)->get();
        $lip_list = lip_master::where('status', 1)->get();
        $jaw_list = jaw_master::where('status', 1)->get();
        $skin_list = skin_master::where('status', 1)->get();
        $ear_list = ear_master::where('status', 1)->get();
        $nose_list = nose_master::where('status', 1)->get();
        $currency_list = currency_master::where('status', 1)->get();
        return view('customer.missing_persons.add_view', compact('country_list', 'hair_list', 'eye_list', 'eyebrow_list', 'lip_list', 'jaw_list', 'skin_list', 'ear_list', 'nose_list', 'currency_list'));
    }

    /**
     * Handle routs Controller add functionality
     * @author Tejas
     * @param  Name, Alias, Description, Status
     * @return success or fail flash message in view
     */
    public function insert_records(CreateMissingPersonRequest $request)
    {
        // default response formate initialize
        $resp = config('response_format.RES_RESULT');

        // Set Insert data array for pass into insert query
        $insert_data = $this->_prepareInsertData($request);

        // File Upload Starts Folder Path : // root\public\uploads        
        if ($request->hasFile('filename')) {
            $filehandle = $this->_fileUploads($request);
            $insert_data['missing_person_img'] = $filehandle['data']['filename'];
        }
        // File Upload Ends

        $missing_person_obj = new missing_person();
        $missing_person_result = $missing_person_obj->insert_data($insert_data);

        if ($missing_person_result->exists) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'Missing Person inserted successfully...!';
            $request->session()->put('success', $resp['message']);
            return redirect()->back()->with('success', $resp['message']);
        } else {
            $resp['message'] = 'Missing Person not inserted, Please try again...!';
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
        $preArr['birth_date'] = date("Y-m-d", strtotime(str_replace("/", "-", $request->input('birth_date'))));
        $preArr['gender'] = $request->input('gender');
        $preArr['age'] = $request->input('age');
        $preArr['address'] = $request->input('address');
        $preArr['country_id'] = $request->input('country_select');
        $preArr['state_id'] = $request->input('state_select');
        $preArr['city_id'] = $request->input('city_select');
        $preArr['pincode'] = $request->input('pincode');
        $preArr['user_id'] = Auth::user()->id;
        $preArr['hair_id'] = $request->input('hair_select');
        $preArr['eye_id'] = $request->input('eye_select');
        $preArr['eye_brow_id'] = $request->input('eyebrow_select');
        $preArr['lip_id'] = $request->input('lip_select');
        $preArr['jaw_id'] = $request->input('face_jaw_select');
        $preArr['skin_id'] = $request->input('skin_select');
        $preArr['ear_id'] = $request->input('ear_select');
        $preArr['nose_id'] = $request->input('nose_select');
        $preArr['remark'] = $request->input('remark');
        $preArr['cloth_description'] = $request->input('cloth_description');
        $preArr['currency_id'] = $request->input('currency_select');
        $preArr['missed_date'] = date("Y-m-d", strtotime(str_replace("/", "-", $request->input('missing_date'))));;
        $preArr['amount'] = ($request->has('reward_amount')) ? $request->input('reward_amount') : 0;
        $preArr['status'] = 1;
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
            $request->file('filename')->move(public_path('uploads/missing_persons'), $fileFullName);
            // Thumbnail Image
            Image::make(public_path("uploads/missing_persons/$fileFullName"))->resize(300, 200)->save(public_path("uploads/missing_persons/thumbnail/thumb_$fileFullName"));
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
            $resp['message'] = 'Missing Person not inserted, Please try again...!';
            $request->session()->put('error', $resp['message']);
            return redirect()->back()->withInput()->with('error', $resp['message']);
        }
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
            $missing_person_obj = new missing_person;
            // $list = $missing_person_obj->list_all();
            $list = $missing_person_obj->list_belongsTo();
            return DataTables::of($list)
                ->addIndexColumn()
                ->addColumn('missing_status', function ($list) {
                    $missing_status = '<span class="text-danger"><i class="fa fa-ban" aria-hidden="true"></i> Missing </span>';
                    $find_person = find_person::find($list['missing_id']);
                    if (isset($find_person) && !empty($find_person) && $find_person['approval_status'] == "pending") {
                        $missing_status = '<span class="text-warning"><i class="fa fa-clock" aria-hidden="true"></i> Pending Approval</span>';
                    }
                    return $missing_status;
                })
                ->addColumn('action', function ($list) {
                    $button = '';
                    $edit_button = '<a href="' . url("/customer/missing_person_edit/{$list['missing_id']}") . '" class="btn btn-xs btn-info btn_edit" title="Edit"><i class="far fa-eye"></i> View </a> &nbsp;';
                    $download_button = '<a href="#delete-' . $list['missing_id'] . '" delete_id="' . $list['missing_id'] . '" class="btn btn-xs btn-success btn_delete" title="Delete"><i class="fa fa-download"></i> Download</a>';
                    $request_button = '<a href="#delete-' . $list['missing_id'] . '" delete_id="' . $list['missing_id'] . '" class="btn btn-xs btn-warning btn_delete" title="Delete"><i class="fa fa-reply"></i> Request</a>';
                    $button .= $edit_button;
                    $button .= $download_button;
                    $button .= $request_button;
                    return $button;
                })
                ->addColumn('missing_person_img', function ($list) {
                    if (!empty($list['missing_person_img']))
                        return '<img src="' . url('uploads/missing_persons/thumbnail/thumb_' . $list['missing_person_img']) . '" title="Image" height="50" width="50"/>';
                })
                ->rawColumns(['action', 'missing_person_img', 'missing_status'])
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
