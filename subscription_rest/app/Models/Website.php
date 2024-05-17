<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    protected $fillable = [
        'name',
        'url'
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);    
    }
}
