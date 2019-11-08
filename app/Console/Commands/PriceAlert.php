<?php

namespace App\Console\Commands;

use App\Events\PriceChange;
use Illuminate\Console\Command;

class PriceAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'price:alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'trigger price change even to send price alert email';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Two many arguments, for testing please change data manually');
        $data = [
            //optional
            //'subject' => 'Price Alert',
            //optional
            //'fromEmail' => 'info@cruisewatch.com',
            //optional
            //'fromName' => 'Cruise Watch',
            "links"=> [
                'details' => 'https://www.cruisewatch.com/',
                "configure"=>"https://www.cruisewatch.com/",
                "unsubscribe"=>"https://www.cruisewatch.com/"
            ],
            "alert" => [
                "trip_name"=>"Trip to Africa",
                "ship_name"=>"Chief Running Water",
                "departure_date"=>"2019/12/12 12:01:12",
                "prices"=> [
                    [
                        'is_drop' => 1,
                        'cabin_type' =>'luxury',
                        'current' => 1100,
                        'change_abs' =>100,
                        'change_rel' => 2,
                        'updated_at' => '2019/11/10 12:01:12',
                    ],
                    [
                        'is_drop' => 0,
                        'cabin_type' =>'economic',
                        'current' => 500,
                        'change_abs' => 100,
                        'change_rel' => 3,
                        'updated_at' => '2019/11/10 12:01:12',
                    ]
                ]
            ],
            'recipients' =>[
                [
                    'email' => 'duyanguk@163.com',
                    //optional
                    'name' => 'Yang'
                ],
                [
                    'email' => 'duyang48484848@gmail.com',
                ],
            ]
        ];
        event(new PriceChange($data));
    }
}
