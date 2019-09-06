<?php

namespace App\Notifications\Fish;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OfferNotification extends Notification
{
    use Queueable;

    private $message;
    private $fish;
    private $request;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message, $fish, $request)
    {
        $this->message = $message;
        $this->fish = $fish;
        $this->request = $request;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $Mail_title = "リクエストした魚にオファーがありました";
        $Mail_Message = (new MailMessage)
                    ->subject($Mail_title)
                    ->markdown('mails.fish.offer_complete', [
                        'message' => $this->message,
                        'fish' => $this->fish,
                        'request' => $this->request,
                      ]);

        return $Mail_Message;
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
            //
        ];
    }
}