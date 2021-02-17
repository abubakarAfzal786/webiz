<?php

namespace App\Console\Commands;

use App\Http\Helpers\TwilioHelper;
use App\Models\Member;
use Illuminate\Console\Command;

class SendMembersPasswords extends Command
{
    use TwilioHelper;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passwords:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send temp passwords to members';

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
     * @return void
     */
    public function handle()
    {
        $members = Member::query()->whereNotNull('temp_pass')->get();

        foreach ($members as $member) {
            if ($this->sendSMS($member->phone, 'Your temporary password in WeBiz app is: ' . $member->temp_pass)) {
                echo 'Notification to ' . $member->phone . ' sent' . "\n";
//                $member->update(['temp_pass' => null]);
            } else {
                echo 'FAILED to send notification to ' . $member->phone . "\n";
            }
        }
    }
}
