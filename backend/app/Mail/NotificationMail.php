<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $messageBody;
    public $actionUrl;
    public $actionText;
    public $user;
    public $transaction;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $messageBody, $actionUrl, $actionText, $user, $transaction = null)
    {
        $this->subject = $subject;
        $this->messageBody = $messageBody;
        $this->actionUrl = $actionUrl;
        $this->actionText = $actionText;
        $this->user = $user;
        $this->transaction = $transaction;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.notification')
                    ->subject($this->subject);
    }
}
