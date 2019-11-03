# Mailjet Email Service
    
* [Installation](#installation)
   * [Server Requirements](#server_requirements)
   * [Install&config](#install_config)
* [Pragmatic REST](#pragmatic-rest)
* [RESTful URLs](#restful-urls)
* [HTTP Verbs](#http-verbs)
* [Responses](#responses)
* [Error handling](#error-handling)
* [Versions](#versions)
* [Record limits](#record-limits)
* [Request & Response Examples](#request--response-examples)
* [Mock Responses](#mock-responses)
* [JSONP](#jsonp)


<a name="installation"><h1>installation</h1></a>

<a name="server_requirements"><h4>Server Requirements </h4></a>

  * PHP >= 7.2.0
  * Mysql
 
 <a name="install_config"><h4>install&config</h4></a> 
   >  
    git clone  git@github.com:jaime48/mailjet-service.git
   >   
    cd /path/to/project  &  composer install

 Edit .env
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
    
 Run     
   >           
    php artisan migrate
    php artisan queue:work
    php artisan redis:subscribe(TBD)
