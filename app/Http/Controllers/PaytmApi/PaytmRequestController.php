<?php

namespace App\Http\Controllers\PaytmApi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use App\Helpers\encdec_paytm;

class PaytmRequestController extends Controller
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    { // constructor code starts here        
    }

    /**
     * Handle routs Controller Load Edit functionality
     * @author Tejas
     * @param  Role ID
     * @return plan_master id wise records into edit view
     */
    public function get_payment_list()
    {
        return view('admin.plans.edit_view', compact(['plan_result', 'discount_result']));
    }

    /**
     * Handle routs Controller Load Edit functionality
     * @author Tejas
     * @param  Role ID
     * @return plan_master id wise records into edit view
     */
    public function txtTest()
    {
        return view('customer.payment.TxnTest');
    }

    /*
     @author    :: Tejas
     @task_id   :: 
     @task_desc :: 
     @params    :: 
     @return    :: 
    */
    public function pgRedirect(Request $request)
    {
        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
        header("Expires: 0");
        $checkSum = "";
        $paramList = array();
        // Create an array having all required parameters for creating checksum.
        $paramList["MID"] = PAYTM_MERCHANT_MID;
        $paramList["ORDER_ID"] = $request->input("ORDER_ID");
        $paramList["CUST_ID"] = $request->input("CUST_ID");
        $paramList["INDUSTRY_TYPE_ID"] = $request->input("INDUSTRY_TYPE_ID");
        $paramList["CHANNEL_ID"] = $request->input("CHANNEL_ID");
        $paramList["TXN_AMOUNT"] = $request->input("TXN_AMOUNT");
        $paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;

        $paramList["CALLBACK_URL"] = PAYTM_RESPONSE_URL;
        $paramList["MSISDN"] = 9662768548; //Mobile number of customer
        $paramList["EMAIL"] = "tejas.soni@gmail.com"; //Email ID of customer
        $paramList["VERIFIED_BY"] = "EMAIL"; //
        $paramList["IS_USER_VERIFIED"] = "YES"; //

        //Here checksum string will return by getChecksumFromArray() function.
        $checkSum = getChecksumFromArray($paramList, PAYTM_MERCHANT_KEY);
        return view('customer.payment.pgRedirect', compact('checkSum', 'paramList'));
    }

    /*
     @author    :: Tejas
     @task_id   :: 
     @task_desc :: 
     @params    :: 
     @return    :: 
    */
    public function pgResponse()
    {
        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
        header("Expires: 0");

        $paytmChecksum = "";
        $paramList = array();
        $isValidChecksum = "FALSE";

        $paramList = $_POST;
        $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

        //Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
        $isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.


        if ($isValidChecksum == "TRUE") {
            echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";
            if ($_POST["STATUS"] == "TXN_SUCCESS") {
                echo "<b>Transaction status is success</b>" . "<br/>";
                //Process your transaction here as success transaction.
                //Verify amount & order id received from Payment gateway with your application's order id and amount.
            } else {
                echo "<b>Transaction status is failure</b>" . "<br/>";
            }

            if (isset($_POST) && count($_POST) > 0) {
                foreach ($_POST as $paramName => $paramValue) {
                    echo "<br/>" . $paramName . " = " . $paramValue;
                }
            }
        } else {
            echo "<b>Checksum mismatched.</b>";
            //Process transaction as suspicious.
        }
        exit;
    }
}
