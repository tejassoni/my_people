<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\subscription_master;
use App\Http\Controllers\Controller;

class SubscribeController extends Controller
{

    /**
     * Handle routs Controller load view request
     * @author Tejas
     * @param  none
     * @return role/view/list_view.blade.php
     */
    public function list_view(Request $request)
    {
        $subscription_list = (new subscription_master)->list_belongsTo();
        return view('customer.subscriptions.list_view', compact('subscription_list'));
    }
}
