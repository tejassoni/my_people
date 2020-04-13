<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->markdown('templates.email.activation_template')
            // ->from('tejas.soni@sinelogix.com', 'Tejas Soni')
            ->cc('test.intransure@gmail.com')
            ->bcc('mypeoplesolution@gmail.com')
            ->replyTo('noreply@gmail.com')
            ->subject('MyPeople Solutions Pvt. Ltd')
            ->with('email_content', $this->details);
        // ->attach($this->details['attachment']['file_path'], ['as' => $this->details['attachment']['display_name'], 'mime' => $this->details['attachment']['mime_type']]);
        return $email;
    }
}
