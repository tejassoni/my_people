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
        try {
            // Validation Enables
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required:email',
                'subject' => 'required',
                'message' => 'required',
                'file_test' => 'mimes:jpeg,png,jpg,gif,svg,txt,pdf,ppt,doc,docx,xls',
            ]);

            // File attachement validation //
            // if ($request->hasFile('file_test')) {
            //     $image = $request->file('file_test');
            //     $fileName = $image->getClientOriginalName();
            //     $fileExtension = $image->getClientOriginalExtension();
            //     $fileMime = $image->getMimeType();
            // }

            // Dynamic Data will be pass into email template view starts
            $details = [
                'name' => 'Tejas Soni',
                'username' => 'tejas.soni',
                'activation_link' => 'http://rockysucks.wordpress.com',
                'body' => 'Thanks for joining with us. We are glad to provide you <b>MyPeopleSolution</b> service.',
                'body2' => 'To finish signing up and',
                'body3' => 'activate your account',
                'body4' => 'you just need to click below button.',
                'body5' => 'Thanks so much for joining our site! ',
                'body6' => 'Your username is:',
                'socialmedia_image' => array('facebook' => '/assets/images/facebook2x.png', 'instagram' => '/assets/images/instagram2x.png', 'twitter' => '/assets/images/twitter2x.png'),
                'logo_image_path' => '/assets/images/logo_1.png', // location public /assets/images/filename.jpg
                'back_image_path' => '/assets/images/bg_password.gif', // location public /assets/images/filename.jpg
                'back2_image_path' => '/assets/images/illo.png', // location public /assets/images/filename.jpg
                'address' => 'MyPeople Solutions Pvt. Ltd',
                'address2' => 'Gotri, Vadodara',
                'pincode' => '390021',
                //'attachment' => ['file_path' => \public_path() . '/assets/images/logo_1.png', 'display_name' => 'LogoTest.png', 'mime_type' => 'image/png'],
                //'attachment' => ['file_path' => $image->getRealPath(), 'display_name' => $fileName . $fileExtension, 'mime_type' => $fileMime],
            ];
            // Dynamic Data will be pass into email template view ends

            // Email Send To and pass details within the email template view
            Mail::to('tejas.tejas.soni3@gmail.com')->send(new SendMail($details));

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
