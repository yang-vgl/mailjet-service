<?php

namespace App\Console\Commands\Contact;

use App\Contracts\MailCommonContract;
use App\Services\Base\MailjetV3Service;
use App\Services\Contact\ContactService;
use Illuminate\Console\Command;

class Contact extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contact';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected  $mjV3;

    /**
     * Create a new command instance.
     *
     * @param MailCommonContract $mjV3
     */
    public function __construct(MailCommonContract $mjV3)
    {
        parent::__construct();
        $this->mjV3 = $mjV3;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $contact = new ContactService($this->mjV3);
        $action = $this->choice('What Action?', ['get', 'getAll', 'create', 'update']);
        switch($action)
        {
        case 'get':
            $id = $this->ask('Enter email:');
            print_r($contact->get($id));
            break;
        case 'getAll':
            print_r($contact->getAll());
            break;
        case 'create':
            $email = $this->ask('Enter email:');
            $isExcludedFromCampaigns = $this->choice('value?', [0, 1]);
            $Name = $this->ask('Enter name:');
            $data = [
                'email' => $email,
                'isExcludedFromCampaigns' => $isExcludedFromCampaigns,
                'name' => $Name
            ];
            print_r($contact->create($data));
            break;
        case 'update':
            $email = $this->ask('Enter email:');
            $isExcludedFromCampaigns = $this->choice('value?', [0, 1]);
            $Name = $this->ask('Enter name:');
            $data = [
                'email' => $email,
                'isExcludedFromCampaigns' => $isExcludedFromCampaigns,
                'name' => $Name
            ];
            print_r($contact->update($data));
            break;
        }
    }

}
