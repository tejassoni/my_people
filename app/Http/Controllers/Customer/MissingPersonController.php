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
use App\Models\find_person;
use App\Models\hair_master;
use App\Models\nose_master;
use App\Models\skin_master;
use App\Models\state_master;
use Illuminate\Http\Request;
use App\Models\country_master;
use App\Models\eyebrow_master;
use App\Models\missing_person;
use App\Models\currency_master;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DeleteBulkRequest;
use App\Http\Requests\StatusUpdateRequest;
use App\Http\Requests\UpdateDiscountRequest;
use App\Http\Requests\CreateFindPersonRequest;
use App\Http\Requests\UpdateFindPersonResponse;
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
        $preArr['height'] = $request->input('height');
        $preArr['weight'] = $request->input('weight');
        $preArr['address'] = $request->input('address');
        $preArr['country_id'] = $request->input('country_select');
        $preArr['state_id'] = $request->input('state_select');
        $preArr['city_id'] = ($request->input('city_select') == "Select City") ? null : $request->input('city_select');
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

            // Custom Filter Datatables
            $PostData = [];
            if ($request->has('enable_missed_data') && $request->get('enable_missed_data')) {
                $explodeDates = explode(" - ", $request->get('missed_date'));
                $PostData['missed_date']['start'] = date("Y-m-d", strtotime(str_replace("/", "-", $explodeDates[0])));
                $PostData['missed_date']['end'] = date("Y-m-d", strtotime(str_replace("/", "-", $explodeDates[1])));
            } else {
                $PostData['missed_date'] = null;
            }

            if ($request->has('name'))
                $PostData['full_name'] = $request->get('name');

            if ($request->has('gender'))
                $PostData['gender'] = $request->get('gender');

            if ($request->has('age'))
                $PostData['age'] = $request->get('age');

            if ($request->has('country_id'))
                $PostData['country_id'] = $request->get('country_id');

            if ($request->has('state_id'))
                $PostData['state_id'] = $request->get('state_id');

            if ($request->has('city_id'))
                $PostData['city_id'] = $request->get('city_id');

            $missing_person_obj = new missing_person;
            $list = $missing_person_obj->list_belongsToSearch($PostData);
            // $list = $missing_person_obj->list_belongsTo();

            return DataTables::of($list)
                ->addIndexColumn()
                ->addColumn('missing_status', function ($list) {
                    $missing_status = '<span class="text-danger"><i class="fa fa-ban" aria-hidden="true"></i> Missing </span>';
                    $find_person = find_person::where('status', 1)->where('missing_id', $list['missing_id'])->first();
                    if (isset($find_person) && !empty($find_person) && $find_person['approval_status'] == "pending") {
                        $missing_status = '<span class="text-warning"><i class="fa fa-clock" aria-hidden="true"></i> Pending Approval</span>';
                    }
                    return $missing_status;
                })
                ->addColumn('action', function ($list) {
                    $find_person = find_person::where('status', 1)->where('missing_id', $list['missing_id'])->first();
                    $button = '';
                    $view_button = '<a href="#view-' . $list['missing_id'] . '" class="btn btn-xs btn-info btn_view" view_id="' . $list['missing_id'] . '" title="View" data-toggle="modal" data-target="#personViewModal"><i class="far fa-eye"></i> View </a> &nbsp;';
                    $download_button = '<a href="' . url('/customer/get_pdf_person/' . $list['missing_id']) . '" download_id="' . $list['missing_id'] . '" class="btn btn-xs btn-success btn_download" title="Download"><i class="fa fa-download"></i> Download</a>';
                    $button .= $view_button;
                    $button .= $download_button;
                    if (empty($find_person) || $find_person->approval_status != "pending") {
                        $request_button = '<a href="#request-' . $list['missing_id'] . '" request_id="' . $list['missing_id'] . '" class="btn btn-xs btn-warning btn_request" title="Request" data-toggle="modal" data-target="#personRequestModal"><i class="fa fa-reply"></i> Request Parents</a>';
                        $button .= $request_button;
                    }
                    return $button;
                })
                ->addColumn('missing_person_img', function ($list) {
                    if (!empty($list['missing_person_img']))
                        return '<img src="' . url('uploads/my_missing_persons/thumbnail/thumb_' . $list['missing_person_img']) . '" title="Image" height="50" width="50"/>';
                })
                ->rawColumns(['action', 'missing_person_img', 'missing_status'])
                ->make(true);
        }
        $country_list = country_master::all();
        return view('customer.missing_persons.list_view', compact('country_list'));
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
     * Get City List by State ID Data Array
     * @author Tejas
     * @param  Request Inputs, (Optional) Addtional Array Datas
     * @return Array
     */
    public function get_personby_id($person_id = "")
    {
        $resp = config('response_format.RES_RESULT');
        try {
            if (!isset($person_id) || empty($person_id))
                throw new Exception('Person Id not found..!', 1);

            $missing_person_obj = new missing_person();
            $missing_person_result = $missing_person_obj->list_belongsToBy_id($person_id);
            if (empty($missing_person_result))
                throw new Exception('Missing Person List not found..!', 422);

            // Missing Person Image Base 64 encoded
            if (isset($missing_person_result[0]) && !empty($missing_person_result[0]['missing_person_img']) && file_exists(\public_path('uploads/missing_persons/' . $missing_person_result[0]['missing_person_img']))) {
                $mime_type = $this->_base64_mime_type($missing_person_result[0]['missing_person_img']);
                $missing_person_result[0]['missing_person_img'] = $mime_type . base64_encode(file_get_contents(\public_path('uploads/missing_persons/' . $missing_person_result[0]['missing_person_img'])));
            } else { // Default
                $missing_person_result[0]['missing_person_img'] = $this->_default_image('no-preview.jpg');
            }

            // Face / Jaw Image Base 64 encoded
            if (isset($missing_person_result[0]['jaw_img']) && !empty($missing_person_result[0]['ear_img']) && file_exists(\public_path('uploads/jaws/' . $missing_person_result[0]['jaw_img']))) {
                $mime_type = $this->_base64_mime_type($missing_person_result[0]['ear_img']);
                $missing_person_result[0]['jaw_img'] = $mime_type . base64_encode(file_get_contents(\public_path('uploads/jaws/' . $missing_person_result[0]['jaw_img'])));
            } else { // Default
                $missing_person_result[0]['jaw_img'] = $this->_default_image('no-preview.jpg');
            }

            // Skin Image Base 64 encoded
            if (isset($missing_person_result[0]['skin_img']) && !empty($missing_person_result[0]['skin_img']) && file_exists(\public_path('uploads/skins/' . $missing_person_result[0]['skin_img']))) {
                $mime_type = $this->_base64_mime_type($missing_person_result[0]['skin_img']);
                $missing_person_result[0]['skin_img'] = $mime_type . base64_encode(file_get_contents(\public_path('uploads/skins/' . $missing_person_result[0]['skin_img'])));
            } else { // Default
                $missing_person_result[0]['skin_img'] = $this->_default_image('no-preview.jpg');
            }

            // Hair Image Base 64 encoded
            if (isset($missing_person_result[0]['hair_img']) && !empty($missing_person_result[0]['hair_img']) && file_exists(\public_path('uploads/hairs/' . $missing_person_result[0]['hair_img']))) {
                $mime_type = $this->_base64_mime_type($missing_person_result[0]['hair_img']);
                $missing_person_result[0]['hair_img'] = $mime_type . base64_encode(file_get_contents(\public_path('uploads/hairs/' . $missing_person_result[0]['hair_img'])));
            } else { // Default
                $missing_person_result[0]['hair_img'] = $this->_default_image('no-preview.jpg');
            }

            // Nose Image Base 64 encoded
            if (isset($missing_person_result[0]['nose_img']) && !empty($missing_person_result[0]['nose_img']) && file_exists(\public_path('uploads/noses/' . $missing_person_result[0]['nose_img']))) {
                $mime_type = $this->_base64_mime_type($missing_person_result[0]['nose_img']);
                $missing_person_result[0]['nose_img'] = $mime_type . base64_encode(file_get_contents(\public_path('uploads/noses/' . $missing_person_result[0]['nose_img'])));
            } else { // Default
                $missing_person_result[0]['nose_img'] = $this->_default_image('no-preview.jpg');
            }

            // Eye Brow Image Base 64 encoded
            if (isset($missing_person_result[0]['eye_brow_img']) && !empty($missing_person_result[0]['eye_brow_img']) && file_exists(\public_path('uploads/eyebrows/' . $missing_person_result[0]['eye_brow_img']))) {
                $mime_type = $this->_base64_mime_type($missing_person_result[0]['eye_brow_img']);
                $missing_person_result[0]['eye_brow_img'] = $mime_type . base64_encode(file_get_contents(\public_path('uploads/eyebrows/' . $missing_person_result[0]['eye_brow_img'])));
            } else { // Default
                $missing_person_result[0]['eye_brow_img'] = $this->_default_image('no-preview.jpg');
            }

            // Eye Image Base 64 encoded
            if (isset($missing_person_result[0]['eye_img']) && !empty($missing_person_result[0]['eye_brow_img']) && file_exists(\public_path('uploads/eyes/' . $missing_person_result[0]['eye_img']))) {
                $mime_type = $this->_base64_mime_type($missing_person_result[0]['eye_img']);
                $missing_person_result[0]['eye_img'] = $mime_type . base64_encode(file_get_contents(\public_path('uploads/eyes/' . $missing_person_result[0]['eye_img'])));
            } else { // Default
                $missing_person_result[0]['eye_img'] = $this->_default_image('no-preview.jpg');
            }

            // Ear Image Base 64 encoded
            if (isset($missing_person_result[0]['ear_img']) && !empty($missing_person_result[0]['ear_img']) && file_exists(\public_path('uploads/ears/' . $missing_person_result[0]['ear_img']))) {
                $mime_type = $this->_base64_mime_type($missing_person_result[0]['ear_img']);
                $missing_person_result[0]['ear_img'] = $mime_type . base64_encode(file_get_contents(\public_path('uploads/ears/' . $missing_person_result[0]['ear_img'])));
            } else { // Default
                $missing_person_result[0]['ear_img'] = $this->_default_image('no-preview.jpg');
            }

            // Lip Image Base 64 encoded
            if (isset($missing_person_result[0]['lip_img']) && !empty($missing_person_result[0]['lip_img']) && file_exists(\public_path('uploads/lips/' . $missing_person_result[0]['lip_img']))) {
                $mime_type = $this->_base64_mime_type($missing_person_result[0]['lip_img']);
                $missing_person_result[0]['lip_img'] = $mime_type . base64_encode(file_get_contents(\public_path('uploads/lips/' . $missing_person_result[0]['lip_img'])));
            } else { // Default
                $missing_person_result[0]['lip_img'] = $this->_default_image('no-preview.jpg');
            }

            $resp['status'] = true;
            $resp['message'] = "Missing Person List get successfully..!";
            $resp['data'] = $missing_person_result[0];
            return response()->json($resp, 200);
        } catch (Exception $ex) {
            $resp['message'] = $ex->getMessage();
            return response()->json($resp, 422);
        }
    }

    /**
     * Handle routs Controller update functionality
     * @author Tejas
     * @param  filename with extention OR ONLY file extention and secound param true
     * @return mime type
     */
    private function _default_image($filename = "")
    {
        $mime_type = $this->_base64_mime_type($filename);
        return $mime_type . base64_encode(file_get_contents(\public_path('assets/' . $filename)));
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
     * Handle routs Controller Find Person functionality
     * @author Tejas
     * @param  Person Image, Message
     * @return Boolean
     */
    public function find_person_request(CreateFindPersonRequest $request)
    {   // default response formate initialize
        $resp = config('response_format.RES_RESULT');

        // Set Insert data array for pass into insert query
        $updatematches_data = $this->_prepareFindUpdateMatchData($request, [1]);
        $insert_data = $this->_prepareInsertFindPersonData($request);
        // File Upload Starts Folder Path : // root\public\uploads        
        if ($request->hasFile('filename')) {
            $filehandle = $this->_fileUploads($request);
            $insert_data['find_person_img'] = $filehandle['data']['filename'];
        }

        // File Upload Ends
        $find_person_obj = new find_person();
        $find_person_result = $find_person_obj->update_Or_Create($updatematches_data, $insert_data);

        if ($find_person_result->exists) {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'Find Person inserted successfully...!';
            return response()->json($resp);
        } else {
            $resp['message'] = 'Find Person not inserted, Please try again...!';
            return response()->json($resp);
        }
    }

    /**
     * Prepare Update Or Create Data Array
     * @author Tejas
     * @param  Request Inputs, (Optional) Addtional Array Datas
     * @return Array
     */
    private function _prepareFindUpdateMatchData($request = "", $additional = array())
    {
        $preArr['findby_user_id'] = Auth::user()->id;
        $preArr['missing_id'] = $request->input('missing_id');
        $preArr['status'] = $additional[0];
        return $preArr;
    }

    /**
     * Prepare Insert Find Person Data Array
     * @author Tejas
     * @param  Request Inputs, (Optional) Addtional Array Datas
     * @return Array
     */
    private function _prepareInsertFindPersonData($request = "", $additional = array())
    {
        $preArr['missing_id'] = $request->input('missing_id');
        $preArr['description'] = $request->input('message');
        $preArr['approval_status'] = 'pending';
        $preArr['findby_user_id'] = Auth::user()->id;
        $preArr['status'] = 1;
        return $preArr;
    }

    /**
     * Handle routs Controller Download PDF functionality
     * @author Tejas
     * @param  Person Id
     * @return Boolean
     */
    public function download_pdf($download_id = "")
    {   // default response formate initialize
        $resp = config('response_format.RES_RESULT');
        try {

            if (!isset($download_id) || empty($download_id))
                throw new Exception('Person Id not found..!', 1);

            $missing_person_obj = new missing_person();
            $missing_person_result = $missing_person_obj->list_belongsToBy_id($download_id);

            // Missing Person Image Base 64 encoded
            if (isset($missing_person_result[0]) && !empty($missing_person_result[0]['missing_person_img']) && file_exists(\public_path('uploads/missing_persons/' . $missing_person_result[0]['missing_person_img']))) {
                $mime_type = $this->_base64_mime_type($missing_person_result[0]['missing_person_img']);
                $missing_person_result[0]['missing_person_img'] = $mime_type . base64_encode(file_get_contents(\public_path('uploads/missing_persons/' . $missing_person_result[0]['missing_person_img'])));
            } else { // Default
                $missing_person_result[0]['missing_person_img'] = $this->_default_image('no-preview.jpg');
            }

            // Face / Jaw Image Base 64 encoded
            if (isset($missing_person_result[0]['jaw_img']) && !empty($missing_person_result[0]['ear_img']) && file_exists(\public_path('uploads/jaws/' . $missing_person_result[0]['jaw_img']))) {
                $mime_type = $this->_base64_mime_type($missing_person_result[0]['ear_img']);
                $missing_person_result[0]['jaw_img'] = $mime_type . base64_encode(file_get_contents(\public_path('uploads/jaws/' . $missing_person_result[0]['jaw_img'])));
            } else { // Default
                $missing_person_result[0]['jaw_img'] = $this->_default_image('no-preview.jpg');
            }

            // Skin Image Base 64 encoded
            if (isset($missing_person_result[0]['skin_img']) && !empty($missing_person_result[0]['skin_img']) && file_exists(\public_path('uploads/skins/' . $missing_person_result[0]['skin_img']))) {
                $mime_type = $this->_base64_mime_type($missing_person_result[0]['skin_img']);
                $missing_person_result[0]['skin_img'] = $mime_type . base64_encode(file_get_contents(\public_path('uploads/skins/' . $missing_person_result[0]['skin_img'])));
            } else { // Default
                $missing_person_result[0]['skin_img'] = $this->_default_image('no-preview.jpg');
            }

            // Hair Image Base 64 encoded
            if (isset($missing_person_result[0]['hair_img']) && !empty($missing_person_result[0]['hair_img']) && file_exists(\public_path('uploads/hairs/' . $missing_person_result[0]['hair_img']))) {
                $mime_type = $this->_base64_mime_type($missing_person_result[0]['hair_img']);
                $missing_person_result[0]['hair_img'] = $mime_type . base64_encode(file_get_contents(\public_path('uploads/hairs/' . $missing_person_result[0]['hair_img'])));
            } else { // Default
                $missing_person_result[0]['hair_img'] = $this->_default_image('no-preview.jpg');
            }

            // Nose Image Base 64 encoded
            if (isset($missing_person_result[0]['nose_img']) && !empty($missing_person_result[0]['nose_img']) && file_exists(\public_path('uploads/noses/' . $missing_person_result[0]['nose_img']))) {
                $mime_type = $this->_base64_mime_type($missing_person_result[0]['nose_img']);
                $missing_person_result[0]['nose_img'] = $mime_type . base64_encode(file_get_contents(\public_path('uploads/noses/' . $missing_person_result[0]['nose_img'])));
            } else { // Default
                $missing_person_result[0]['nose_img'] = $this->_default_image('no-preview.jpg');
            }

            // Eye Brow Image Base 64 encoded
            if (isset($missing_person_result[0]['eye_brow_img']) && !empty($missing_person_result[0]['eye_brow_img']) && file_exists(\public_path('uploads/eyebrows/' . $missing_person_result[0]['eye_brow_img']))) {
                $mime_type = $this->_base64_mime_type($missing_person_result[0]['eye_brow_img']);
                $missing_person_result[0]['eye_brow_img'] = $mime_type . base64_encode(file_get_contents(\public_path('uploads/eyebrows/' . $missing_person_result[0]['eye_brow_img'])));
            } else { // Default
                $missing_person_result[0]['eye_brow_img'] = $this->_default_image('no-preview.jpg');
            }

            // Eye Image Base 64 encoded
            if (isset($missing_person_result[0]['eye_img']) && !empty($missing_person_result[0]['eye_brow_img']) && file_exists(\public_path('uploads/eyes/' . $missing_person_result[0]['eye_img']))) {
                $mime_type = $this->_base64_mime_type($missing_person_result[0]['eye_img']);
                $missing_person_result[0]['eye_img'] = $mime_type . base64_encode(file_get_contents(\public_path('uploads/eyes/' . $missing_person_result[0]['eye_img'])));
            } else { // Default
                $missing_person_result[0]['eye_img'] = $this->_default_image('no-preview.jpg');
            }

            // Ear Image Base 64 encoded
            if (isset($missing_person_result[0]['ear_img']) && !empty($missing_person_result[0]['ear_img']) && file_exists(\public_path('uploads/ears/' . $missing_person_result[0]['ear_img']))) {
                $mime_type = $this->_base64_mime_type($missing_person_result[0]['ear_img']);
                $missing_person_result[0]['ear_img'] = $mime_type . base64_encode(file_get_contents(\public_path('uploads/ears/' . $missing_person_result[0]['ear_img'])));
            } else { // Default
                $missing_person_result[0]['ear_img'] = $this->_default_image('no-preview.jpg');
            }

            // Lip Image Base 64 encoded
            if (isset($missing_person_result[0]['lip_img']) && !empty($missing_person_result[0]['lip_img']) && file_exists(\public_path('uploads/lips/' . $missing_person_result[0]['lip_img']))) {
                $mime_type = $this->_base64_mime_type($missing_person_result[0]['lip_img']);
                $missing_person_result[0]['lip_img'] = $mime_type . base64_encode(file_get_contents(\public_path('uploads/lips/' . $missing_person_result[0]['lip_img'])));
            } else { // Default
                $missing_person_result[0]['lip_img'] = $this->_default_image('no-preview.jpg');
            }

            if (empty($missing_person_result))
                throw new Exception('Missing Person Details not found..!', 422);

            $pdf = PDF::loadView('templates.pdf.find_person_template', ['pdf_data' => $missing_person_result[0]]);
            return $pdf->download('person_details.pdf');
        } catch (Exception $ex) {
            $resp['message'] = $ex->getMessage();
            return redirect()->back()->withInput()->with('error', $resp['message']);
        }
    }
}
