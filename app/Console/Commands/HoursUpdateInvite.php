<?php

namespace App\Console\Commands;

use App\Models\Invite;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HoursUpdateInvite extends Command
{
    protected $signature = 'hoursUpdateInvite';

    protected $description = '每小时更新邀请奖励信息';


    public function __construct()
    {
        parent::__construct();

    }

    public function handle()
    {

        try {
            //todo 目前只有二级分类.level_relation为父id,可直接使用,后期若层级增加需额外处理
            //todo 手动提现时流程很长,可直接通过balance获取用户收益,接入自动提现后,需修改为根据benefits来获取用户历史收益
            $invitedList = User::where('level_relation', '!=', 0)->get(['id', 'level_relation', 'balance']);
            $effectiveInvite = config('pdd.effective_invite');
            $inviteReward = config('pdd.invite_reward');

            foreach ($invitedList as $item) {
                if ($item->balance > $effectiveInvite) {

//                    DB::connection()->enableQueryLog();

                    $isInvited = Invite::where([
                        'user_id' => $item->level_relation,
                        'invite_uid' => $item->id,
                    ])->first();

                    if (!$isInvited) {
                        DB::transaction(function () use ($item, $inviteReward) {
                            Invite::create([
                                'user_id' => $item->level_relation,
                                'invite_uid' => $item->id,
                                'benefit' => $inviteReward,
                            ]);

                            User::where('id', $item->level_relation)->increment('balance', $inviteReward);

                            Log::info('邀请奖励:邀请人:' . $item->level_relation . '被邀请人:' . $item->id);
                        });
                    }

//                    Log::info(DB::getQueryLog());
                }
            }

        } catch (\Exception $exception) {
            Log::error('minutesUpdateOrder exception: '
                . $exception->getMessage()
                . $exception->getTraceAsString());
        }
    }
}
