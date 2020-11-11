<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = ['tweet_link', 'tweet_content', 'user_id', 'tweet_status', 'writed_at'];
}
