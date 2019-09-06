<?php
namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;

class TempDirectory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'temp:clean';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean the temporary directories.';
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment('Cleaning directories...');

        $expired_file_count = 0;
        $active_file_count = 0;

        // Grab the temp files
        $file = storage_path(config('const.img_path_temp'));

        //Loop the files and get rid of any that have expired
        foreach (glob($file."*") as $files) {
            //if file creation time is more than 1 minutes
            if ((time() - filectime($files)) > 216000) {  // 3600 = 60*60
                \File::deleteDirectory($files);
                $expired_file_count++;
            }else{
                $active_file_count++;
            }
        }

        $this->info('Total expired temp user files removed: '.$expired_file_count);
        $this->info('Total active temp user files remaining: '.$active_file_count);
    }
}