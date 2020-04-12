<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use  Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'phone', 'password','invitation_code','level_relation','balance'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }


    public function invites()
    {
        return $this->hasMany(Invite::class,'user_id','id')->where('invite_promotion.status',Invite::STATUS_FINISH);
    }
}
