<?php

namespace App\Console\Commands\Contact;

use App\Contracts\MailCommonContract;
use App\Models\ContactMetaData;
use App\Services\Base\MailjetV3Service;
use App\Services\Contact\ContactMegaDataService;
use App\Services\Contact\ContactService;
use Illuminate\Console\Command;

class MegaData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'megaData';

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
        $contact = new ContactMegaDataService($this->mjV3);
        $action = $this->choice('What Action?', ['create', 'update']);
        switch($action)
        {
        case 'create':
            $dataType = $this->choice('dataType:', ContactMetaData::DATATYPE);
            $name = $this->ask('Enter name:');
            $megaData = [
                'dataType' => $dataType,
                'name' => $name,
            ];
            print_r($contact->create($megaData));
            break;
        case 'update':
            $email = $this->ask('Enter email:');
            $data = [];
            do{
                $name = $this->ask('Enter name:');
                $value = $this->ask('Enter value:');
                $data[] = [
                    'Name' => $name,
                    'Value' => $value
                ];
            }while($this->confirm('add another value?'));
            $megaUpdateData = [
                'email' => $email,
                'data' => $data
            ];
            print_r($contact->update($megaUpdateData));
            break;
        }
    }

}
