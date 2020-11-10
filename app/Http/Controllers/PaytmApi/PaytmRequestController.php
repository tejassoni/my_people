<?php

namespace App\Http\Controllers\PaytmApi;

use Exception;
use App\Models\orders;
use Illuminate\Http\Request;
use App\Helpers\encdec_paytm;
use Illuminate\Http\Response;
use App\Models\subscription_master;
use App\Models\donation;
use App\Models\donation_order;
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
        // config fetch message
        $resp = config('response_format.RES_RESULT');
        try {
            if (!isset($subscription_id) || empty($subscription_id))
                throw new Exception('Error Processing Request', 1);

            $subscription_list = (new subscription_master)->listById_belongsTo($subscription_id);

            if (isset($subscription_list['sub_alias']) && !empty($subscription_list['sub_alias']) && $subscription_list['sub_alias'] == "trail_subscription") {
                // Set Order Insert Data
                $orderInsertData["ORDER_ID"] =  "ORDS" . rand(10000, 99999999);
                $orderInsertData["CUST_ID"] =  "CUST_" . Auth::user()->id;
                $orderInsertData["TXN_AMOUNT"] =  0;
                $orderInsertData["SUBSCRIPTION_ID"] = $subscription_id;
                $orderInsertData["QTY"] = 1;
                $orderInsertData['CURRENCY'] = 'INR';
                $orderInsertData["PAYMENT_STATUS"] = 'completed';
                $orderInsertData["PAYMENT_RECEIVED"] = 'yes';
                $orderInsertData["PAYMENT_DATE"] = date('Y-m-d H:m:i');
                $orderInsertData["STATUS"] = 1;

                $updatematches_data = $this->_updatePaymentTrailDetails([0]);
                $insertnew_data = $this->_insertPaymentTrailDetails($orderInsertData);
                // Insert Payment Data to Order Table 
                $payment_result = (new orders)->update_Or_Create($updatematches_data, $insertnew_data);

                $resp['status'] = true;
                $resp['data'] = array();
                $resp['message'] = 'Congrats, You have Subscribe successfully...!';
                Session::put('success', $resp['message']);
                return redirect('customer/mymissing_person_list')->with('success', $resp['message']);
            } else {

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

                // Set Order Insert Data
                $orderInsertData["ORDER_ID"] =  $paramList["ORDER_ID"];
                $orderInsertData["CUST_ID"] =  $paramList["CUST_ID"];
                $orderInsertData["TXN_AMOUNT"] =  $paramList["TXN_AMOUNT"];
                $orderInsertData["SUBSCRIPTION_ID"] = $subscription_id;
                $orderInsertData["QTY"] = 1;
                $orderInsertData["PAYMENT_STATUS"] = 'pending';
                $orderInsertData["PAYMENT_RECEIVED"] = 'no';
                $orderInsertData["STATUS"] = 0;
                // Insert Payment Data to Order Table 
                $updatematches_data = $this->_updatePaymentTrailDetails([0]);
                $insertnew_data = $this->_insertpreparePaymentDetails($orderInsertData);
                $payment_result = (new orders)->update_Or_Create($updatematches_data, $insertnew_data);
                // $insertOrder = $this->_insertPaymentDetails($orderInsertData);
                return view('customer.payment.pgRedirect', compact('checkSum', 'paramList'));
            }
        } catch (Exception $ex) {
            $resp['status'] = false;
            $resp['data'] = [];
            $resp['message'] = $ex->getMessage();
            $resp['ex_message'] = $ex->getMessage();
            $resp['ex_code'] = $ex->getCode();
            $resp['ex_file'] = $ex->getFile();
            $resp['ex_line'] = $ex->getLine();
            Session::put('error', $resp['message']);
            return redirect()->back()->with('error', $resp['message']);
        }
    }

    /*
     @author    :: Tejas
     @task_id   :: 
     @task_desc :: 
     @params    :: 
     @return    :: 
    */
    private function _insertpreparePaymentDetails($paymentData = array(), $additionalData = array())
    {
        $insertData['order_id'] = $paymentData['ORDER_ID'];
        $insertData['user_id'] = str_replace('CUST_', '', $paymentData['CUST_ID']);
        $insertData['subscription_id'] = $paymentData['SUBSCRIPTION_ID'];
        $insertData['qty'] = $paymentData['QTY'];
        $insertData['total_amount'] = $paymentData['TXN_AMOUNT'];
        $insertData['payment_status'] = $paymentData['PAYMENT_STATUS'];
        $insertData['payment_received'] = $paymentData['PAYMENT_RECEIVED'];
        $insertData['status'] = $paymentData['STATUS'];
        return $insertData;
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

    /*
     @author    :: Tejas
     @task_id   :: 
     @task_desc :: 
     @params    :: 
     @return    :: 
    */
    private function _insertPaymentTrailDetails($paymentData = array(), $additionalData = array())
    {
        $insertData['order_id'] = $paymentData['ORDER_ID'];
        $insertData['user_id'] = str_replace('CUST_', '', $paymentData['CUST_ID']);
        $insertData['subscription_id'] = $paymentData['SUBSCRIPTION_ID'];
        $insertData['qty'] = $paymentData['QTY'];
        $insertData['total_amount'] = $paymentData['TXN_AMOUNT'];
        $insertData['payment_status'] = $paymentData['PAYMENT_STATUS'];
        $insertData['payment_received'] = $paymentData['PAYMENT_RECEIVED'];
        $insertData['payment_currency'] = $paymentData['CURRENCY'];
        $insertData['payment_date'] = $paymentData["PAYMENT_DATE"];
        $insertData['status'] = $paymentData['STATUS'];
        return $insertData;
    }

    /*
     @author    :: Tejas
     @task_id   :: 
     @task_desc :: 
     @params    :: 
     @return    :: 
    */
    private function _updatePaymentTrailDetails($paymentData = array(), $additionalData = array())
    {
        $updateData['user_id'] = Auth()->user()->id;
        $updateData['status'] = $paymentData[0];
        return $updateData;
    }

    /*
     @author    :: Tejas
     @task_id   :: 
     @task_desc :: 
     @params    :: 
     @return    :: 
    */
    public function subscriptionPaymentResponse()
    {
        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
        header("Expires: 0");
        // config fetch message
        $resp = config('response_format.RES_RESULT');
        $paytmChecksum = "";
        $paramList = array();
        $isValidChecksum = "FALSE";

        $paramList = $_POST;
        $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
        //Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
        $isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.

        if ($isValidChecksum == "TRUE") {
            //echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";
            if ($_POST["STATUS"] == "TXN_SUCCESS") { // Success Payment
                //  echo "<b>Transaction status is success</b>" . "<br/>";
                //Process your transaction here as success transaction.
                //Verify amount & order id received from Payment gateway with your application's order id and amount.             
                $additionalData['PAYMENT_STATUS'] = 'completed';
                $additionalData['PAYMENT_RECEIVED'] = 'yes';
                $additionalData['PAYMENT_METHOD'] = 'paytm';
                $additionalData['STATUS'] = 1;
                $this->_updatePaymentDetails($_POST, $additionalData);
                $resp['status'] = true;
                $resp['data'] = array();
                $resp['message'] = 'Congrats, You have Subscribe successfully...!';
                Session::put('success', $resp['message']);
                return redirect('customer/mymissing_person_list')->with('success', $resp['message']);
            } else { // Fail payment
                //echo "<b>Transaction status is failure</b>" . "<br/>";
                $additionalData['PAYMENT_STATUS'] = 'fail';
                $additionalData['PAYMENT_RECEIVED'] = 'no';
                $additionalData['PAYMENT_METHOD'] = 'paytm';
                $additionalData['STATUS'] = 0;
                $this->_updatePaymentDetails($_POST, $additionalData);
                $resp['message'] = 'Subscription was unsuccessfull, Please try again...!';
                Session::put('error', $resp['message']);
                return redirect('customer/subscribe')->with('error', $resp['message']);
            }

            // if (isset($_POST) && count($_POST) > 0) {
            //     foreach ($_POST as $paramName => $paramValue) {
            //         echo "<br/>" . $paramName . " = " . $paramValue;
            //     }
            // }
        } else { // Fail Payment
            // echo "<b>Checksum mismatched.</b>";
            //Process transaction as suspicious.
            $additionalData['PAYMENT_STATUS'] = 'fail';
            $additionalData['PAYMENT_RECEIVED'] = 'no';
            $additionalData['PAYMENT_METHOD'] = 'paytm';
            $additionalData['STATUS'] = 0;
            $this->_updatePaymentDetails($_POST, $additionalData);
            $resp['message'] = 'Subscription was unsuccessfull, Please try again...!';
            Session::put('error', $resp['message']);
            return redirect('customer/subscribe')->with('error', $resp['message']);
        }
    }

    /*
     @author    :: Tejas
     @task_id   :: 
     @task_desc :: 
     @params    :: 
     @return    :: 
    */
    private function _updatePaymentDetails($paymentData = array(), $additionalData = array())
    {
        $updateData['payment_request_id'] = $paymentData['TXNID'];
        $updateData['payment_method'] = $additionalData['PAYMENT_METHOD'];
        $updateData['payment_mode'] = $paymentData['PAYMENTMODE'];
        $updateData['payment_status'] = $additionalData['PAYMENT_STATUS'];
        $updateData['payment_received'] = $additionalData['PAYMENT_RECEIVED'];
        $updateData['payment_currency'] = $paymentData['CURRENCY'];
        $updateData['bank_name'] = $paymentData['BANKNAME'];
        $updateData['total_amount'] = $paymentData['TXNAMOUNT'];
        $updateData['cart_data'] = json_encode($paymentData);
        $updateData['payment_date'] = $paymentData['TXNDATE'];
        $updateData['status'] = $additionalData['STATUS'];
        return (new orders)->update_records($updateData, $paymentData['ORDERID']);
    }

    /*
     @author    :: Tejas
     @task_id   :: 
     @task_desc :: 
     @params    :: 
     @return    :: 
    */
    public function donationPayment(Request $request)
    {
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
        $paramList["TXN_AMOUNT"] = $request->input("donate_amount");
        $paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;

        $paramList["CALLBACK_URL"] = DONATE_RESPONSE_URL;
        $paramList["MSISDN"] = Auth::user()->mobile; //Mobile number of customer
        $paramList["EMAIL"] = Auth::user()->email; //Email ID of customer
        $paramList["VERIFIED_BY"] = "EMAIL"; //
        $paramList["IS_USER_VERIFIED"] = "YES"; //            
        //Here checksum string will return by getChecksumFromArray() function.
        $checkSum = getChecksumFromArray($paramList, PAYTM_MERCHANT_KEY);
        $parameters = $paramList;
        $parameters['QTY'] = 1;
        $parameters['PAYMENT_STATUS'] = 'pending';
        $parameters['PAYMENT_RECEIVED'] = 'no';
        $insertdonor_order_data = $this->_insertDonatePaymentDetails($parameters, [1]);
        $insertdonor_data = $this->_insertprepareDonorDetails(array_merge($request->all(), ['order_id' => $insertdonor_order_data->id]), [1]);
        donation::create($insertdonor_data);
        return view('donate.payment.pgRedirect', compact('checkSum', 'paramList'));
    }

    /*
     @author    :: Tejas
     @task_id   :: 
     @task_desc :: 
     @params    :: 
     @return    :: 
    */
    private function _insertprepareDonorDetails($requestData, $additionalData = array())
    {
        $insertData['name'] = $requestData['donate_name'];
        $insertData['email'] = $requestData['donate_email'];
        $insertData['mobile'] = $requestData['donate_mobile'];
        $insertData['amount'] = $requestData['donate_amount'];
        $insertData['order_id'] = $requestData['order_id'];
        $insertData['user_id'] = Auth::user()->id;
        $insertData['status'] = $additionalData[0];
        return $insertData;
    }

    /*
     @author    :: Tejas
     @task_id   :: 
     @task_desc :: 
     @params    :: 
     @return    :: 
    */
    private function _insertDonatePaymentDetails($paymentData = array(), $additionalData = array())
    {
        $insertData['order_id'] = $paymentData['ORDER_ID'];
        $insertData['user_id'] = str_replace('CUST_', '', $paymentData['CUST_ID']);
        $insertData['qty'] = $paymentData['QTY'];
        $insertData['total_amount'] = $paymentData['TXN_AMOUNT'];
        $insertData['payment_status'] = $paymentData['PAYMENT_STATUS'];
        $insertData['payment_received'] = $paymentData['PAYMENT_RECEIVED'];
        $insertData['status'] = $additionalData[0];
        return (new donation_order())->insert_data($insertData);
    }

    /*
     @author    :: Tejas
     @task_id   :: 
     @task_desc :: 
     @params    :: 
     @return    :: 
    */
    private function _updateDonationPaymentDetails($paymentData = array(), $additionalData = array())
    {
        $updateData['payment_request_id'] = $paymentData['TXNID'];
        $updateData['payment_method'] = $additionalData['PAYMENT_METHOD'];
        $updateData['payment_mode'] = $paymentData['PAYMENTMODE'];
        $updateData['payment_status'] = $additionalData['PAYMENT_STATUS'];
        $updateData['payment_received'] = $additionalData['PAYMENT_RECEIVED'];
        $updateData['payment_currency'] = $paymentData['CURRENCY'];
        $updateData['bank_name'] = $paymentData['BANKNAME'];
        $updateData['total_amount'] = $paymentData['TXNAMOUNT'];
        $updateData['cart_data'] = json_encode($paymentData);
        $updateData['payment_date'] = $paymentData['TXNDATE'];
        $updateData['status'] = $additionalData['STATUS'];
        return (new donation_order)->update_records($updateData, $paymentData['ORDERID']);
    }

    /*
     @author    :: Tejas
     @task_id   :: 
     @task_desc :: 
     @params    :: 
     @return    :: 
    */
    public function donatePaymentResponse()
    {
        header("Pragma: no-cache");
        header("Cache-Control: no-cache");
        header("Expires: 0");
        // config fetch message
        $resp = config('response_format.RES_RESULT');
        $paytmChecksum = "";
        $paramList = array();
        $isValidChecksum = "FALSE";

        $paramList = $_POST;
        $paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg
        //Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
        $isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.

        if ($isValidChecksum == "TRUE") {
            //echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";
            if ($_POST["STATUS"] == "TXN_SUCCESS") { // Success Payment
                //  echo "<b>Transaction status is success</b>" . "<br/>";
                //Process your transaction here as success transaction.
                //Verify amount & order id received from Payment gateway with your application's order id and amount.             
                $additionalData['PAYMENT_STATUS'] = 'completed';
                $additionalData['PAYMENT_RECEIVED'] = 'yes';
                $additionalData['PAYMENT_METHOD'] = 'paytm';
                $additionalData['STATUS'] = 1;
                $this->_updateDonationPaymentDetails($_POST, $additionalData);
                $resp['status'] = true;
                $resp['data'] = array();
                $resp['message'] = 'Congrats, You have Donated Amount successfully...!';
                Session::put('success', $resp['message']);
                return redirect('supportwork/donate')->with('success', $resp['message']);
            } else { // Fail payment
                //echo "<b>Transaction status is failure</b>" . "<br/>";

                $additionalData['PAYMENT_STATUS'] = 'fail';
                $additionalData['PAYMENT_RECEIVED'] = 'no';
                $additionalData['PAYMENT_METHOD'] = 'paytm';
                $additionalData['STATUS'] = 0;
                $this->_updateDonationPaymentDetails($_POST, $additionalData);
                $resp['message'] = 'Donation was unsuccessfull, Please try again...!';
                Session::put('error', $resp['message']);
                return redirect('supportwork/donate')->with('error', $resp['message']);
            }
        } else { // Fail Payment
            // echo "<b>Checksum mismatched.</b>";
            //Process transaction as suspicious.
            $additionalData['PAYMENT_STATUS'] = 'fail';
            $additionalData['PAYMENT_RECEIVED'] = 'no';
            $additionalData['PAYMENT_METHOD'] = 'paytm';
            $additionalData['STATUS'] = 0;
            $this->_updateDonationPaymentDetails($_POST, $additionalData);
            $resp['message'] = 'Donation was unsuccessfull, Please try again...!';
            Session::put('error', $resp['message']);
            return redirect('supportwork/donate')->with('error', $resp['message']);
        }
    }
}
