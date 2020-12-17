<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Validator;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjet = "Cambiar Contraseña";
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $validation = Validator::make($data, [
            'hash' => 'required',
            'id' => 'required',
            'username' => 'required'
        ]);
        
        if(!$validation->fails())
        {
            $this->data = $data;
        }
        else
        {
            return;
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.ResetPasswordMail');
    }
}
