# Mailjet Email Service
    
* [Installation](#installation)
   * [Server Requirements](#server_requirements)
   * [Install&config](#install&config)
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


<a name="installation">installation</a>

Server Requirements 
#server_requirements
  * PHP >= 7.2.0
  * Mysql
  
#install&config
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
