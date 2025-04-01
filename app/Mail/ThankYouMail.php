<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ThankYouMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $songName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $songName = '')
    {
        $this->name = $name;
        $this->songName = $songName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Thank You for Your Feedback')
                    ->view('emails.thank-you');
    }
}