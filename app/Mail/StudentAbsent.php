<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class StudentAbsent extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private  $emailContent = '';

    /**
     *
     * @param string $emailAddress
     * @param string $emailContent
     * @return void
     */
    public function __construct(string $emailContent)
    {
        $this->emailContent = $emailContent;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_NO_REPLY_ADDRESS','dev@hrshadhin.me'))
            ->markdown('emails.absent.student')
            ->with([
                'emailContent' => $this->emailContent
            ]);
    }
}
