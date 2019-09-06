<?php
namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Message;
use App\Models\Fish;

class EmailNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:mail';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sent message notification.';
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Message $msg)
    {
        $this->comment('Initializing....');

        $notifications = $msg->notifications()->groupBy('receiver_id');
        if(count($notifications) >= 1){
            foreach ($notifications as $keys => $notification) {
                $msg['email'] = User::whereId($keys)->first()->email;
                $msg->sendMessageNotification($notification);

                Message::whereReceiverId($keys)
                    ->whereIsSeen(Message::UNREAD)
                    ->update(['is_seen' => Message::SENDMAIL ]);
            }
            $this->info('Unread messages has been sent successfully.');
        }else {
            $this->comment('No unread messages at this moment.');
        }
    }

}