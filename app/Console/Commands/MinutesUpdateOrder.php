<?php

namespace App\Console\Commands;

use App\Models\Benefit;
use App\Models\Order;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SmartJson\Pdd\Api\Request\PddDdkOrderListIncrementGetRequest;
use SmartJson\Pdd\PopHttpClient;


class MinutesUpdateOrder extends Command
{
    protected $signature = 'minutesUpdateOrder';

    protected $description = '每5分钟更新订单信息';


    public function __construct()
    {
        parent::__construct();

    }

    public function handle()
    {
        try {

            Log::info('开始处理');
            //获取db里最新修改时间为起始时间
            $startTime = strtotime('-5 minutes');
            $page = 1;

            $client = new  PopHttpClient();
            $request = new PddDdkOrderListIncrementGetRequest();

            $request->setStartUpdateTime($startTime);
            $request->setEndUpdateTime(time());
            $request->setReturnCount(false);


            $content = Arr::get($client->getRes($request), 'order_list_get_response', []);

            while (!empty(Arr::get($content, 'order_list'))) {
                $this->handleOrders($content);

                $page = $page + 1;
                $request->setPage($page);
                $content = $client->getRes($request);
            }

        } catch (\Exception $exception) {
            Log::error('minutesUpdateOrder exception: '
                . $exception->getMessage()
                . $exception->getTraceAsString());
        }
    }

    public function handleOrders($content)
    {
        $orderList = Arr::get($content, 'order_list');

        foreach ($orderList as $pddOrder) {


            list($levelRelation, $userId) = explode('**', $pddOrder['custom_parameters']);

            $promoteBenefit = intval($pddOrder['promotion_amount'] * config('pdd.promotion_rate'));
//            DB::connection()->enableQueryLog();

            //创建订单
            $order = DB::transaction(function () use ($pddOrder, $userId, $levelRelation, $promoteBenefit) {

                $verifyAt = Arr::get($pddOrder, 'order_verify_time');
                $receiveAt = Arr::get($pddOrder, 'order_receive_time');

                $order = Order::updateOrCreate(['order_sn' => $pddOrder['order_sn']], [
                    'user_id' => $userId,
                    'goods_id' => $pddOrder['goods_id'],
                    'goods_name' => $pddOrder['goods_name'],
                    'goods_price' => $pddOrder['goods_price'],
                    'order_amount' => $pddOrder['order_amount'],
                    'order_sn' => $pddOrder['order_sn'],
                    'order_create_time' => date('Y-m-d H:i:s', $pddOrder['order_create_time']),
                    'order_group_success_time' => date('Y-m-d H:i:s', $pddOrder['order_group_success_time']),
                    'order_pay_time' => date('Y-m-d H:i:s', $pddOrder['order_pay_time']),
                    'order_verify_time' => $verifyAt ? date('Y-m-d H:i:s', $verifyAt) : $verifyAt,
                    'order_receive_time' => $receiveAt ? date('Y-m-d H:i:s', $receiveAt) : $receiveAt,
                    'order_modify_at' => date('Y-m-d H:i:s', $pddOrder['order_modify_at']),
                    'fail_reason' => Arr::get($pddOrder, 'fail_reason', ''),
                    'batch_no' => Arr::get($pddOrder, 'batch_no'),

                    'status' => $pddOrder['order_status'],
                    'actual_promotion_amount' => $pddOrder['promotion_amount'],
                    'image_url' => $pddOrder['goods_thumbnail_url'],
                    'goods_quantity' => $pddOrder['goods_quantity'],
                ]);

                //创建收益
                $superBenefit = 0;
                //上层抽佣,目前只有两层.则level_relation里只有一个上级,直接给上级抽佣
                if ($levelRelation) {
                    $superBenefit = $this->getSuperBenefits($promoteBenefit);

                    Benefit::firstOrCreate([
                        'order_id' => $order->id,
                        'user_id' => $levelRelation,


                    ], [
                        'level_relation' => 0,
                        'benefit' => $superBenefit,
                        'type' => Benefit::TYPE_SUPERIOR,
                        'status' => Benefit::STATUS_ING
                    ]);

                }

                Benefit::firstOrCreate(
                    [
                        'order_id' => $order->id,
                        'user_id' => $order->user_id,
                    ], [
                    'benefit' => $promoteBenefit - $superBenefit,
                    'type' => Benefit::TYPE_BENEFIT,
                    'status' => Benefit::STATUS_ING,
                    'level_relation' => $levelRelation
                ]);

                Log::info('拼多多订单创建或更新:订单id:' . $pddOrder['order_sn'] . ', 订单状态:' . $pddOrder['order_status']);

                return $order;
            });


            //已通过订单计算抽佣
            $benefitStatus = Benefit::where([
                'order_id' => $order->id,
                'user_id' => $userId
            ])->value('status');


            if ($benefitStatus == Benefit::STATUS_ING && ($order->status == Order::STATUS_PASS or $order->status == Order::STATUS_FINISH)) {
                DB::transaction(function () use ($order, $promoteBenefit, $levelRelation) {

                    $superBenefit = 0;
                    if ($levelRelation) {
                        $superBenefit = $this->getSuperBenefits($promoteBenefit);

                        $superStatus = Benefit::where([
                            'order_id' => $order->id,
                            'user_id' => $levelRelation
                        ])->value('status');

                        if ($superStatus == Benefit::STATUS_ING) {
                            //更新余额
                            User::where('id', $levelRelation)->increment('balance', $superBenefit);
                            //更新状态
                            Benefit::where([
                                'order_id' => $order->id,
                                'user_id' => $levelRelation
                            ])->update(['status' => Benefit::STATUS_FINISH]);
                        } else {
                            Log::error('团长团员佣金状态不一致,订单id:' . $order->id);
                        }
                    }


                    //更新余额
                    User::where('id', $order->user_id)->increment('balance', $promoteBenefit - $superBenefit);

                    //更新订单抽佣标志为已抽佣
                    Benefit::where([
                        'order_id' => $order->id,
                        'user_id' => $order->user_id
                    ])->update(['status' => Benefit::STATUS_FINISH]);

                    Log::info('拼多多订单完成:订单id:' . $order->order_sn . ', 订单状态:' . $order->status);

                });
            }
//            Log::info(DB::getQueryLog());
        }
    }

    private function getSuperBenefits($benefits)
    {
        return $benefits * config('pdd.level_promotion_rate');
    }
}
