<?php

namespace App\Http\Controllers\Cron;

use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\orders;
use App\Models\subscription_master;

class CronJobController extends Controller
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    { // coonstructor code starts here        

    }

    /*
     @author    :: Tejas
     @task_id   :: 
     @task_desc :: 
     @params    :: 
     @return    :: 
    */
    protected function subscriptionExpiredCustomers()
    {
        // config fetch message
        $resp = config('response_format.RES_RESULT');
        $searchParams['payment_status'] = 'completed';
        $searchParams['payment_received'] = 'yes';
        $searchParams['status'] = 1;
        $order_lists = (new orders)->list_by_params($searchParams);

        if (isset($order_lists) && !empty($order_lists)) {
            foreach ($order_lists as $key_order => $val_order) {
                $subscription_details = $this->_getSubscriptionDetails($val_order->subscription_id);
                if (isset($subscription_details) && !empty($subscription_details)) {
                    $days = $subscription_details['sub_validity'] + 1;
                    $expire_subscription_date = date('d-m-Y', strtotime("+$days days", strtotime($val_order->payment_date)));
                    if ($expire_subscription_date <= date('d-m-Y')) {
                        $this->setCustomerSubscriptionExpire($val_order->order_id);
                    } else {
                        // dd("subscription not expire");
                    }
                }
            } // Loops Ends
            $resp['status'] = true;
            $resp['message'] = 'Cron Process Completed..!';
            return response()->json($resp);
        }
        $resp['message'] = 'Cron Process Not Required..!';
        return response()->json($resp);
    }

    /*
     @author    :: Tejas
     @task_id   :: 
     @task_desc :: 
     @params    :: 
     @return    :: 
    */
    private function _getSubscriptionDetails(int $subscription_id)
    {
        return (new subscription_master)->listById_belongsTo($subscription_id);
    }


    /*
     @author    :: Tejas
     @task_id   :: 
     @task_desc :: 
     @params    :: 
     @return    :: 
    */
    private function setCustomerSubscriptionExpire($order_id = "")
    {
        return (new orders)->update_records(['status' => 0], $order_id);
    }
}
