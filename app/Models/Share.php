<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    protected $table = 'share_records';

    protected  $guarded =[];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
