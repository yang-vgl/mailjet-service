<?php

namespace App\Console\Commands;

use App\Events\ForgetPassword;
use Illuminate\Console\Command;

class ResetPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'trigger reset password even to send password reset email';

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
        $subject = $this->ask('Enter Subject:', 'Reset Password');
        $fromEmail = $this->ask("Enter From Email():", config('services.mailjet.From.Email'));
        $fromName = $this->ask("Enter From Name():", config('services.mailjet.From.Name'));
        $toEmail = $this->ask('enter recipient\'s email(required):');
        $toName = $this->ask('Enter recipient\'s Name(optional):');
        $code = $this->ask('Enter Activate Code(required):');
        $link = $this->ask('Enter Reset Link(required):');
        $data = [
            'recipients' =>[
                'email' => $toEmail,
                'name' => $toName
            ],
            'fromEmail' => $fromEmail,
            'fromName' => $fromName,
            'code' => $code,
            'link' => $link,
            'subject' => $subject,
        ];
        event(new ForgetPassword($data));
    }
}
