<?php

namespace App\Console\Commands\Contact;

use App\Contracts\MailCommonContract;
use App\Models\ContactList as  ContactListModel;
use App\Services\Base\MailjetV3Service;
use App\Services\Contact\ContactListService;
use App\Services\Contact\ContactService;
use Illuminate\Console\Command;

class ContactList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contact:list';

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
        $contactList = new ContactListService($this->mjV3);
        $action = $this->choice('What Action?', ['get', 'getAll', 'create', 'update', 'contactsManagement']);
        switch($action)
        {
            case 'get':
                $id = $this->ask('Enter contact list id:');
                print_r($contactList->get($id));
                break;
            case 'getAll':
                print_r($contactList->getAll());
                break;
            case 'create':
                $name = $this->ask('Enter list name:');
                $data = [
                    'name' => $name
                ];
                print_r($contactList->create($data));
                break;
            case 'update':
                $id = $this->ask('Enter list id:');
                $name = $this->ask('Enter name:');
                $data = [
                    'id' => $id,
                    'name' => $name
                ];
                print_r($contactList->update($data));
                break;
            case 'contactsManagement':
                $data = [];
                $data['contacts'] = [];
                do{
                    $email = $this->ask('Enter email:');
                    array_push( $data['contacts'], $email);
                }while($this->confirm('add another email?'));

                do{
                    $list = $this->ask('Enter list id:');
                    $action = $this->choice('What Action?', ContactListModel::ACTIONS);
                    $data['contactLists'][] =
                        [
                            'listId' => $list,
                            'action' => $action,
                        ];
                }while($this->confirm('add another list?'));
                print_r($contactList->contactsManagement($data));
                break;
        }
    }

}
