# Mailjet Email Service
    
* ### [Installation](#installation_anchor)
   * #### [Server Requirements](#server_requirements)
   * #### [ Install&config](#install_config)
* ### [Architecture](#architecture_anchor)
   * #### [Config](#config_anchor)
   * #### [Contracts](#contracts_anchor)
   * #### [Services](#services_anchor)
   * #### [Service Provider](#service_provider_anchor)
   * #### [Templates](#templates_anchor)
   * #### [Events&Listeners](#events_Listeners_anchor)
   * #### [Models](#models_anchor)
   * #### [Commands](#commands_anchor)
* ### [Unified Response](#response)
* ### [Service Documentation](#service_doc)
   * #### [Transactional Emails](#transactional_emails)
        * ##### [Account Confirm Email](#confirm_email)
        * ##### [Welcome Email](#welcome_email)
        * ##### [Reset Password Email](#reset_password_email)
        * ##### [Price Alert Email](#price_alert_email)
   * #### [Contacts](#contacts_anchor)
   * #### [Contacts Attributes](#contacts_attributes_anchor)
   * #### [Contacts List](#contacts_list_anchor)
   * #### [Piwik Tracking](#piwik_tracking_anchor)
* ### [Webhook](#webhook_anchor)
* ### [Tests](#tests_anchor)
   * #### [Email Services Test](#email_services_test)
   * #### [Contact Services Test](#contact_services_test)
   * #### [Contact MegaData Services Test](#contact_mega_services_test)
   * #### [Contact List Services Test](#contact_list_services_test)
   * #### [Webhook API Test](#webhook_api_test)
* ### [Todos](#todos_anchor)
* ### [Bugs](#bugs_anchor)

<a name="installation_anchor"><h1>installation</h1></a>

<a name="server_requirements"><h3>Server Requirements </h3></a>

  * PHP >= 7.2.0
  * MySQL >= 5.6
 
 <a name="install_config"><h3>install&config</h3></a> 
   >  
    git clone  git@github.com:jaime48/mailjet-service.git
   >   
    cd /path/to/project  &  composer install

 edit .env
   >
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=database_name
    DB_USERNAME=mysql_user
    DB_PASSWORD=mysql_password

	QUEUE_CONNECTION=database
	 
    MAILJET_APIKEY=your_mailjet_key
    MAILJET_APISECRET=your_mailjet_secret
    
 run     
   >    
    php artisan cache:clear       
    php artisan migrate
    php artisan queue:work
    php artisan redis:subscribe(TBD)

<a name="architecture_anchor"><h1>Architecture</h1></a>

<a name="config_anchor"><h3>Config</h3></a>

Config for Mailjet APIs is located at

 >
    /config/services.php

According to Mailjet Documentation two different versions of APIs are required:

Version 3.1 : for sending transactional emails.

Version 3 : for other common services(e.g. contacts, attributes, webhook).

 >
    'mailjet' => [
         'key' => env('MAILJET_APIKEY'),
         'secret' => env('MAILJET_APISECRET'),
         'transactional' => [
             'call' => true,
             'options' => [
                 'url' => 'api.mailjet.com',
                 'version' => 'v3.1',
                 'call' => true,
                 'secured' => true
             ]
         ],
         'common' => [
             'call' => true,
             'options' => [
                 'url' => 'api.mailjet.com',
                 'version' => 'v3',
                 'call' => true,
                 'secured' => true
             ]
         ],
         'From' => [
             'Email' => "info@cruisewatch.com",
             'Name' => "name"
         ],
         //basic HTTP(s) Authentication for webhook callback
         'callback' => [
             'username' => 'username',
             'password' => 'password'
         ]
     ]

<a name="contracts_anchor"><h3>Contracts</h3></a>
 >
    /app/Contracts/*
interfaces that define core services for integrating with third-party mail server.
 
<a name="services_anchor"><h3>Services</h3></a>

Basic services that implement contracts interfaces with Mailjet Server.
 >
    /app/Services/Base/*

Services that send transactional emails

 >
    /app/Services/TransactionalEmailService.php

Services that manage contacts and attributes

 >
    /app/Services/Contact/*
    
<a name="service_provider_anchor"><h3>Service Provider</h3></a>

Denpendency Injections for Mailjet Server Services

  >
    /app/Providers/MailServiceProvider.php
        
<a name="templates_anchor"><h3>Templates</h3></a>

Templates classes for transactional emails corresponding to the templates defined in Mailjet 

 >
    /app/Templates/*


<a name="events_Listeners_anchor"><h3>Events&Listeners</h3></a>

Events&Listeners triggering transactional emails integrating with templates

 >
    /app/Events/*
    /app/Listeners/*
    
<a name="models_anchor"><h3>Models</h3></a>

Contains models for Mailjet Components, e.g. contacts, contacts attributes.

 >
    /app/Models/*

<a name="commands_anchor"><h3>Commands</h3></a>

executable scripts for testing and Redis pub/sub 

 >
    /app/Console/Commands/*

<a name="response"><h1>Unified Response</h1></a>

All services return same formation of standardized response
 >
    {
      "status": true, 
      "msg": "",          // error message if status is false
      "data": {
            ...
          }               // response data if any
    }

<a name="service_doc"><h1>Service Documentation</h1></a>

<a name="transactional_emails"><h3>Transactional Emails</h3></a>

<a name="confirm_email"><h4>Account Confirm Email</h4></a>

 > Trigger

    event(new AccountCreate($data));
 
 > Parameters
   
    $data = [
        'recipients' =>[
            'email' => $toEmail,          //(required) recipient's email
                'name' => $toName         // (optional) recipient's name
            ],
            'fromEmail' => $fromEmail,    //(optional) recipient's email
            'fromName' => $fromName,      //(optional) recipient's email
            'link' => $link,              //(required) link for confirming registration
            'subject' => $subject,        //(optional)
           ];
           
<a name="welcome_email"><h4>Welcome Email</h4></a>

 > Trigger

    event(new AccountConfirmEvent($data));

 > Parameters
   
    $data = [
        'recipients' => [
            'email' => $toEmail,    //(required)
            'name'  => $toName      //(optional)
        ],
        'fromEmail' => $fromEmail,  //(optional)
        'fromName' => $fromName,    //(optional)
        'subject' => $subject,      //(optional)
    ];
               
<a name="reset_password_email"><h4>Reset Password Email</h4></a>

 > Trigger

    event(new ForgetPassword($data));

 > Parameters
   
    $data = [
        'recipients' =>[
            'email' => $toEmail,   //(required)
            'name' => $toName      //(optional)
        ],
        'fromEmail' => $fromEmail, //(optional)
        'fromName' => $fromName,   //(optional)
        'code' => $code,           //(required) activation code
        'link' => $link,           //(required) reset password link
        'subject' => $subject,     //(optional)
    ];     
    
<a name="price_alert_email"><h4>Price Alert Email</h4></a>
   
 > Trigger

    event(new PriceChange($data));

 > Parameters

    $data = [
        'subject' => 'Price Alert',                             //(optional)
        'fromEmail' => 'email@email.com',                  //(optional)
        'fromName' => 'name',                           //(optional)
        "links"=> [
            'details' => 'https://www.cruisewatch.com/',        //(required) variable in the template
            "configure"=>"https://www.cruisewatch.com/",        //(required) variable in the template
            "unsubscribe"=>"https://www.cruisewatch.com/"       //(required) variable in the template
        ],
        "alert" => [
            "trip_name"=>"Trip to Africa",                      //(required) variable in the template
            "ship_name"=>"Chief Running Water",                 //(required) variable in the template
            "departure_date"=>"2019/12/12 12:01:12",            //(required) variable in the template
            "prices"=> [
                [
                    'is_drop' => 1,                             //(required) variable in the template
                    'cabin_type' =>'luxury',                    //(required) variable in the template
                    'current' => 1100,                          //(required) variable in the template
                    'change_abs' =>100,                         //(required) variable in the template
                    'change_rel' => 2,                          //(required) variable in the template
                    'updated_at' => '2019/11/10 12:01:12',      //(required) variable in the template
                ],
                [
                    'is_drop' => 0,
                    'cabin_type' =>'economic',
                    'current' => 500,
                    'change_abs' => 100,
                    'change_rel' => 3,
                    'updated_at' => '2019/11/10 12:01:12',
                ],
                ...
            ]
        ],
        'recipients' =>[
            [
                'email' => 'duyanguk@163.com',                  //(required) 
                'name' => 'Yang'                                //(optional) 
            ],
            [
                'email' => 'duyang48484848@gmail.com',
                'name' => 'Yang'
            ],
            ...
        ]
    ];  

<a name="contacts_anchor"><h3>Contacts</h3></a>
 > 
    $contact = new ContactService(MailCommonContract $mjV3);

get a contact:
 > 
    $contact->get($id);
    
 > Parameters

    $id : "duyanguk@163.com"  //email or contact id
          
get all contacts:
 > 
    $contact->getAll();
    
create a new contact:
 > 
    $contact->create($data);
    
 > Parameters

    $data = [
        'email' => 'duyanguk1@163.com',  //(required)
        'IsExcludedFromCampaigns' => 1,  //(optional)
        'Name' => "Yang Du"              //(optional)
    ];  
    
update an existing contact:
 > 
    $contact->update($data);
    
 > Parameters

    $data = [
        'email' => 'duyanguk1@163.com',  //(required) email or contact id
        'IsExcludedFromCampaigns' => 1,  //(optional)
        'Name' => "Yang Du"              //(optional)
    ];  
    
<a name="contacts_attributes_anchor"><h3>Contacts Attributes</h3></a>
 
 > 
    $megaData = new ContactMegaDataService(MailCommonContract $mjV3);

create a new attribute:
 > 
    $megaData->create($data);
    
 > Parameters

    $megaData = [
        'dataType' => $dataType, //(required)
        'name' => $name,         //(required)
    ];
    
update additional attributes of a contact:
 > 
    $megaData->update($megaUpdateData);
    
 > Parameters

    $megaUpdateData = [
        'email' => 'duyanguk1@163.com',  //(required) email or coantact id
        'data' => [
            [
                'Name' => "last_name",  //(required)
                'Value' => "Doe2"       //(required)
            ],
            [
                'Name' => "country",
                'Value' => "china"
            ],
            ...
        ]
    ];
    
<a name="contacts_list_anchor"><h3>Contacts Lists</h3></a>    

 > 
    $contactList = new ContactListService(MailCommonContract $mjV3);

get a contact list:
 > 
    $contactList->get($id);
    
 > Parameters

    $id : 21242141  //contact list id
          
get all contacts list:
 > 
    $contactList->getAll();
    
create a new contact list:

 > 
    $contactList->create($data);
    
 > Parameters

    $data = [
        'name' => $name //(required)
    ];
    
update a new contact list:

 > 
    $contactList->update($data);
    
 > Parameters

    $data = [
        'id' => $id,     //(required)
        'name' => $name  //(required)
    ];

update multiple contacts to multiple lists:
Actions:

        'addforce',   # adds the contact and resets the unsub status to false
        'addnoforce', # adds the contact and does not change the subscription status of the contact
        'remove',     # removes the contact from the list
        'unsub'       # unsubscribes a contact from the list

 > 
    $contactList->contactsManagement($data);
    
 > Parameters

    $data = [
        'contacts' => [
            "duyanguk@163.com",         //(required)
            "duyang48484848@gmail.com",
            ...
        ],
        'contactLists' => [
            [
                'action' => "addforce",  //(required)
                'listId' => "10125920"   //(required)
            ],
            [
                'action' => "addnoforce",
                'listId' => "10125919"
            ],
            ...
        ]
    ];
    
<a name="piwik_tracking_anchor"><h3>Piwik Tracking</h3></a>      

Asynchronous queue log set to Piwik after every transactional email event  

Test Server:

https://asia-cloud-test-48-duyang.matomo.cloud/index.php

username: duyanguk   

password: 3yzHyGh44y
   
![Alt text](./public/imgs/matomo.png?raw=true "Title")
    
<a name="webhook_anchor"><h1>Web Hook</h1></a>   

An API for Mailjet to call back about email events 

 > Address(set up this callback address in Mailjet)
        
    https://username:password@www.domain.com/api/mailjet/callback    
 
 > Authentication : Base Auth
    
     $username = config('services.mailjet.callback.username');
     $password = config('services.mailjet.callback.password');
    
<a name="tests_anchor"><h1>Tests</h1></a>

Utilizing artisan command for service testing. 

<a name="email_services_test"><h3>Email Services Test</h3></a>

Account Confirm Email

 > 
    php artisan account:confirm

Welcome Email

 > 
    php artisan confirm:welcome

Reset Password Email

 > 
    php artisan reset:password

Price Alert Email

 > 
    php artisan price:alert

<a name="contact_services_test"><h3>Contact Services Test</h3></a>

 > 
    php artisan contact

<a name="contact_mega_services_test"><h3>Contact MegaData Services Test</h3></a>

 > 
    php artisan megaData

<a name="contact_list_services_test"><h3>Contact List Services Test</h3></a>

 > 
    php artisan contact:list

<a name="webhook_api_test"><h3>Webhook API Test</h3></a>

send post request in postman, set header with base auth

![Alt text](./public/imgs/webhook.jpg?raw=true "Title")


<a name="todos_anchor"><h1>Todos</h1></a>

1. Handle webhook callback data

2. A local logging system for every action

3. Redis pub/sub connection  

<a name="bugs_anchor"><h1>Bugs</h1></a>

| Description        | Reason   |  Fix Method     | Level   |
| --------   | -----:  | :----:  | :----:  |
| can't send email to original price alert template, maijet shows email blocked     | Unknown   |  Copy template     |  Minor    |


