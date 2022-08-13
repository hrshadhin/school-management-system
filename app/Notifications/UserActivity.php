<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class UserActivity extends Notification
{
    protected $msg_type = '';
    protected $msg_text = '';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($msg_type, $msg_text)
    {
        $this->msg_type = $msg_type;
        $this->msg_text = $msg_text;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }



    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'msg_type' => $this->msg_type,
            'msg_text' => $this->msg_text,
        ];
    }
}
