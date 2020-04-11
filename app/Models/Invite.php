<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Invite extends Model
{
    protected $table = 'invite_promotion';

    protected $guarded = [];

    const STATUS_ING = 0;
    const STATUS_FINISH = 1;

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
