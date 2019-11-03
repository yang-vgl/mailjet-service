<?php

namespace App\Console\Commands;

use App\Events\AccountCreate;
use Illuminate\Console\Command;

class AccountConfirm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'account:confirm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'trigger account create even to send confirmation email';

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
        $subject = $this->ask('Enter Subject:', 'Account Confirm');
        $fromEmail = $this->ask("Enter From Email():", config('services.mailjet.From.Email'));
        $fromName = $this->ask("Enter From Name():", config('services.mailjet.From.Name'));
        $toEmail = $this->ask('enter recipient\'s email(required):');
        $toName = $this->ask('Enter recipient\'s Name():', 'Cruiser');
        $link = $this->ask('Enter Confirm Link(required):');
        $data = [
            'recipients' =>[
                'email' => $toEmail,
                'name' => $toName
            ],
            'fromEmail' => $fromEmail,
            'fromName' => $fromName,
            'link' => $link,
            'subject' => $subject,
        ];
        event(new AccountCreate($data));
    }
}
