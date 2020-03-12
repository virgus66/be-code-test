<?php

namespace App\Mail\Organisation;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    public $subject;
    /**
     * @var object
     */
    public $organisation;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $organisation)
    {
        $this->subject = $subject;
        $this->organisation = $organisation;
    }

    /**
     * Build the message.
     *Cre
     * @return $this
     */
    public function build()
    {
        return $this->text('emails.confirmation')
            ->subject($this->subject);
    }
}
