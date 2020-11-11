<?php
use Faker\Generator as Faker;
use App\User;

$factory->define(App\Tweet::class, function (Faker $faker) {
    return [
            'tweet_content' => "tweet content ",
            'user_id' => factory (User :: class)->create ([
            'fullname' => 'mehmet çelik',
            'email' => 'mehmet.celik@gmail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'phone' => 'asdsadsadasda',
            'twitter_name' => 'reterius',
            'email_act_code' => 'asdsadsadasda',
            'email_act_status' => '0'
        ])->id,
        'tweet_link' => "qweqweqwewq", 
        'tweet_status' => '0'
    ];
});