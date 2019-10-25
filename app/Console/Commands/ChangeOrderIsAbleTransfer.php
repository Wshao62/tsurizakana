<?php
namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class ChangeOrderIsAbleTransfer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:changeIsAbleTransfer';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Garbage fish every 14 oclock';
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment('Update Order IsAbleTransfer...');

        // Get rid of any that have expired
        $trash = Order::where('is_able_transfer', 0)
                ->update([
                    'is_able_transfer' => 1
                ]);

        $this->info('Total Order updated: '.$trash);

    }
}
