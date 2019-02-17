<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
       $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {    $base_url = config('app.url');
        return $this->from('taxpdr@taxpdr.com','TaxPDR')->subject('Welcome to TaxPDR ')->view('email_template.confirmationemail')->with([
'email_token' => $this->user->confirmation_code,'otp'=>$this->user->otp,'name'=>$this->user->name,'base_url'=>$base_url
]);
    }
}
