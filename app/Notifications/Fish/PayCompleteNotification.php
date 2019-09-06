<?php

namespace App\Notifications\Fish;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PayCompleteNotification extends Notification
{
    use Queueable;

    protected $data;
    protected $is_seller;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data, $is_seller = true)
    {
        $this->data = $data;
        $this->is_seller = $is_seller;
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
        if ($this->is_seller == true) {
            //売主へのメール
            $mail_title = "商品の支払いが確認できました。ご発送をお願いします。";
            $mail_message = (new MailMessage)
                            ->subject($mail_title)
                            ->markdown('mails.fish.seller_pay_complete', [
                                'data' => $this->data,
                            ]);
        } else {
            //買主へのメール
            $mail_title = "商品代金のお支払いありがとうございます。";
            $mail_message = (new MailMessage)
                            ->subject($mail_title)
                            ->markdown('mails.fish.buyer_pay_complete', [
                                'data' => $this->data,
                            ]);
        }
        return $mail_message;
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
