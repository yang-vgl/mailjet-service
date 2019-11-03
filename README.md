# Mailjet Email Service
    
* ### [Installation](#installation)
   * #### [Server Requirements](#server_requirements)
   * #### [ Install&config](#install_config)
* ### [Architecture](#architecture)
   * #### [Config](#config)
   * #### [Contracts](#contracts)
   * #### [Services](#services)
   * #### [Service Provider](#service_provider)
   * #### [Templates](#templates)
   * #### [Events&Listeners](#events_Listeners)
   * #### [Models](#models)
   * #### [Commands](#commands)
* ### [Unified Response](#response)
* ### [Service Documentation](#service_doc)
   * #### [Transactional Emails](#transactional_emails)
        * ##### [Account Confirm Email](#confirm_email)
        * ##### [Welcome Email](#welcome_email)
        * ##### [Reset Password Email](#reset_password_email)
        * ##### [Price Alert Email](#price_alert_email)
* ### [Tests](#tests)
    * [Email Services Test](#email_services_test)
    * [Contact Services Test](#contact_services_test)
    * [Contact MegaData Services Test](#contact_mega_services_test)
* ### [Todos](#todos)
* ### [Bugs](#bugs)

<a name="installation"><h1>installation</h1></a>

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
    php artisan migrate
    php artisan queue:work
    php artisan redis:subscribe(TBD)

<a name="architecture"><h1>Architecture</h1></a>

<a name="config"><h3>Config</h3></a>

Config for Mailjet APIs is located at

 >
    /config/services.php

add&edit:

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
             'Name' => "Cruise Team"
         ],
         //basic HTTP(s) Authentication for webhook callback
         'callback' => [
             'username' => 'username',
             'password' => 'password'
         ]
     ]

<a name="contracts"><h3>Contracts</h3></a>
 >
    /app/Contracts/*
interfaces that define core services for integrating with third-party mail server.
 
<a name="services"><h3>Services</h3></a>

Basic services that implement contracts interfaces with Mailjet Server.
 >
    /app/Services/Base/*

Services that send transactional emails

 >
    /app/Services/Emails/*

Services that manage contacts and attributes

 >
    /app/Services/Contact/*
    
<a name="service_provider"><h3>Service Provider</h3></a>

Denpendency Injections for Mailjet Server Services

  >
    /app/Providers/MailServiceProvider.php
        
<a name="templates"><h3>Templates</h3></a>

Templates classes for transactional emails corresponding to the templates defined in Mailjet 

 >
    /app/Templates/*


<a name="events_Listeners"><h3>Events&Listeners</h3></a>

Events&Listeners triggering transactional emails integrating with templates

 >
    /app/Events/*
    /app/Listeners/*
    
<a name="models"><h3>Models</h3></a>

Contains models for Mailjet Components, e.g. contacts, contacts attributes.

 >
    /app/Models/*

<a name="commands"><h3>Commands</h3></a>

executable scripts for testing and Redis pub/sub 

 >
    /app/Console/Commands/*

<a name="response"><h1>Unified Response</h1></a>

All services return same formation of standardized response
 >
    {
      "status": true, 
      "msg": "", // error message if status is false
      "data": {
            ...
          }  // response data if any
    }

<a name="service_doc"><h1>Service Documentation</h1></a>

<a name="transactional_emails"><h3>Transactional Emails</h3></a>

<a name="confirm_email"><h4>Account Confirm Email</h4></a>

 > Trigger

    event(new AccountCreate($data));
 
 > Parameters
   
    $data = [
        'recipients' =>[
            'email' => $toEmail, //(required) recipient's email
                'name' => $toName  // (optional) recipient's name
            ],
            'fromEmail' => $fromEmail, //(optional) recipient's email
            'fromName' => $fromName,  //(optional) recipient's email
            'link' => $link,           //(required) link for confirming registration
            'subject' => $subject,      //(optional)
           ];
           
<a name="welcome_email"><h4>Welcome Email</h4></a>

 > Trigger

    event(new AccountConfirmEvent($data));

 > Parameters
   
    $data = [
        'recipients' => [
            'email' => $toEmail, //(required)
            'name'  => $toName   //(optional)
        ],
        'fromEmail' => $fromEmail, //(optional)
        'fromName' => $fromName,   //(optional)
        'subject' => $subject,     //(optional)
    ];
               
<a name="reset_password_email"><h4>Reset Password Email</h4></a>

 > Trigger

    event(new ForgetPassword($data));

 > Parameters
   
    $data = [
        'recipients' =>[
            'email' => $toEmail,  //(required)
            'name' => $toName     //(optional)
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
        'fromEmail' => 'info@cruisewatch.com',                  //(optional)
        'fromName' => 'Cruise Watch',                           //(optional)
        "links"=> [
            'details' => 'https://www.cruisewatch.com/',        //(required) variable in the template
            "configure"=>"https://www.cruisewatch.com/",        //(required) variable in the templat
            "unsubscribe"=>"https://www.cruisewatch.com/"       //(required) variable in the templat
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
 
