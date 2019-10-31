<?php

namespace App\Console\Commands;

use App\Events\AccountCreate;
use Illuminate\Console\Command;
use \App\Events\AccountConfirm as AccountConfirmEvent;

class Welcome extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'confirm:welcome';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'trigger account confirm even to send welcome email';

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
        $recipients = [];
        $subject = $this->ask('Enter Subject(optional):', 'Welcome Aboard !');
        $fromEmail = $this->ask("Enter From Email(optional):", config('services.mailjet.From.Email'));
        $fromName = $this->ask("Enter From Name(optional):", config('services.mailjet.From.Name'));
        $toEmail = $this->ask('enter recipient\'s email(required):');
        $toName = $this->ask('Enter recipient\'s Name(optional):', 'Cruiser');
        $recipients[] = [
            'email' => $toEmail,
            'name' => $toName
        ];
        while($this->confirm('Do you wish to add another recipient ?')) {
            $toEmail = $this->ask('enter recipient\'s email(required):');
            $toName = $this->ask('Enter recipient\'s Name(optional):', 'Cruiser');
            $recipients[] = [
                'email' => $toEmail,
                'name' => $toName
            ];
        }
        $data = [
            'recipients' => $recipients,
            'fromEmail' => $fromEmail,
            'fromName' => $fromName,
            'subject' => $subject,
        ];
        event(new AccountConfirmEvent($data));exit;
    }
}
