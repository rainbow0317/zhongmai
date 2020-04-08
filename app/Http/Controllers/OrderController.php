<?php

namespace App\Http\Controllers;

use App\Exceptions\ServiceException;
use App\Models\Benefit;
use App\Models\Invite;
use App\Models\Order;

use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{

    private $amount; //各类金额统计

    private function getAmount()
    {
        $user = Auth::user();

        DB::connection()->enableQueryLog();  // 开启QueryLog

        //今日收益
        $todayAmount = Benefit::where('user_id', $user->id)
            ->where('updated_at', '>=', date('Y-m-d'))
            ->sum('benefit');


        //待收收益
        $incomeAmount = Benefit::where(['user_id' => $user->id, 'status' => Benefit::STATUS_ING])
            ->sum('benefit');

        $sumAmount = Benefit::where(['user_id'=>$user->id,'status'=>Benefit::STATUS_FINISH])
            ->sum('benefit');


        $this->amount = [
            'inviteCode' => $user->invitation_code,
            'sum' => round($sumAmount / 100, 2),
            'todayAmount' => round($todayAmount / 100, 2),
            'incomeAmount' => round($incomeAmount / 100, 2),
        ];
    }

    /**
     * 我的推广
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function income()
    {
        try {
//            DB::connection()->enableQueryLog();  // 开启QueryLog

            $userId = Auth::user()->id;

            //待收益推广
            $incomOrders = Benefit::leftJoin('promote_orders', 'promote_orders.id', '=', 'benefits.order_id')
                ->where([
                    'benefits.user_id'=>$userId,
                    'benefits.status'=>Benefit::STATUS_ING
                ])
                ->orderBy('benefits.id', 'desc')
                ->select([
                    'promote_orders.goods_name as name',
                    'promote_orders.created_at as time',
                    'promote_orders.order_amount as amount',
                    'promote_orders.image_url as imageUrl',
                    'promote_orders.status as status',
                    'benefits.benefit as benefit',
                    'benefits.type as type',

                ])
                ->paginate();

//            Log::info(DB::getQueryLog());

            //处理前台数据显示
            foreach ($incomOrders as &$order) {
                $order->promotion = round($order->benefit / 100, 2);
                $order->amount = round($order->amount / 100, 2);
                $order->statusDesc = Order::getStatusDes($order->status);
            }

            $this->getAmount();
            $this->amount['incomeOrders'] = $incomOrders;

            return view('orders.index', $this->amount);

        } catch (\Exception $exception) {
            Log::error(' exception: '
                . $exception->getMessage()
                . $exception->getTraceAsString());
            return view('pages.error', ['msg' => '请稍后重试']);
        }
    }

    public function history()
    {
        try {
            $userId = Auth::user()->id;

            //已完成推广'users.id', '=', 'invite_promotion.invite_uid'
            $orders = Benefit::leftJoin('promote_orders', 'promote_orders.id', '=', 'benefits.order_id')
                ->where([
                    'benefits.user_id'=>$userId,
                    'benefits.status'=>Benefit::STATUS_FINISH
                ])
                ->orderBy('benefits.id', 'desc')
                ->select([
                    'promote_orders.goods_name as name',
                    'promote_orders.created_at as time',
                    'promote_orders.order_amount as amount',
                    'promote_orders.image_url as imageUrl',
                    'promote_orders.status as status',
                    'promote_orders.fail_reason as fail_reason',
                    'benefits.benefit as benefit',
                    'benefits.type as type',

                ])
                ->paginate();

            //处理前台数据显示
            foreach ($orders as &$order) {
                $order->benefit = round($order->benefit / 100, 2);
                $order->amount = round($order->amount / 100, 2);
                $order->statusDesc = Order::getStatusDes($order->status);
                $order->type = Benefit::getTypeDes($order->type);
            }

            $this->getAmount();
            $this->amount['orders'] = $orders;

            return view('orders.records', $this->amount);
        } catch (\Exception $exception) {
            Log::error(' exception: '
                . $exception->getMessage()
                . $exception->getTraceAsString());
            return view('pages.error', ['msg' => '请稍后重试']);
        }
    }

    public function invite()
    {
        try {
            $user = Auth::user();
            if (!$user->invitation_code) {
                throw new ServiceException('您还不能邀请新人');
            }
            $inviteLink = env('APP_URL') . '/register?' . $user->invitation_code;

            $invites = User::leftJoin('invite_promotion','users.id', '=', 'invite_promotion.invite_uid')
                ->where('level_relation', $user->id)
                ->select(['users.phone as name', 'invite_promotion.benefit as benefit','invite_promotion.status as status'])
                ->orderBy('invite_promotion.id', 'desc')
                ->paginate();

            $this->getAmount();
            $res = $this->amount;
            $res['inviteLink'] = $inviteLink;
            $res['invites'] = $invites;

            $res['effectiveInvite'] = config('pdd.effective_invite') / 100;
            $res['inviteReward'] = config('pdd.invite_reward') / 100;


            return view('orders.invite', $res);
        } catch (\Exception $exception) {
            Log::error(' exception: '
                . $exception->getMessage()
                . $exception->getTraceAsString());
            return view('pages.error', ['msg' => '请稍后重试']);
        }
    }

    public function withdraw()
    {
        $user = Auth::user();

        $list = Withdraw::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate();

        return view('orders.withdraw', [
            'sum' => round($user->balance / 100, 2),
            'name' => $user->phone,
            'withdraws' => $list,
        ]);
    }


    public function withdrawSubmit(Request $request)
    {
        $user = Auth::user();
        $amount = $request->input('amount') * 100;

        if ($amount < 100 || $amount > 10000) {
            return (['msg' => '提现金额必须为1-100元之间']);
        }

        if ($amount > $user->balance) {
            return (['msg' => '余额不足']);
        }
        DB::transaction(function () use ($amount, $user) {

            Withdraw::create(
                [
                    'user_id' => $user->id,
                    'amount' => $amount,
                ]
            );
            User::where('id', $user->id)->decrement('balance', $amount);

        });
    }


}
