<?php

namespace App\Helpers;
use Twitter ;
use App\Tweet;

class Helper
{
    public static function generateRandKey($length=32)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function getTweetsByTweetUsername($tweetUsername, $userId)
    {
        $resp = [] ;
        try{
            $resp = Twitter::getUserTimeline(['screen_name' => $tweetUsername, 'count' => 20, 'format' => 'array']);
        }
        catch (ErrorException $e){
            return $resp ;
        }

        # Tweetleri db'ye  varsa ekleme, yoksa ekle
        foreach ($resp as &$row) {

            $date = $row['created_at'];
            $date = date("Y-m-d H:i:s", strtotime($date));

            try{
                $contact = Tweet::firstOrCreate(
                    ['tweet_link' => (string)$row['id_str']],
                    [
                        'tweet_content' => $row['text'], 
                        'user_id' => $userId,
                        'tweet_link' => (string)$row['id_str'],
                        'writed_at' => $date
                    ]
                );
            }
            catch (ErrorException $e){
                continue ;
            }
        } 

        return $resp ;
    }

}