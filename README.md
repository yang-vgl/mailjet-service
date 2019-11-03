# Mailjet Email Service
    
* [Installation](#installation)
   * [Server Requirements](#server_requirements)
   * [Install&config](#install_config)
* [Architecture](#architecture)
   * [Config](#config)
   * [Contracts](#contracts)
   * [Services](#services)
        * [Basic Services](#base_services)
        * [Email Services](#email_services)
        * [Contact Services](#email_services)
   * [Templates](#templates)
* [Unified Response](#response)
* [Tests](#tests)
    * [Email Services Test](#email_services_test)
    * [Contact Services Test](#contact_services_test)
    * [Contact MegaData Services Test](#contact_mega_services_test)
* [Todos](#todos)
* [Bugs](#bugs)

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

<a name="base_services "><h3>Basic Services</h3></a>

 >
    /app/Services/Base/*

Basic services that implement contracts interfaces with Mailjet Server.

 >
    /app/Services/Emails/*

Services that send transactional emails

 >
    /app/Services/Contact/*
    
Services that manage contacts and attributes
