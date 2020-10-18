<?php

namespace App\Http\Controllers\Donate;


use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SupportWorkController extends Controller
{

    /**
     * Handle routs Controller load view request
     * @author Tejas
     * @param  none
     * @return role/view/list_view.blade.php
     */
    public function list_view()
    {
        return view('donate.supportwork.list_view');
    }
}
