<?php

namespace App\Http\Controllers\PaytmApi;

use Illuminate\Http\Request;
use App\Helpers\encdec_paytm;
use Illuminate\Http\Response;
use App\Models\orders;
use App\Models\subscription_master;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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

    /*
     @author    :: Tejas
     @task_id   :: 
     @task_desc :: 
     @params    :: 
     @return    :: 
    */
    public function subscriptionPayment($subscription_id)
    {
        if (isset($subscription_id) && !empty($subscription_id)) {
            $subscription_list = (new subscription_master)->listById_belongsTo($subscription_id);

            header("Pragma: no-cache");
            header("Cache-Control: no-cache");
            header("Expires: 0");
            $checkSum = "";
            $paramList = array();
            // Create an array having all required parameters for creating checksum.
            $paramList["MID"] = PAYTM_MERCHANT_MID;
            $paramList["ORDER_ID"] = "ORDS" . rand(10000, 99999999);
            $paramList["CUST_ID"] = "CUST_" . Auth::user()->id;
            $paramList["INDUSTRY_TYPE_ID"] = "Retail";
            $paramList["CHANNEL_ID"] = "WEB";
            $paramList["TXN_AMOUNT"] = $subscription_list['plan_amount'];
            $paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;

            $paramList["CALLBACK_URL"] = PAYTM_RESPONSE_URL;
            $paramList["MSISDN"] = Auth::user()->mobile; //Mobile number of customer
            $paramList["EMAIL"] = Auth::user()->email; //Email ID of customer
            $paramList["VERIFIED_BY"] = "EMAIL"; //
            $paramList["IS_USER_VERIFIED"] = "YES"; //            
            //Here checksum string will return by getChecksumFromArray() function.
            $checkSum = getChecksumFromArray($paramList, PAYTM_MERCHANT_KEY);

            $paramList["SUBSCRIPTION_ID"] = $subscription_id;
            $paramList["QTY"] = 1;
            $paramList["PAYMENT_STATUS"] = 'pending';
            $paramList["PAYMENT_RECEIVED"] = 'no';
            $paramList["STATUS"] = 1;

            // Insert Payment Data to Order Table 
            $insertOrder = $this->_insertPaymentDetails($paramList);
            // dd($insertOrder);
            return view('customer.payment.pgRedirect', compact('checkSum', 'paramList'));
        }
    }

    /*
     @author    :: Tejas
     @task_id   :: 
     @task_desc :: 
     @params    :: 
     @return    :: 
    */
    private function _insertPaymentDetails($paymentData = array(), $additionalData = array())
    {
        $insertData['order_id'] = $paymentData['ORDER_ID'];
        $insertData['user_id'] = str_replace('CUST_', '', $paymentData['CUST_ID']);
        $insertData['subscription_id'] = $paymentData['SUBSCRIPTION_ID'];
        $insertData['qty'] = $paymentData['QTY'];
        $insertData['total_amount'] = $paymentData['TXN_AMOUNT'];
        $insertData['payment_status'] = $paymentData['PAYMENT_STATUS'];
        $insertData['payment_received'] = $paymentData['PAYMENT_RECEIVED'];
        $insertData['status'] = $paymentData['STATUS'];
        return (new orders)->insert_data($insertData);
    }
}
