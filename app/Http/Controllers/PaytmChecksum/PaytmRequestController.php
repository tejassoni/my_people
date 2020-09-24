<?php

namespace App\Http\Controllers\PaytmChecksum;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaytmRequestController extends Controller
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    { // constructor code starts here        
        /* initialize an array */
        $paytmParams = array();

        /* add parameters in Array */
        $paytmParams["MID"] = "vMohMe09520772013455"; // Your Test / Production Merchant ID
        $paytmParams["ORDERID"] = "test123";

        /**
         * Generate checksum by parameters we have
         * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys 
         */
        $paytmChecksum = PaytmChecksum::generateSignature($paytmParams, '!%1@q#GLuSMWb3mW');
        $verifySignature = PaytmChecksum::verifySignature($paytmParams, '!%1@q#GLuSMWb3mW', $paytmChecksum);
        echo sprintf("generateSignature Returns: %s\n", $paytmChecksum);
        echo sprintf("verifySignature Returns: %b\n\n", $verifySignature);

        exit;
        // /* initialize JSON String */
        // $body = "{\"mid\":\"YOUR_MID_HERE\",\"orderId\":\"YOUR_ORDER_ID_HERE\"}";

        // /**
        //  * Generate checksum by parameters we have in body
        //  * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys 
        //  */
        // $paytmChecksum = PaytmChecksum::generateSignature($body, 'YOUR_MERCHANT_KEY');
        // $verifySignature = PaytmChecksum::verifySignature($body, 'YOUR_MERCHANT_KEY', $paytmChecksum);
        // echo sprintf("generateSignature Returns: %s\n", $paytmChecksum);
        // echo sprintf("verifySignature Returns: %b\n\n", $verifySignature);
    }

    /**
     * Handle routs Controller Load Edit functionality
     * @author Tejas
     * @param  Role ID
     * @return plan_master id wise records into edit view
     */
    public function get_payment_list()
    {
        dd("payment list calls");
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
        dd("payment list calls");
        return view('admin.plans.edit_view', compact(['plan_result', 'discount_result']));
    }
}
