<?php
namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;
use App\Models\TempRegist;
use Carbon\Carbon;

class ServiceMailNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service:mail';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Service mail is to broadcasts all mail users @tempregist';
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(TempRegist $tmp)
    {
        $this->comment('Started sending mail...');
        foreach ($tmp->get() as  $notification) {
            $tmp['email'] = $notification->email;
            $tmp->sendServiceNotification($notification->token);
        }
    }
}