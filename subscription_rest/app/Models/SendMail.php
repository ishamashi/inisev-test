<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SendMail extends Model
{
    protected $table = 'send_mail';
    protected $fillable = [
        'user_id',
        'post_id',
        'sent_success'
    ];
}
