<?php

namespace App\Http\Controllers\Customer;

use Image;
use Exception;
use DataTables;
use App\Models\city_master;
use App\Models\find_person;
use App\Models\state_master;
use Illuminate\Http\Request;
use App\Models\country_master;
use App\Models\missing_person;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateFindPersonRequest;

class IdentifiedPersonController extends Controller
{

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
            $list = $missing_person_obj->list_belongsToIdentifiedSearch($PostData);
            // $list = $missing_person_obj->list_belongsTo();

            return DataTables::of($list)
                ->addIndexColumn()
                ->addColumn('missing_status', function ($list) {
                    return '<span class="text-success"><i class="fa fa-user-check" aria-hidden="true"></i> Found </span>';
                })
                ->addColumn('action', function ($list) {
                    $button = '';
                    $view_button = '<a href="#view-' . $list['missing_id'] . '" class="btn btn-xs btn-info btn_view" view_id="' . $list['missing_id'] . '" title="View" data-toggle="modal" data-target="#personViewModal"><i class="far fa-eye"></i> View </a> &nbsp;';
                    $download_button = '<a href="' . url('/customer/get_pdf_person/' . $list['missing_id']) . '" download_id="' . $list['missing_id'] . '" class="btn btn-xs btn-success btn_download" title="Download"><i class="fa fa-download"></i> Download</a>';
                    $button .= $view_button;
                    $button .= $download_button;
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
        return view('customer.identified_persons.list_view', compact('country_list'));
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
            if (isset($missing_person_result[0]) && !empty($missing_person_result[0]['missing_person_img']) && file_exists(\public_path('uploads/my_missing_persons/' . $missing_person_result[0]['missing_person_img']))) {
                $mime_type = $this->_base64_mime_type($missing_person_result[0]['missing_person_img']);
                $missing_person_result[0]['missing_person_img'] = $mime_type . base64_encode(file_get_contents(\public_path('uploads/my_missing_persons/' . $missing_person_result[0]['missing_person_img'])));
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
            if (isset($missing_person_result[0]) && !empty($missing_person_result[0]['missing_person_img']) && file_exists(\public_path('uploads/my_missing_persons/' . $missing_person_result[0]['missing_person_img']))) {
                $mime_type = $this->_base64_mime_type($missing_person_result[0]['missing_person_img']);
                $missing_person_result[0]['missing_person_img'] = $mime_type . base64_encode(file_get_contents(\public_path('uploads/my_missing_persons/' . $missing_person_result[0]['missing_person_img'])));
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
