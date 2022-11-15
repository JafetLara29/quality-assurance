<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReviewFunctionalityMail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $QAUser;
    public $type;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $QAUser, $data, $type)
    {
        $this->user = $user;
        $this->QAUser = $QAUser;
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.test');
    }
}
