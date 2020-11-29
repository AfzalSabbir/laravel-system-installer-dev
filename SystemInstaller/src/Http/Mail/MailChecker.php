<?php

namespace AfzalSabbir\SystemInstaller\Http\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailChecker extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * [$description description]
     * @var [type]
     */
    public $description;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($description)
    {
        $this->description = $description;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('SystemInstaller::email.check-mail')->with(['description' => $this->description]);
    }
}
