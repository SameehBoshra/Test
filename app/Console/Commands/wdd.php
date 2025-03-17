<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use PhpOption\Option;

class wdd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //protected $signature = 'wdd:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'User Count ';

    protected $signature = 'wdd:user {--verified}';

/**
 * Execute the console command.
 */
public function handle()
{
    if ($this->option('verified')) {
        echo User::where('email_verified_at' ,'<>',null)->count();
    } else {
        echo User::count();
    }
}
}
