<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Order extends Model
{
    const STATUS_CREATED = -1;
    const STATUS_PAYED = 0;
    const STATUS_GROUPED = 1;
    const STATUS_CONFERM = 2;
    const STATUS_PASS = 3;
    const STATUS_FAIL = 4;
    const STATUS_FINISH = 5;
    const STATUS_NO_PROMOTION = 8;

    const PROMOTED_FLAG_FINISH = 1;
    const UN_PROMOTION = 0;

    protected $table = 'promote_orders';

    protected  $guarded =[];

    public static function getStatusDes($status)
    {
        $statusArray = [
            -1 => '未支付',
            0 => '已支付',
            1 => '已成团',
            2 => '确认收货',
            3 => '审核成功',
            4 => '审核失败',
            5 => '已经结算',
            8 => '非多多进宝商品（无佣金订单）',
        ];

        return Arr::get($statusArray, $status, '状态未知,请稍后再试');
    }

    public function benefit()
    {
        return $this->hasMany(Benefit::class, 'order_id');
    }

}
