<?php

namespace App\Notifications;

use App\Models\Fish;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TransferRequestedNotificationToAdmin extends Notification
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
        setlocale(LC_ALL, 'ja_JP.UTF-8');
        $transfer_at_ja = Carbon::parse($this->transferRequest->transfer_at)->formatLocalized('%Y年%m月%d日(%a)');
        $requested_at_ja = Carbon::parse($this->transferRequest->requested_at_ja)->formatLocalized('%Y年%m月%d日(%a)');
        return (new MailMessage)
            ->subject("【振込申請:".$transfer_at_ja . "振込分】")
            ->markdown('mails.transfer_requested_to_admin', [
                'transfer_request' => $this->transferRequest,
                'transfer_at_ja' => $transfer_at_ja,
                'requested_at_ja' => $requested_at_ja,
            ]);
    }
}
