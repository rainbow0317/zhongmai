<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Benefit extends Model
{
//分润类型，1直接抽佣 2上级抽佣 3邀请抽佣
    const  TYPE_BENEFIT = 1;
    const  TYPE_SUPERIOR = 2;
    const  TYPE_INVITE = 3;

    protected $table = 'benefits';

//    protected $dateFormat = 'U';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }

    public static function getTypeDes($status)
    {
        $statusArray = [
            1 => '直接抽佣',
            2 => '上级抽佣',
        ];

        return Arr::get($statusArray, $status, '状态未知,请稍后再试');
    }


}
