<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

class MailSend extends Controller
{

     /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }
    

    public function mailsend(Request $request)
    {   
        // Validate email if post request
       /* $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]); */

        // Dynamic Data will be pass into view
        $details = [
            'title' => 'Activate Account',
            'body' => 'Body: This is for testing email using smtp'
        ];
        // Email Send To and pass details within the email template view
        Mail::to('tejas.tejas.soni3@gmail.com')->send(new SendMail($details));
        try {
            $resp['status'] = true;
            $resp['data'] = array();
            $resp['message'] = 'Thanks email sent successfully...!';
            $request->session()->put('success', $resp['message']);
            return redirect()->back()->with('success', $resp['message']);
    	} catch (\Exception $ex) {
            $resp['status'] = false;
            $resp['data'] = array();
            $resp['message'] = 'Email not sent...! Please try again after some time';
            $resp['error_message'] = $ex->getMessage();
            $resp['error_file'] = $ex->getFile();
            $resp['error_line'] = $ex->getLine();
            $resp['error_code'] = $ex->getCode();
            $resp['error_trace'] = $ex->getTrace();
            $request->session()->put('error', $resp['message']);
            return redirect()->back()->withInput()->with('error', $resp['message']);
    	}
        
    }

}
