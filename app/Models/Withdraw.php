<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $table = 'account_withdraws';

    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
