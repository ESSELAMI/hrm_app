<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\SendEmail;
use App\Models\User;
use Mail;

class SendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications to user through kerio connect';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = User::findOrFail(2);
        $notifications_number = $user->notifications->count();
        Mail::to('esselamia@cnas.com')->send(new SendEmail("Notifications GPA", $notifications_number));
    }
}
