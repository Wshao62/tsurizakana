<?php

namespace App\Notifications;

use App\Models\Fish;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TransferRequestedNotificationToUser extends Notification
{
    use Queueable;

    private $transferRequest;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($transferRequest)
    {
        $this->transferRequest = $transferRequest;
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
        return (new MailMessage)
            ->subject("振込申請が完了しました")
            ->from('support@tsurizakana-shoten.com')
            ->markdown('mails.transfer_requested_to_user', [
                'transfer_request' => $this->transferRequest,
            ]);
    }
}
