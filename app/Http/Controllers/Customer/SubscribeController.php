<?php

namespace App\Http\Controllers\Customer;

use App\Models\user_master;
use Illuminate\Http\Request;
use App\Models\subscription_master;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        $user_detail_trail = (new user_master())->find(Auth::user()->id)->is_trail_used;
        $subscription_list = (new subscription_master)->list_belongsTo($user_detail_trail);
        return view('customer.subscriptions.list_view', compact('subscription_list'));
    }
}
