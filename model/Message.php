<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'user_id',
        'char_id',
        'human',
        'ai'
    ];

    protected $table = "chat_history";    
}