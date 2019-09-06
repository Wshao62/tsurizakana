<?php
namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;
use App\Models\Fish;
use Carbon\Carbon;

class FishGarbage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fish:garbage';
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
        $this->comment('Cleaning Fish...');

        // Get rid of any that have expired
        $trash = Fish::whereStatus(Fish::STATUS_PUBLISH)
                ->where('created_at', '<', Carbon::createFromTime(14,00,00))
                ->update([
                    'status' => Fish::STATUS_EXPIRED
                ]);

        $this->info('Total fish updated status: '.$trash);

    }
}